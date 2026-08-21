<?php
ob_start();
require_once '../config/condb.php';
ob_clean();
header('Content-Type: application/json; charset=UTF-8');

$month = isset($_GET['month']) ? (int)$_GET['month'] : (int)date('m');
$year  = isset($_GET['year'])  ? (int)$_GET['year']  : (int)date('Y');

$sql = "SELECT price_date, price_per_kg FROM daily_rubber_price
        WHERE YEAR(price_date) = $year AND MONTH(price_date) = $month
        ORDER BY price_date DESC";

$result = mysqli_query($con, $sql);

$rows = [];
while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
}

echo json_encode(['success' => true, 'data' => $rows], JSON_UNESCAPED_UNICODE);
