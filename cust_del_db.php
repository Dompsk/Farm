<?php
$connection = mysqli_connect('localhost','root','','farm');
if($connection){
    echo "we are connected";
}else{
    die('Database Connection fail');
}

$c_id = $_REQUEST['ID'];
//Delete selected id
$sql = "DELETE FROM customer WHERE c_id = $c_id";
$result = mysqli_query($connection,$sql);

//Java Script show all avilable customers
if($result) {
    echo "<script type = 'text/JavaScript'>";
    echo "alert('ทำการลบข้อมูลสำเร็จ');";
    echo "window.location = 'customer_list.php'";
    echo "</script>";
}


?>