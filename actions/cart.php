<?php
require_once __DIR__ . '/../includes/functions.php';

header('Content-Type: application/json');

$in     = json_decode(file_get_contents('php://input'), true) ?: [];
$action = $in['action'] ?? '';
$id     = (string)($in['id'] ?? '');
$size   = (int)($in['size'] ?? 0);
$qty    = (int)($in['qty'] ?? 1);

if (!csrf_ok($in['csrf'] ?? null)) {
    http_response_code(419);
    echo json_encode(['error' => 'Your session expired. Refresh the page.']);
    exit;
}

switch ($action) {
    case 'add':
        $product = find_product($id);
        if (!$product || !isset($product['sizes'][$size])) {
            http_response_code(422);
            echo json_encode(['error' => 'That size does not exist.']);
            exit;
        }
        $canAdd = stock_available($id, $size);
        if ($canAdd <= 0) {
            http_response_code(409);
            echo json_encode(['error' => 'That size is sold out for this batch.']);
            exit;
        }
        if ($qty > $canAdd) {
            cart_add($id, $size, $canAdd);
            echo json_encode(cart_state("Only {$canAdd} left — we added what we had."));
            exit;
        }
        cart_add($id, $size, max(1, $qty));
        break;

    case 'set':
        cart_set($id, $size, $qty);
        break;

    case 'remove':
        cart_set($id, $size, 0);
        break;

    case 'clear':
        cart_clear();
        break;

    case 'read':
        break;

    default:
        http_response_code(400);
        echo json_encode(['error' => 'Unknown action.']);
        exit;
}

echo json_encode(cart_state());

function cart_state(string $notice = ''): array
{
    $subtotal = cart_subtotal();
    return [
        'items'      => cart_items(),
        'count'      => cart_count(),
        'subtotal'   => $subtotal,
        'subtotal_f' => money($subtotal),
        'notice'     => $notice,
    ];
}
