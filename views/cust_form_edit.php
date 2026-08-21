<?php
//1. เชื่อมต่อ database:
include('../config/condb.php');
$c_id = $_GET["ID"];

//2. query ข้อมูลจากตาราง customer:
$sql = "SELECT * FROM customer as c WHERE c.c_id = '$c_id' ORDER BY c.c_id ASC";
$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($con));
$row = mysqli_fetch_array($result);
extract($row);
?>

<div class="container">
  <div class="row">
  <form name="editcustomer" action="../actions/cust_form_edit_db.php" method="POST" class="form-horizontal">
      <div class="form-group">
        <div class="col-sm-12">
          <p style="font-weight: bold;">รหัสลูกค้า</p>
          <input type="text" name="c_id" class="form-control" readonly value="<?php echo $c_id; ?>">
        </div>
      </div>

      <div class="form-group">
        <div class="col-sm-12">
          <p style="font-weight: bold;">ชื่อเจ้าของสวน</p>
          <input type="text" name="c_name" class="form-control" required placeholder="ชื่อเจ้าของสวน" value="<?php echo $c_name; ?>">
        </div>
      </div>

      <div class="form-group">
        <div class="col-sm-12">
          <p style="font-weight: bold;">ที่อยู่ลูกค้า</p>
          <input type="text" name="c_add" class="form-control" required placeholder="ที่อยู่ลูกค้า" value="<?php echo $c_add; ?>">
        </div>
      </div>

      <div class="form-group">
        <div class="col-sm-12">
          <p style="font-weight: bold;">เบอร์ลูกค้า</p>
          <input type="text" name="c_tel" class="form-control" required placeholder="เบอร์ลูกค้า" value="<?php echo $c_tel; ?>">
        </div>
      </div>

      <div class="form-group">
        <div class="col-sm-12">
          <br>
          <button type="submit" class="btn btn-success" name="btnedit">บันทึกการแก้ไข</button>
        </div>
      </div>

    </form>
  </div>
</div>
