<?php
// 1. เชื่อมต่อ database
include('../config/condb.php');

$em_id  = intval($_GET['ID']);
$referer = $_SERVER['HTTP_REFERER'] ?? '../views/em_list.php';

if ($em_id <= 0) {
    echo "<script>alert('รหัสลูกจ้างไม่ถูกต้อง'); history.back();</script>";
    exit;
}

// 2. ตรวจสอบว่ายังมีลูกค้าผูกอยู่หรือไม่
$chk    = mysqli_query($con, "SELECT COUNT(*) AS cnt FROM customer WHERE em_id = '$em_id'");
$row    = mysqli_fetch_assoc($chk);
$cnt    = intval($row['cnt']);

if ($cnt > 0) {
    // ยังมีลูกค้าผูกอยู่ → SET em_id เป็น NULL ก่อน (หรือจะ block ก็ได้)
    // ที่นี่เลือก SET NULL เพื่อไม่ให้ข้อมูลลูกค้าหายไป
    mysqli_query($con, "UPDATE customer SET em_id = NULL WHERE em_id = '$em_id'");
}

// 3. ลบลูกจ้าง
$result = mysqli_query($con, "DELETE FROM employee WHERE em_id = '$em_id'");

// 4. ปิด connection
mysqli_close($con);

// 5. แจ้งผลและ redirect กลับ em_list
if ($result) {
    echo "<script type='text/javascript'>";
    if ($cnt > 0) {
        echo "alert('ลบลูกจ้างเรียบร้อยแล้ว\\n(ลูกค้า {$cnt} รายที่เชื่อมโยงถูกยกเลิกการผูกแล้ว)');";
    } else {
        echo "alert('ลบลูกจ้างเรียบร้อยแล้ว');";
    }
    echo "window.location = '../views/em_list.php';";
    echo "</script>";
} else {
    echo "<script type='text/javascript'>";
    echo "alert('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');";
    echo "history.back();";
    echo "</script>";
}
?>
