<?php
// เชื่อมต่อฐานข้อมูล
include('../config/condb.php');

// ตรวจสอบว่ามีการส่งข้อมูลหรือไม่
if (isset($_POST['btn_submit'])) {
    // รับค่าจากฟอร์ม
    $c_id = $_POST['c_id'];
    $em_id = $_POST['em_id'];
    $rr_date = $_POST['rr_date'];
    $rr_quantity = $_POST['rr_quantity'];
    $rr_price = $_POST['rr_price'];
    $total_price = $rr_quantity * $rr_price;

    // สร้างคำสั่ง SQL สำหรับบันทึกข้อมูล
    $sql = "INSERT INTO rubber_receiving (c_id, em_id, rr_date, rr_quantity, rr_price, total_price)
            VALUES ('$c_id', '$em_id', '$rr_date', '$rr_quantity', '$rr_price', '$total_price')";

    // เรียกใช้คำสั่ง SQL เพื่อบันทึกข้อมูลลงฐานข้อมูล
    if (mysqli_query($con, $sql)) {
        echo "<script>alert('บันทึกข้อมูลสำเร็จ'); window.location.href='../views/daily_rubber_receive.php';</script>";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>
