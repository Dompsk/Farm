<?php
require_once '../config/condb.php';

$sql = "CREATE TABLE IF NOT EXISTS `rubber_prices` (
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `price_date`  DATE         NOT NULL,
    `factory`     VARCHAR(100) NOT NULL,
    `province`    VARCHAR(50)  NOT NULL,
    `rubber_type` VARCHAR(50)  NOT NULL,
    `price`       DECIMAL(10,2) NOT NULL,
    `unit`        VARCHAR(20)  NOT NULL DEFAULT 'บาท/กก.',
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_price` (`price_date`, `factory`, `rubber_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

if (mysqli_query($con, $sql)) {
    echo "<h2 style='color:green;font-family:sans-serif;'>✅ สร้างตาราง rubber_prices สำเร็จ!</h2>";
    echo "<p style='font-family:sans-serif;'>ตอนนี้สามารถรัน <a href='tla_scraper.php'>tla_scraper.php</a> เพื่อดึงราคาล่าสุดได้แล้วครับ</p>";
} else {
    echo "<h2 style='color:red;font-family:sans-serif;'>❌ เกิดข้อผิดพลาด</h2>";
    echo "<pre>" . mysqli_error($con) . "</pre>";
}

mysqli_close($con);
?>
