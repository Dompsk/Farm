<meta charset="UTF-8">
<?php
//1. เชื่อมต่อ database:
include('condb.php');

//2. รับค่าจากฟอร์ม
$c_id = $_POST["c_id"];
$c_name = $_POST["c_name"];
$c_add = $_POST["c_add"];
$c_tel = $_POST["c_tel"];

//3. อัปเดตข้อมูลลูกค้า
$sql = "UPDATE customer SET  
        c_name = '$c_name',
        c_add = '$c_add',
        c_tel = '$c_tel'
        WHERE c_id = '$c_id'";

$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($con));

//4. ปิดการเชื่อมต่อ
mysqli_close($con);

//5. แจ้งเตือนผลลัพธ์
if($result){
    echo "<script type='text/javascript'>";
    echo "alert('อัปเดตข้อมูลลูกค้าเรียบร้อยแล้ว');";
    echo "window.location = 'customer_list.php'; ";
    echo "</script>";
} else {
    echo "<script type='text/javascript'>";
    echo "alert('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');";
    echo "</script>";
}
?>
