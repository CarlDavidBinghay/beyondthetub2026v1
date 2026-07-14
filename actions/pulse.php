<?php
require_once __DIR__ . '/../includes/functions.php';

header('Content-Type: application/json');

if (!hash_equals(ADMIN_CODE, (string)($_GET['code'] ?? ''))) {
    http_response_code(403);
    echo json_encode(['error' => 'Nope.']);
    exit;
}

$orders = all_orders();
$latest = $orders[0] ?? null;

echo json_encode([
    'count'  => count($orders),
    'latest' => $latest ? [
        'reference' => $latest['reference'],
        'name'      => $latest['customer']['name'],
        'total'     => money($latest['totals']['total']),
        'payment'   => $latest['payment']['method'],
    ] : null,
    'stock_left' => stock_total_left(),
]);
