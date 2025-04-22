<?php

//include db
include('condb.php');
include('menu.php');

$query= "
SELECT c.c_id, c.c_name, c.c_add  ,c.c_tel , e.em_name FROM customer as c , employee as e WHERE c.em_id = e.em_id
ORDER BY c.c_id ASC" or die("Error:" . mysqli_error());

//เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
$result = mysqli_query($con, $query);

//แสดงข้อมูลที่ query ออกมา โดยใช้ตารางในการจัดข้อมูล:
echo '<div class="alert alert-primary" role="alert">';
echo '<p style="font-size:30px"  class="text-center">';
echo "ระบบจัดการรายชื่อลูกค้า";
echo "<hr>";
echo '</p>';
echo '</div>';

// ปุ่มเพิ่มข้อมูลลูกค้า
echo '<div class="text-center">';
echo '<a href="cust_form_add.php" class="btn btn-success">เพิ่มรายชื่อลูกค้า</a>';
echo '</div>';

echo "<p></p>";
echo '<table class="table table-dark table-striped">';

 //หัวข้อตาราง
 echo "<tr>
 <td >รหัสลูกค้า</td>
 <td >ชื่อเจ้าของสวน</td>
 <td >ที่อยู่ลูกค้า</td>
 <td >เบอร์ลูกค้า</td>
 <td >รายชื่อคนตัดน้ำยาง</td>
 <td >แก้ไขข้อมูลลูกจ้าง</td>
 <td >แก้ไขข้อมูลเจ้าของสวน</td>
 <td >ลบ</td>
</tr>";
while($row = mysqli_fetch_array($result)) {
echo "<tr>";
echo "<td>" .$row["c_id"] .  "</td> ";
echo "<td>" .$row["c_name"] .  "</td> ";
echo "<td>" .$row["c_add"] .  "</td> ";
echo "<td>" .$row["c_tel"] .  "</td> ";
echo "<td>" .$row["em_name"] .  "</td> ";

//แก้ไขลูกจ้าง
echo "<td><a href='em_form_edit.php?act=edit&ID=$row[0]' class='btn btn-light btn-xs'>แก้ไขลูกจ้าง</a></td> ";

//แก้ไขเจ้าของสวน
echo "<td><a href='cust_form_edit.php?act=edit&ID=$row[0]' class='btn btn-warning btn-xs'>แก้ไขเจ้าของสวน</a></td> ";

//ลบข้อมูล
echo "<td><a href='cust_del_db.php?ID=$row[0]' onclick=\"return confirm('Do you want to delete this record? !!!')\" class='btn btn-danger btn-xs'>ลบ</a></td> ";
echo "</tr>";
}
echo "</table>";
//5. close connection
mysqli_close($con);
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Document</title>
</head>
<body>
    
</body>
</html>