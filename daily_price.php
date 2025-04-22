<?php
include('condb.php');
include('menu.php');

// กำหนดค่าเริ่มต้นสำหรับเดือนและปี
$selected_month = date('m'); // เดือนปัจจุบัน
$selected_year = date('Y');  // ปีปัจจุบัน

// ตรวจสอบว่าเลือกเดือนหรือปีจากฟอร์มหรือไม่
if (isset($_POST['btn_filter'])) {
    $selected_month = $_POST['month'];
    $selected_year = $_POST['year'];
}

// ปรับ SQL Query เพื่อกรองข้อมูลตามเดือนและปี
$sql = "SELECT * FROM daily_rubber_price 
        WHERE YEAR(price_date) = '$selected_year' AND MONTH(price_date) = '$selected_month'
        ORDER BY price_date DESC";

$result = mysqli_query($con, $sql);

// เมื่อกดปุ่มบันทึก
if (isset($_POST['btn_submit'])) {
    $price_date = $_POST['price_date'];
    $price_per_kg = $_POST['price_per_kg'];

    // ตรวจสอบว่ามีราคาวันนี้อยู่หรือยัง
    $check_sql = "SELECT * FROM daily_rubber_price WHERE price_date = '$price_date'";
    $check_result = mysqli_query($con, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        // อัปเดตราคาวันนี้
        $update_sql = "UPDATE daily_rubber_price SET price_per_kg = '$price_per_kg' WHERE price_date = '$price_date'";
        mysqli_query($con, $update_sql);
    } else {
        // เพิ่มราคาวันนี้
        $insert_sql = "INSERT INTO daily_rubber_price (price_date, price_per_kg) VALUES ('$price_date', '$price_per_kg')";
        mysqli_query($con, $insert_sql);
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รับน้ำยางรายวัน</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .form-group p {
            font-weight: bold;
        }
        .table th, .table td {
            text-align: center;
        }
        .btn-submit {
            background-color: #28a745;
            color: white;
            font-size: 16px;
        }
        .btn-submit:hover {
            background-color: #218838;
        }
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h3 class="text-center mb-4">ราคาน้ำยางรายวัน</h3>

    <!-- ฟอร์มเลือกเดือนและปี -->
    <form action="" method="POST" class="mb-4">
        <div class="form-group">
            <label for="year">ปี</label>
            <select name="year" class="form-control" required>
                <?php
                // แสดงปีปัจจุบันและปีที่เลือก
                for ($i = 2020; $i <= date('Y'); $i++) {
                    echo "<option value='$i'" . ($i == $selected_year ? " selected" : "") . ">$i</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="month">เดือน</label>
            <select name="month" class="form-control" required>
                <?php
                // แสดงเดือนที่เลือก
                for ($m = 1; $m <= 12; $m++) {
                    echo "<option value='$m'" . ($m == $selected_month ? " selected" : "") . ">" . str_pad($m, 2, '0', STR_PAD_LEFT) . "</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" name="btn_filter" class="btn btn-info btn-block">แสดงข้อมูล</button>
    </form>

<!-- ฟอร์มบันทึกราคา -->
<form action="" method="POST" class="mb-4">
    <div class="form-group">
        <label for="price_date">วันที่</label>
        <p class="form-control-plaintext"><?= date('d/m/Y') ?></p>
        <input type="hidden" name="price_date" value="<?= date('Y-m-d') ?>">
    </div>
    <div class="form-group">
        <label for="price_per_kg">ราคาน้ำยางต่อกิโลกรัม (บาท)</label>
        <input type="number" step="0.01" name="price_per_kg" class="form-control" required>
    </div>
    <button type="submit" name="btn_submit" class="btn btn-success btn-block">บันทึกราคา</button>
</form>


    <!-- ตารางแสดงราคาย้อนหลัง -->
    <h4 class="text-center">ข้อมูลราคาน้ำยางในเดือน <?= str_pad($selected_month, 2, '0', STR_PAD_LEFT) ?> ปี <?= $selected_year ?></h4>
    <table class="table table-bordered text-center">
        <thead class="thead-dark">
            <tr>
                <th>วันที่</th>
                <th>ราคาน้ำยาง (บาท/กก.)</th>
            </tr>
        </thead>
        <tbody>
    <?php
    // แสดงข้อมูลในตารางตามปีและเดือนที่เลือก
    while ($row = mysqli_fetch_assoc($result)) {
        $formatted_date = date('d/m/Y', strtotime($row['price_date']));
        echo "<tr>
                <td>$formatted_date</td>
                <td>{$row['price_per_kg']}</td>
              </tr>";
    }
    ?>
</tbody>
    </table>
</div>
</body>
</html>
