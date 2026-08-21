<?php
ob_start();
require_once '../config/condb.php';
ob_clean();
header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$price_date = $_POST['price_date'] ?? '';
$price_per_kg = $_POST['price_per_kg'] ?? '';

if (!$price_date || !$price_per_kg) {
    echo json_encode(['success' => false, 'message' => 'ข้อมูลไม่ครบ']);
    exit;
}

// ป้องกัน SQL Injection เบื้องต้น
$price_date   = mysqli_real_escape_string($con, $price_date);
$price_per_kg = (float) $price_per_kg;

// ตรวจสอบว่ามีราคาวันนี้อยู่หรือยัง
$check = mysqli_query($con, "SELECT id FROM daily_rubber_price WHERE price_date = '$price_date'");

if (mysqli_num_rows($check) > 0) {
    $ok = mysqli_query($con, "UPDATE daily_rubber_price SET price_per_kg = $price_per_kg WHERE price_date = '$price_date'");
    $action = 'updated';
} else {
    $ok = mysqli_query($con, "INSERT INTO daily_rubber_price (price_date, price_per_kg) VALUES ('$price_date', $price_per_kg)");
    $action = 'inserted';
}

if ($ok) {
    echo json_encode(['success' => true, 'action' => $action]);
} else {
    echo json_encode(['success' => false, 'message' => mysqli_error($con)]);
}
