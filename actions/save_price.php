<?php
include('../config/condb.php');

// เมื่อกดบันทึก
if (isset($_POST['btn_submit'])) {
    $price_date = $_POST['price_date'];
    $price_per_kg = $_POST['price_per_kg'];

    // ตรวจสอบว่ามีราคาวันนี้อยู่หรือยัง
    $check_sql = "SELECT * FROM daily_rubber_price WHERE price_date = '$price_date'";
    $check_result = mysqli_query($con, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        // อัปเดตราคาวันนี้
        $update_sql = "UPDATE daily_rubber_price SET price_per_kg = '$price_per_kg' WHERE price_date = '$price_date'";
        mysqli_query($con, $update_sql);
    } else {
        // เพิ่มราคาวันนี้
        $insert_sql = "INSERT INTO daily_rubber_price (price_date, price_per_kg) VALUES ('$price_date', '$price_per_kg')";
        mysqli_query($con, $insert_sql);
    }

    // ดึงข้อมูลล่าสุดมาแสดง
    $sql = "SELECT * FROM daily_rubber_price ORDER BY price_date DESC";
    $result = mysqli_query($con, $sql);

    // แสดงผลข้อมูลในตาราง
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['price_date']}</td>
                <td>{$row['price_per_kg']}</td>
              </tr>";
    }
}
?>
