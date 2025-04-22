<?php
// เชื่อมต่อฐานข้อมูล
include('condb.php');
include('menu.php');

// ตรวจสอบการส่งฟอร์ม
if (isset($_POST['btn_submit'])) {
    $c_id = $_POST['c_id'];
    $em_id = $_POST['em_id'];
    $rr_date = date('Y-m-d'); // กำหนดวันปัจจุบัน
    $rr_quantity = $_POST['rr_quantity'];

    // ดึงราคาน้ำยางจากฐานข้อมูล
    $price_query = "SELECT price_per_kg FROM daily_rubber_price WHERE price_date = '$rr_date'";
    $price_result = mysqli_query($con, $price_query);
    $row = mysqli_fetch_assoc($price_result);

    if ($row) {
        $rr_price = $row['price_per_kg'];
        $total_price = $rr_quantity * $rr_price;

        // ตรวจสอบว่ามีข้อมูลการรับน้ำยางในวันที่นั้นหรือยัง
        $check_query = "SELECT * FROM rubber_receiving WHERE rr_date = '$rr_date' AND c_id = '$c_id'";
        $check_result = mysqli_query($con, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $update_sql = "UPDATE rubber_receiving 
                           SET rr_quantity = '$rr_quantity', rr_price = '$rr_price', total_price = '$total_price'
                           WHERE rr_date = '$rr_date' AND c_id = '$c_id'";
            mysqli_query($con, $update_sql) or die("Error: " . mysqli_error($con));
            echo "<script>alert('อัปเดตราคาและข้อมูลการรับน้ำยางในวันที่ $rr_date');</script>";
        } else {
            $insert_sql = "INSERT INTO rubber_receiving (c_id, em_id, rr_date, rr_quantity, rr_price, total_price)
                           VALUES ('$c_id', '$em_id', '$rr_date', '$rr_quantity', '$rr_price', '$total_price')";
            mysqli_query($con, $insert_sql) or die("Error: " . mysqli_error($con));
            echo "<script>alert('บันทึกข้อมูลการรับน้ำยางในวันที่ $rr_date');</script>";
        }
    } else {
        echo "<script>alert('ยังไม่ได้ตั้งราคาน้ำยางของวันที่ $rr_date');</script>";
    }
}

?>

<?php
function formatDateThai($strDate) {
    $months = ["", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
               "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
    $date = strtotime($strDate);
    $day = date("j", $date);
    $month = $months[(int)date("n", $date)];
    $year = date("Y", $date) + 543;
    return "$day $month $year";
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รับน้ำยางรายวัน</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
     <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <!-- FontAwesome -->
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

<div class="container">
    <div class="form-container">
        <h3 class="text-center">ฟอร์มรับน้ำยางรายวัน</h3>
        <form action="" method="POST">
            <div class="form-group">
                <label for="c_id">รหัสลูกค้า หรือ เจ้าของสวน</label>
                <select name="c_id" class="form-control" id="c_id" required>
                    <option value="">เลือกเจ้าของสวน</option>
                    <?php
                    // ดึงข้อมูลจากตาราง customer
                    $sql = "SELECT c_id, c_name FROM customer";
                    $result = mysqli_query($con, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='{$row['c_id']}'>{$row['c_id']} - {$row['c_name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="em_id">รหัสลูกจ้างตัด</label>
                <select name="em_id" class="form-control" id="em_id" required>
                    <option value="">เลือกลูกจ้าง</option>
                    <?php
                    // ดึงข้อมูลจากตาราง customer
                    $sql = "SELECT em_id, em_name FROM employee";
                    $result = mysqli_query($con, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='{$row['em_id']}'>{$row['em_id']} - {$row['em_name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>วันที่รับน้ำยาง</label>
                <p class="form-control-plaintext"><?= date('d/m/Y') ?></p>
            </div>

            <div class="form-group">
                <label for="rr_quantity">ปริมาณน้ำยาง (กิโลกรัม)</label>
                <input type="number" name="rr_quantity" class="form-control" required step="0.01">
            </div>
            
            <button type="submit" name="btn_submit" class="btn btn-submit btn-block">บันทึกข้อมูล</button>
        </form>
    </div>
</form>

    <!-- ตารางข้อมูลรับน้ำยาง -->
    <div class="mt-5">
    <?php
    // ฟิลเตอร์ตามวันที่ / เดือน / ปี
    $filter_sql = "";
    $showing_date = "";

    if (!empty($_GET['day'])) {
        $day = $_GET['day'];
        $filter_sql = "WHERE r.rr_date = '$day'";
        $showing_date = "วันที่ " . date('d/m/Y', strtotime($day));
    } elseif (!empty($_GET['month']) && !empty($_GET['year'])) {
        $month = $_GET['month'];
        $year = $_GET['year'];
        $filter_sql = "WHERE MONTH(r.rr_date) = '$month' AND YEAR(r.rr_date) = '$year'";
        $showing_date = "เดือน $month / ปี $year";
    } else {
        $today = date('Y-m-d');
        $filter_sql = "WHERE r.rr_date = '$today'";
        $showing_date = "วันนี้ (" . date('d/m/Y') . ")";
    }

    $sql = "SELECT r.*, c.c_name, e.em_name
            FROM rubber_receiving r
            JOIN customer c ON r.c_id = c.c_id
            JOIN employee e ON r.em_id = e.em_id
            $filter_sql
            ORDER BY r.rr_order ASC";

    $result = mysqli_query($con, $sql);
    ?>

    <!-- ฟอร์มกรองข้อมูลตามวันที่ / เดือน / ปี -->
<form method="GET" class="row mb-4">
    <div class="col-md-3">
        <label>วันที่</label>
        <input type="date" name="day" class="form-control" value="<?= isset($_GET['day']) ? $_GET['day'] : '' ?>">
    </div>
   
    <div class="col-md-2 d-flex align-items-end">
        <button type="submit" class="btn btn-primary btn-block">แสดงผล</button>
    </div>
</form>

    <h4 class="text-center">รายการรับน้ำยาง - <?= $showing_date ?></h4>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>รหัสการรับซื้อน้ำยาง</th>
                <th>รหัสลูกค้า หรือ เจ้าของสวน</th>
                <th>ชื่อเจ้าของสวน</th>
                <th>รหัสลูกจ้างตัด</th>
                <th>ชื่อลูกจ้างตัด</th>
                <th>วันที่รับน้ำยาง</th>
                <th>ปริมาณน้ำยาง (กิโลกรัม)</th>
                <th>ราคาน้ำยางต่อกิโลกรัม</th>
                <th>ราคาทั้งหมด (บาท)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                    <td>{$row['rr_order']}</td>
                    <td>{$row['c_id']}</td>
                    <td>{$row['c_name']}</td>
                    <td>{$row['em_id']}</td>
                    <td>{$row['em_name']}</td>
                    <td>" . formatDateThai($row['rr_date']) . "</td>
                    <td>{$row['rr_quantity']}</td>
                    <td>{$row['rr_price']}</td>
                    <td>{$row['total_price']}</td>
                </tr>";
                }
            } else {
                echo "<tr><td colspan='9' class='text-center text-muted'>ไม่มีข้อมูลที่ตรงกับช่วงเวลาที่เลือก</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
