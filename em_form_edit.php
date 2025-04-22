<?php
//1. เชื่อมต่อ database:
include('condb.php');
$em_id = $_GET["ID"];

//2. query ข้อมูลจากตาราง customer:
$sql = "SELECT e.em_id, e.em_name, e.em_add, e.em_tel 
        FROM employee AS e
        INNER JOIN customer AS c ON c.em_id = e.em_id
        WHERE e.em_id = '$em_id'
        ORDER BY e.em_id ASC";
$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($con));

// ตรวจสอบว่ามีข้อมูลหรือไม่
if (mysqli_num_rows($result) > 0) {
    // ดึงข้อมูลจากผลลัพธ์
    $row = mysqli_fetch_array($result);
    extract($row); // ใช้ extract เมื่อได้ข้อมูล
} else {
    // ถ้าไม่มีข้อมูล
    echo "ไม่พบข้อมูลสำหรับ em_id: $em_id";
    exit;  // ออกจากการทำงานเมื่อไม่มีข้อมูล
}
?>

<div class="container">
  <div class="row">
  <form name="editcustomer" action="cust_form_edit_db.php" method="POST" class="form-horizontal">
      <div class="form-group">
        <div class="col-sm-12">
          <p style="font-weight: bold;">รหัสลูกจ้าง</p>
          <input type="text" name="em_id" class="form-control" readonly value="<?php echo $em_id; ?>">
        </div>
      </div>

      <div class="form-group">
        <div class="col-sm-12">
          <p style="font-weight: bold;">ชื่อลูกจ้าง</p>
          <input type="text" name="em_name" class="form-control" required placeholder="ชื่อเจ้าของสวน" value="<?php echo $em_name; ?>">
        </div>
      </div>

      <div class="form-group">
        <div class="col-sm-12">
          <p style="font-weight: bold;">ที่อยู่ลูกจ้าง</p>
          <input type="text" name="em_add" class="form-control" required placeholder="ที่อยู่ลูกค้า" value="<?php echo $em_add; ?>">
        </div>
      </div>

      <div class="form-group">
        <div class="col-sm-12">
          <p style="font-weight: bold;">เบอร์ลูกจ้าง</p>
          <input type="text" name="em_tel" class="form-control" required placeholder="เบอร์ลูกค้า" value="<?php echo $em_tel; ?>">
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
