<meta charset="UTF-8">
<?php
//1. เชื่อมต่อ database:
include('../config/condb.php');

//2. รับค่าจากฟอร์ม
$em_id = $_POST["em_id"];
$em_name = $_POST["em_name"];
$em_add = $_POST["em_add"];
$em_tel = $_POST["em_tel"];

//3. อัปเดตข้อมูลลูกจ้าง
$sql = "UPDATE employee SET  
        em_name = '$em_name',
        em_add = '$em_add',
        em_tel = '$em_tel'
        WHERE em_id = '$em_id'";

$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($con));

//4. ปิดการเชื่อมต่อ
mysqli_close($con);

//5. แจ้งเตือนผลลัพธ์
if($result){
    echo "<script type='text/javascript'>";
    echo "alert('อัปเดตข้อมูลลูกจ้างเรียบร้อยแล้ว');";
    echo "window.location = '../index.php'; ";
    echo "</script>";
} else {
    echo "<script type='text/javascript'>";
    echo "alert('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');";
    echo "</script>";
}
?>
