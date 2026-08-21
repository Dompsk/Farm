<?php
ob_start();
require_once '../config/condb.php';
ob_clean();
header('Content-Type: application/json; charset=UTF-8');

$today = date('Y-m-d');

$sql = "SELECT price_date, price_per_kg FROM daily_rubber_price
        WHERE price_date = '$today'
        LIMIT 1";

$result = mysqli_query($con, $sql);

if (!$result) {
    echo json_encode(['success' => false, 'message' => mysqli_error($con)]);
    exit;
}

$data = mysqli_fetch_assoc($result);

echo json_encode([
    'success' => true,
    'data'    => $data,   // null ถ้ายังไม่ได้บันทึกวันนี้
    'today'   => $today
], JSON_UNESCAPED_UNICODE);
