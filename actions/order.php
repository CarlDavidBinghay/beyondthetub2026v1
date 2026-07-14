<?php
require_once __DIR__ . '/../includes/functions.php';

header('Content-Type: application/json');

if (!csrf_ok($_POST['csrf'] ?? null)) {
    http_response_code(419);
    echo json_encode(['error' => 'Your session expired. Refresh the page and try again.']);
    exit;
}

$items = cart_items();
if (!$items) {
    http_response_code(422);
    echo json_encode(['error' => 'Your order is empty.']);
    exit;
}

// Check this BEFORE touching stock — otherwise a failed save eats tubs that were never sold.
if (!storage_writable(STORAGE_DIR)) {
    http_response_code(500);
    echo json_encode([
        'error' => 'The shop cannot save orders right now — storage is not writable. Open setup.php for the one-line fix.',
    ]);
    exit;
}

$val = fn(string $k) => trim((string)($_POST[$k] ?? ''));

$date      = $val('date');
$slot      = $val('slot');
$name      = $val('name');
$phone     = $val('phone');
$email     = $val('email');
$referral  = $val('referral');
$referrer  = $val('referral_name');
$method    = $val('delivery');
$payment   = $val('payment');
$payRef    = $val('payment_reference');

$errors = [];

if (!is_production_date($date))                    $errors[] = 'That production date is no longer open.';
if (!in_array($slot, TIME_SLOTS, true))            $errors[] = 'Pick a handover window.';
if ($name === '')                                  $errors[] = 'We need a name.';
if (strlen(preg_replace('/\D/', '', $phone)) < 7)  $errors[] = 'That mobile number looks wrong.';
// Email is optional now — only complain if they typed something that isn't an email.
if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'That email address looks wrong. Leave it blank if you would rather not give one.';
}
if (!in_array($referral, REFERRAL_SOURCES, true))  $errors[] = 'Tell us how you heard about us.';
if (!isset(DELIVERY_METHODS[$method]))             $errors[] = 'Choose delivery or pickup.';
if (!isset(PAYMENT_METHODS[$payment]))             $errors[] = 'Choose a payment method.';

$needsAddress = !empty(DELIVERY_METHODS[$method]['needs_address']);
$needsProof   = !empty(PAYMENT_METHODS[$payment]['needs_proof']);

if ($needsAddress) {
    if (strlen($val('address')) < 10)  $errors[] = 'The address is too short — add the street and barangay.';
    if ($val('city') === '')           $errors[] = 'Choose the city or municipality.';
    if ($val('landmark') === '')       $errors[] = 'Add a landmark so the rider can find you.';
    if ($val('recipient') === '')      $errors[] = 'Tell us who receives the order.';
    if (strlen(preg_replace('/\D/', '', $val('recipient_phone'))) < 7) {
        $errors[] = 'Add a contact number for whoever receives it.';
    }
}

if ($needsProof) {
    if (strlen($payRef) < 4)                                    $errors[] = 'Add the payment reference number.';
    if (($_FILES['proof']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        $errors[] = 'Attach a screenshot of your payment.';
    }
    if (!storage_writable(PROOF_DIR)) {
        $errors[] = 'We cannot store screenshots right now — storage/proofs is not writable. Open setup.php.';
    }
}

if ($errors) {
    http_response_code(422);
    echo json_encode(['error' => implode(' ', $errors)]);
    exit;
}

// Totals come from the catalogue, never from the browser.
$subtotal = cart_subtotal();
$fee      = delivery_fee($method);
$total    = $subtotal + $fee;

// Take the stock before anything else — if someone beat us to the last tub, stop here.
$reserve = array_map(fn($i) => ['id' => $i['id'], 'size' => $i['size'], 'qty' => $i['qty']], $items);
if (!stock_take($reserve)) {
    http_response_code(409);
    echo json_encode(['error' => 'Someone took the last tub while you were checking out. Go back and adjust your order.']);
    exit;
}

$reference = order_reference();

$proofPath = '';
if ($needsProof) {
    $saved = save_proof($_FILES['proof'], $reference);
    if (isset($saved['error'])) {
        // Give the stock back — the order never happened.
        $stock = stock_all();
        foreach ($reserve as $r) {
            $stock[$r['id'] . '|' . $r['size']] += $r['qty'];
        }
        stock_save($stock);
        http_response_code(422);
        echo json_encode(['error' => $saved['error']]);
        exit;
    }
    $proofPath = $saved['path'];
}

$needsLocation = !empty(DELIVERY_METHODS[$method]['send_location']);

$order = [
    'reference' => $reference,
    'placed_at' => date('c'),
    'status'    => $needsProof ? 'paid_needs_checking' : 'confirmed_cod',
    'schedule'  => [
        'date'       => $date,
        'date_label' => pretty_date($date),
        'slot'       => $slot,
    ],
    'customer'  => [
        'name'     => $name,
        'phone'    => $phone,
        'email'    => $email,
        'referral' => $referral,
        'referred_by' => $referrer,
    ],
    'delivery'  => [
        'method'  => $method,
        'label'   => DELIVERY_METHODS[$method]['label'],
        'fee'     => $fee,
        'quote_later' => !empty(DELIVERY_METHODS[$method]['quote_later']),
        'address' => $needsAddress ? $val('address') : '',
        'city'    => $needsAddress ? $val('city') : '',
        'landmark'        => $needsAddress ? $val('landmark') : '',
        'recipient'       => $needsAddress ? $val('recipient') : $name,
        'recipient_phone' => $needsAddress ? $val('recipient_phone') : $phone,
        'maps_link'       => $needsAddress ? $val('maps_link') : '',
        'notes'           => $needsAddress ? $val('notes') : $val('pickup_notes'),
        'is_pickup'       => !$needsAddress,
        // Pickup and self-booked riders need our location — admin sends it and ticks this off.
        'needs_location'  => $needsLocation,
        'location_sent'   => false,
    ],
    'payment'   => [
        'method'    => $payment,
        'label'     => PAYMENT_METHODS[$payment]['label'],
        'reference' => $needsProof ? $payRef : '',
        'proof'     => $proofPath,
    ],
    'items'     => array_map(fn($i) => [
        'name'    => $i['name'],
        'variant' => $i['variant'],
        'qty'     => $i['qty'],
        'price'   => $i['price'],
        'line'    => $i['line'],
    ], $items),
    'totals'    => ['subtotal' => $subtotal, 'delivery' => $fee, 'total' => $total],
];

if (!save_order($order)) {
    http_response_code(500);
    echo json_encode(['error' => 'We could not save the order. Check that storage/orders is writable.']);
    exit;
}

push_to_google_form($order);
notify_new_order($order);

cart_clear();
$_SESSION['last_order'] = $reference;

echo json_encode(['reference' => $reference, 'redirect' => 'confirmation.php?ref=' . $reference]);
