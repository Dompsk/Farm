<?php
include('../config/condb.php');
include('../components/menu.php');

// ตรวจสอบการส่งฟอร์ม
if (isset($_POST['btn_submit'])) {
    $c_id        = $_POST['c_id'];
    $em_id       = $_POST['em_id'];
    $rr_date     = date('Y-m-d');
    $rr_quantity = $_POST['rr_quantity'];

    $price_query  = "SELECT price_per_kg FROM daily_rubber_price WHERE price_date = '$rr_date'";
    $price_result = mysqli_query($con, $price_query);
    $row          = mysqli_fetch_assoc($price_result);

    if ($row) {
        $rr_price    = $row['price_per_kg'];
        $total_price = $rr_quantity * $rr_price;

        $check_result = mysqli_query($con, "SELECT * FROM rubber_receiving WHERE rr_date = '$rr_date' AND c_id = '$c_id'");

        if (mysqli_num_rows($check_result) > 0) {
            mysqli_query($con, "UPDATE rubber_receiving SET rr_quantity='$rr_quantity', rr_price='$rr_price', total_price='$total_price' WHERE rr_date='$rr_date' AND c_id='$c_id'");
            echo "<script>alert('อัปเดตข้อมูลการรับน้ำยางวันที่ $rr_date แล้ว');</script>";
        } else {
            mysqli_query($con, "INSERT INTO rubber_receiving (c_id, em_id, rr_date, rr_quantity, rr_price, total_price) VALUES ('$c_id','$em_id','$rr_date','$rr_quantity','$rr_price','$total_price')");
            echo "<script>alert('บันทึกข้อมูลการรับน้ำยางวันที่ $rr_date สำเร็จ');</script>";
        }
    } else {
        echo "<script>alert('⚠️ ยังไม่ได้ตั้งราคาน้ำยางของวันที่ $rr_date กรุณาบันทึกราคาวันนี้ก่อน');</script>";
    }
}

function formatDateThai($strDate) {
    $months = ["","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"];
    $ts     = strtotime($strDate);
    return date("j", $ts) . ' ' . $months[(int)date("n", $ts)] . ' ' . (date("Y", $ts) + 543);
}

// ===== Filter =====
$filter_sql   = "";
$showing_date = "";

if (!empty($_GET['day'])) {
    $day          = $_GET['day'];
    $filter_sql   = "WHERE r.rr_date = '$day'";
    $showing_date = "วันที่ " . date('d/m/Y', strtotime($day));
} elseif (!empty($_GET['month']) && !empty($_GET['year'])) {
    $month        = $_GET['month'];
    $year         = $_GET['year'];
    $filter_sql   = "WHERE MONTH(r.rr_date) = '$month' AND YEAR(r.rr_date) = '$year'";
    $showing_date = "เดือน $month / ปี $year";
} else {
    $today        = date('Y-m-d');
    $filter_sql   = "WHERE r.rr_date = '$today'";
    $showing_date = "วันนี้ (" . date('d/m/Y') . ")";
}

$sql    = "SELECT r.*, c.c_name, e.em_name
           FROM rubber_receiving r
           JOIN customer c ON r.c_id = c.c_id
           JOIN employee e ON r.em_id = e.em_id
           $filter_sql
           ORDER BY r.rr_order ASC";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รับน้ำยางรายวัน</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { background-color: #f5f6fa; font-family: 'Segoe UI', sans-serif; }
        .page-header { border-bottom: 2px solid #e9ecef; }
        .form-card { background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,.08); padding: 24px; }
        .table thead th {
            background: #1a1a2e;
            color: #fff;
            font-weight: 500;
            font-size: 0.88rem;
            white-space: nowrap;
            vertical-align: middle;
        }
        .table tbody td { vertical-align: middle; font-size: 0.92rem; }
        .table-hover tbody tr:hover { background: #eef3ff; }
        .badge-qty  { background: #e3f0ff; color: #1565c0; font-size: 0.9rem; }
        .badge-price { background: #e8f5e9; color: #2e7d32; font-size: 0.9rem; }
        .badge-total { background: #fff3e0; color: #e65100; font-size: 0.9rem; }
        .tfoot-row td { background: #f0f4ff; font-weight: 700; }
        .num { text-align: right; font-variant-numeric: tabular-nums; }
    </style>
</head>
<body>
<div class="container" style="margin-top: 30px; padding-bottom: 60px;">

    <!-- Header -->
    <div class="d-flex align-items-center mb-4 page-header pb-3">
        <div class="me-3" style="color:#0d6efd; font-size:2rem;">
            <i class="fa-solid fa-truck-droplet"></i>
        </div>
        <div>
            <h4 class="mb-0 fw-bold" style="color:#1a1a2e;">รับน้ำยางรายวัน</h4>
            <small class="text-muted">บันทึกปริมาณและยอดรับซื้อน้ำยางพารา</small>
        </div>
    </div>

    <div class="row g-4">

        <!-- ===== ฟอร์มบันทึก (ซ้าย) ===== -->
        <div class="col-lg-4 col-md-12">
            <div class="form-card h-100">
                <h6 class="fw-bold mb-3"><i class="fa fa-plus-circle me-1 text-success"></i>บันทึกรับน้ำยาง</h6>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">เจ้าของสวน</label>
                        <select name="c_id" class="form-select" required>
                            <option value="">— เลือกเจ้าของสวน —</option>
                            <?php
                            $r = mysqli_query($con, "SELECT c_id, c_name FROM customer ORDER BY c_id");
                            while ($row = mysqli_fetch_assoc($r))
                                echo "<option value='{$row['c_id']}'>{$row['c_id']} – {$row['c_name']}</option>";
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">ลูกจ้างตัด</label>
                        <select name="em_id" class="form-select" required>
                            <option value="">— เลือกลูกจ้าง —</option>
                            <?php
                            $r = mysqli_query($con, "SELECT em_id, em_name FROM employee ORDER BY em_id");
                            while ($row = mysqli_fetch_assoc($r))
                                echo "<option value='{$row['em_id']}'>{$row['em_id']} – {$row['em_name']}</option>";
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">วันที่รับ</label>
                        <p class="form-control-plaintext fw-bold text-primary mb-0"><?= date('d/m/Y') ?></p>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">ปริมาณน้ำยาง (กก.)</label>
                        <input type="number" name="rr_quantity" class="form-control form-control-lg text-center"
                               required step="0.01" placeholder="0.00">
                    </div>

                    <button type="submit" name="btn_submit" class="btn btn-success w-100 btn-lg">
                        <i class="fa fa-save me-1"></i>บันทึกข้อมูล
                    </button>
                </form>
            </div>
        </div>

        <!-- ===== ตาราง (ขวา) ===== -->
        <div class="col-lg-8 col-md-12">

            <!-- ฟอร์มกรองวันที่ -->
            <div class="form-card mb-3 py-3">
                <form method="GET" class="row g-2 align-items-end">
                    <div class="col-auto">
                        <label class="form-label mb-1 fw-semibold small">วันที่</label>
                        <input type="date" name="day" class="form-control form-control-sm"
                               value="<?= isset($_GET['day']) ? $_GET['day'] : '' ?>">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-info btn-sm text-white">
                            <i class="fa fa-search me-1"></i>แสดงผล
                        </button>
                        <a href="daily_rubber_receive.php" class="btn btn-outline-secondary btn-sm ms-1">วันนี้</a>
                    </div>
                </form>
            </div>

            <!-- ตาราง -->
            <div class="form-card p-0 overflow-hidden">
                <div class="px-3 py-2 border-bottom d-flex justify-content-between align-items-center">
                    <span class="fw-bold text-dark"><i class="fa fa-list-ul me-1 text-primary"></i>รายการรับน้ำยาง — <?= $showing_date ?></span>
                    <span class="badge bg-primary"><?= mysqli_num_rows($result) ?> รายการ</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered mb-0">
                        <thead>
                            <tr class="text-center">
                                <th>#</th>
                                <th>เจ้าของสวน</th>
                                <th>ลูกจ้างตัด</th>
                                <th>วันที่รับ</th>
                                <th>ปริมาณ (กก.)</th>
                                <th>ราคา/กก.</th>
                                <th>รวม (บาท)</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $total_qty   = 0;
                        $total_baht  = 0;
                        $i = 1;

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $total_qty  += $row['rr_quantity'];
                                $total_baht += $row['total_price'];
                                echo "
                                <tr>
                                    <td class='text-center text-muted small'>{$i}</td>
                                    <td>{$row['c_name']}</td>
                                    <td>{$row['em_name']}</td>
                                    <td class='text-center'>" . formatDateThai($row['rr_date']) . "</td>
                                    <td class='num'><span class='badge badge-qty px-2 py-1'>" . number_format($row['rr_quantity'], 2) . "</span></td>
                                    <td class='num'><span class='badge badge-price px-2 py-1'>" . number_format($row['rr_price'], 2) . "</span></td>
                                    <td class='num'><span class='badge badge-total px-2 py-1'>" . number_format($row['total_price'], 2) . "</span></td>
                                </tr>";
                                $i++;
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center text-muted py-4'>
                                    <i class='fa fa-inbox fa-2x mb-2 d-block'></i>ไม่มีข้อมูลในช่วงเวลาที่เลือก
                                  </td></tr>";
                        }
                        ?>
                        </tbody>
                        <?php if ($total_qty > 0): ?>
                        <tfoot>
                            <tr class="tfoot-row text-center">
                                <td colspan="4" class="text-end pe-3">รวมทั้งหมด</td>
                                <td class="num"><?= number_format($total_qty, 2) ?> กก.</td>
                                <td></td>
                                <td class="num text-danger"><?= number_format($total_baht, 2) ?> ฿</td>
                            </tr>
                        </tfoot>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
</body>
</html>
