<?php
// 1. เชื่อมต่อ database
include('../config/condb.php');

// 2. รับค่าจากฟอร์ม และ sanitize
$c_name      = trim(mysqli_real_escape_string($con, $_POST['c_name']));
$c_add       = trim(mysqli_real_escape_string($con, $_POST['c_add']));
$c_tel       = trim(mysqli_real_escape_string($con, $_POST['c_tel']));
$em_name_new = isset($_POST['em_name_new']) ? trim(mysqli_real_escape_string($con, $_POST['em_name_new'])) : '';
$em_id_post  = isset($_POST['em_id'])       ? intval($_POST['em_id']) : 0;

// 3. ตรวจสอบข้อมูลพื้นฐาน
if (empty($c_name) || empty($c_add) || empty($c_tel)) {
    echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน'); history.back();</script>";
    exit;
}

// 4. หา em_id ที่จะใช้
$em_id = 0;

if ($em_id_post > 0) {
    // โหมด B: ใช้ลูกจ้างเดิมที่เลือกจาก dropdown
    $em_id = $em_id_post;

} elseif (!empty($em_name_new)) {
    // โหมด A: พิมพ์ชื่อใหม่ → ตรวจว่ามีชื่อนี้ในฐานข้อมูลแล้วหรือไม่
    $chk = mysqli_query($con, "SELECT em_id FROM employee WHERE em_name = '$em_name_new' LIMIT 1");
    if ($chk && mysqli_num_rows($chk) > 0) {
        // มีชื่อนี้อยู่แล้ว → ใช้ em_id เดิม
        $row_em = mysqli_fetch_assoc($chk);
        $em_id  = intval($row_em['em_id']);
    } else {
        // ยังไม่มี → INSERT ลูกจ้างใหม่
        $ins = mysqli_query($con, "INSERT INTO employee (em_name) VALUES ('$em_name_new')");
        if ($ins) {
            $em_id = mysqli_insert_id($con);
        }
    }
}

if ($em_id <= 0) {
    echo "<script>alert('กรุณาระบุลูกจ้างตัดให้ถูกต้อง'); history.back();</script>";
    exit;
}

// 5. INSERT ข้อมูลลูกค้า
$sql    = "INSERT INTO customer (c_name, c_add, c_tel, em_id)
           VALUES ('$c_name', '$c_add', '$c_tel', '$em_id')";
$result = mysqli_query($con, $sql) or die("Error in query: $sql " . mysqli_error($con));

// 6. ปิดการเชื่อมต่อ
mysqli_close($con);

// 7. แจ้งเตือนผลลัพธ์และ redirect
if ($result) {
    echo "<script type='text/javascript'>";
    echo "alert('เพิ่มข้อมูลลูกค้าเรียบร้อยแล้ว');";
    echo "window.location = '../index.php';";
    echo "</script>";
} else {
    echo "<script type='text/javascript'>";
    echo "alert('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');";
    echo "history.back();";
    echo "</script>";
}
?>
