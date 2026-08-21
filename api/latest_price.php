<?php
ob_start(); // บัฟเฟอร์ output ป้องกัน HTML รั่ว

require_once "../config/condb.php";

ob_clean(); // ล้าง HTML ที่อาจหลุดออกมาจาก include
header("Content-Type: application/json; charset=UTF-8");

$sql = "
    SELECT
        price_date,
        factory,
        province,
        rubber_type,
        price,
        unit
    FROM rubber_prices
    ORDER BY price_date DESC
    LIMIT 1
";

$result = mysqli_query($con, $sql);

if (!$result) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => mysqli_error($con)]);
    exit;
}

$data = mysqli_fetch_assoc($result);

echo json_encode([
    "success" => true,
    "data" => $data
], JSON_UNESCAPED_UNICODE);

?>