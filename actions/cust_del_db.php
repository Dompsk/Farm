<?php
include('../config/condb.php');

$c_id = $_REQUEST['ID'];
//Delete selected id
$sql = "DELETE FROM customer WHERE c_id = $c_id";
$result = mysqli_query($con, $sql);

//Java Script show all avilable customers
if($result) {
    echo "<script type = 'text/JavaScript'>";
    echo "alert('ทำการลบข้อมูลสำเร็จ');";
    echo "window.location = '../index.php'";
    echo "</script>";
}


?>