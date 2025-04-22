<?php
include('condb.php'); // เชื่อมฐานข้อมูล
include('menu.php');

// เมื่อกดบันทึก
if (isset($_POST['submit'])) {
    $c_id = $_POST['c_id'];
    $em_id = $_POST['em_id'];
    $percent_employer = $_POST['percent_employer'];
    $percent_employee = $_POST['percent_employee'];
    $total = $_POST['total_amount'];

    $employer_share = $total * ($percent_employer / 100);
    $employee_share = $total * ($percent_employee / 100);

    $sql = "INSERT INTO payment (c_id, em_id, total_amount, employer_share, employee_share)
            VALUES ('$c_id', '$em_id', '$total', '$employer_share', '$employee_share')";
    mysqli_query($con, $sql) or die("Error: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบแบ่งจ่ายเงิน</title>
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
<body class="bg-light">
<div class="container mt-5">
    <h3 class="text-center mb-4">ระบบแบ่งจ่ายเงิน</h3>
    <form method="POST" class="bg-white p-4 shadow-sm rounded">
        <div class="row mb-3">
            <div class="col">
                <label>เลือกเจ้าของสวน:</label>
                <select name="c_id" class="form-control" required>
                    <option value="">-- เลือก --</option>
                    <?php
                    $result = mysqli_query($con, "SELECT c_id, c_name FROM customer");
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='{$row['c_id']}'>{$row['c_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col">
                <label>เลือกลูกจ้าง:</label>
                <select name="em_id" class="form-control" required>
                    <option value="">-- เลือก --</option>
                    <?php
                    $result = mysqli_query($con, "SELECT em_id, em_name FROM employee");
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='{$row['em_id']}'>{$row['em_name']}</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>เปอร์เซ็นต์เจ้าของสวน (%)</label>
                <input type="number" name="percent_employer" class="form-control" value="60" required>
            </div>
            <div class="col">
                <label>เปอร์เซ็นต์ลูกจ้าง (%)</label>
                <input type="number" name="percent_employee" class="form-control" value="40" required>
            </div>
            <div class="col">
                <label>จำนวนเงินรวม (บาท)</label>
                <input type="number" name="total_amount" class="form-control" step="0.01" required>
            </div>
        </div>

        <button type="submit" name="submit" class="btn btn-success btn-block">บันทึกการแบ่งเงิน</button>
    </form>

    <!-- ตารางแสดงข้อมูล -->
    <div class="mt-5">
        <h4 class="text-center">รายการแบ่งจ่ายเงิน</h4>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ลำดับล่าสุด</th>
                    <th>ชื่อเจ้าของสวน</th>
                    <th>ได้เงิน </th>
                    <th>ชื่อลูกจ้าง</th>
                    <th>ได้เงิน </th>
                    <th>เงินรวม</th> 
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT p.*, c.c_name, e.em_name 
                        FROM payment p
                        JOIN customer c ON p.c_id = c.c_id
                        JOIN employee e ON p.em_id = e.em_id
                        ORDER BY p.payment_id DESC";
                $res = mysqli_query($con, $sql);
                while ($row = mysqli_fetch_assoc($res)) {
                    echo "<tr>
                        <td>{$row['payment_id']}</td>
                        <td>{$row['c_name']}</td>
                        <td>" . number_format($row['employer_share'], 2) . "</td>
                        <td>{$row['em_name']}</td>
                        <td>" . number_format($row['employee_share'], 2) . "</td>
                        <td>" . number_format($row['total_amount'], 2) . "</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
