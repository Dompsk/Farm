<?php
include('../config/condb.php');
include('../components/menu.php');

$selected_month = isset($_POST['month']) ? $_POST['month'] : date('m');
$selected_year  = isset($_POST['year'])  ? $_POST['year']  : date('Y');

// บันทึกราคา
if (isset($_POST['btn_submit'])) {
    $price_date   = $_POST['price_date'];
    $price_per_kg = (float)$_POST['price_per_kg'];

    $check = mysqli_query($con, "SELECT id FROM daily_rubber_price WHERE price_date = '$price_date'");
    if (mysqli_num_rows($check) > 0) {
        mysqli_query($con, "UPDATE daily_rubber_price SET price_per_kg = $price_per_kg WHERE price_date = '$price_date'");
    } else {
        mysqli_query($con, "INSERT INTO daily_rubber_price (price_date, price_per_kg) VALUES ('$price_date', $price_per_kg)");
    }
    // Refresh หลังบันทึก
    header("Location: daily_price.php?month=$selected_month&year=$selected_year&saved=1");
    exit;
}

// รองรับ GET จาก redirect
if (isset($_GET['month'])) $selected_month = $_GET['month'];
if (isset($_GET['year']))  $selected_year  = $_GET['year'];

$result = mysqli_query($con, "
    SELECT * FROM daily_rubber_price
    WHERE YEAR(price_date) = '$selected_year' AND MONTH(price_date) = '$selected_month'
    ORDER BY price_date DESC
");
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ราคาน้ำยางรายวัน — Farm</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { background: #f5f6fa; font-family: 'Segoe UI', sans-serif; }
        .page-header { border-bottom: 2px solid #e9ecef; }
        .panel {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,.08);
            padding: 24px;
        }

        /* Price card */
        .price-card {
            border-radius: 12px;
            overflow: hidden;
            border: 2px solid #0d6efd;
            margin-bottom: 20px;
        }
        .price-card .header {
            background: #0d6efd;
            color: #fff;
            font-weight: 600;
            padding: 10px 16px;
            font-size: 1rem;
            text-align: center;
        }
        .price-card .body {
            text-align: center;
            padding: 20px 16px 8px;
        }
        .price-card .footer {
            text-align: center;
            padding: 8px 16px 12px;
            font-size: 0.88rem;
            color: #888;
        }

        /* Table */
        .table-panel { background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,.08); overflow: hidden; }
        .table-panel .toolbar { padding: 12px 20px; border-bottom: 1px solid #e9ecef; display: flex; justify-content: space-between; align-items: center; }
        table thead th { background: #1a1a2e; color: #fff; font-weight: 500; font-size: 0.88rem; }
        table tbody td { vertical-align: middle; }
        table tbody tr:hover { background: #f0f4ff; }
        .price-num { font-variant-numeric: tabular-nums; font-weight: 600; color: #0d6efd; }
        .tfoot-row td { background: #f0f4ff; font-weight: 700; }

        .saved-toast {
            position: fixed; top: 20px; right: 20px; z-index: 9999;
            display: none;
        }
    </style>
</head>
<body>

<!-- Toast notification -->
<?php if (isset($_GET['saved'])): ?>
<div class="saved-toast" id="savedToast">
    <div class="alert alert-success shadow">✅ บันทึกราคาสำเร็จ!</div>
</div>
<script>
    const t = document.getElementById('savedToast');
    t.style.display = 'block';
    setTimeout(() => t.style.display = 'none', 3000);
</script>
<?php endif; ?>

<div class="container" style="margin-top: 30px; padding-bottom: 60px;">

    <!-- Header -->
    <div class="d-flex align-items-center mb-4 page-header pb-3">
        <div class="me-3" style="color:#0d6efd; font-size:2rem;">
            <i class="fa-solid fa-droplet"></i>
        </div>
        <div>
            <h4 class="mb-0 fw-bold" style="color:#1a1a2e;">ราคาน้ำยางรายวัน</h4>
            <small class="text-muted">บันทึกและตรวจสอบราคากลางน้ำยางพารา</small>
        </div>
    </div>

    <!-- Filter inline -->
    <div class="panel mb-4 py-3">
        <form action="" method="POST" class="row g-2 align-items-end">
            <div class="col-auto">
                <label class="form-label mb-1 small fw-semibold">ปี</label>
                <select name="year" class="form-select form-select-sm" required>
                    <?php for ($i = 2020; $i <= date('Y'); $i++): ?>
                        <option value="<?= $i ?>" <?= $i == $selected_year ? 'selected' : '' ?>><?= $i ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-auto">
                <label class="form-label mb-1 small fw-semibold">เดือน</label>
                <select name="month" class="form-select form-select-sm" required>
                    <?php for ($m = 1; $m <= 12; $m++): ?>
                        <option value="<?= $m ?>" <?= $m == $selected_month ? 'selected' : '' ?>><?= str_pad($m, 2, '0', STR_PAD_LEFT) ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" name="btn_filter" class="btn btn-info btn-sm text-white">
                    <i class="fa fa-search me-1"></i>แสดงข้อมูล
                </button>
            </div>
        </form>
    </div>

    <div class="row g-4">

        <!-- ===== ซ้าย: การ์ดราคา + ฟอร์มบันทึก ===== -->
        <div class="col-lg-4 col-md-12">

            <!-- การ์ดราคากลาง TLA -->
            <div class="price-card">
                <div class="header"><i class="fa fa-chart-line me-1"></i>ราคากลาง TLA</div>
                <div class="body">
                    <div id="display_price" style="font-size: 3rem; font-weight: 700; color: #0d6efd; line-height: 1.1;">-</div>
                    <div class="text-muted mt-1" style="font-size: 1rem;">บาท/กก.</div>
                </div>
                <div class="footer" id="display_date">กำลังโหลด...</div>
            </div>

            <!-- ฟอร์มบันทึกราคา -->
            <div class="panel">
                <h6 class="fw-bold mb-3"><i class="fa fa-pen-to-square me-1 text-success"></i>บันทึกราคาวันนี้</h6>
                <form action="" method="POST">
                    <!-- Radio: auto / manual -->
                    <div class="mb-3 text-center">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="opt_auto" name="price_type" value="auto" checked onchange="togglePriceInput()">
                            <label class="form-check-label" for="opt_auto">ราคากลางอัตโนมัติ</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="opt_manual" name="price_type" value="manual" onchange="togglePriceInput()">
                            <label class="form-check-label" for="opt_manual">กรอกราคาเอง</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">วันที่</label>
                        <p class="fw-bold text-primary mb-0"><?= date('d/m/Y') ?></p>
                        <input type="hidden" name="price_date" value="<?= date('Y-m-d') ?>">
                        <input type="hidden" name="month" value="<?= $selected_month ?>">
                        <input type="hidden" name="year"  value="<?= $selected_year ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">ราคา (บาท/กก.)</label>
                        <input type="number" step="0.01" id="price_per_kg" name="price_per_kg"
                               class="form-control form-control-lg text-center fw-bold"
                               style="font-size: 1.6rem; color: #28a745;" required readonly>
                    </div>

                    <button type="submit" name="btn_submit" class="btn btn-success w-100 btn-lg">
                        <i class="fa fa-save me-1"></i>บันทึกราคาวันนี้
                    </button>
                </form>
            </div>
        </div>

        <!-- ===== ขวา: ตารางราคาย้อนหลัง ===== -->
        <div class="col-lg-8 col-md-12">
            <div class="table-panel">
                <div class="toolbar">
                    <span class="fw-bold"><i class="fa fa-table me-1 text-primary"></i>
                        ราคาน้ำยางเดือน <?= str_pad($selected_month, 2, '0', STR_PAD_LEFT) ?> / <?= $selected_year ?>
                    </span>
                    <span class="badge bg-primary"><?= mysqli_num_rows($result) ?> รายการ</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered mb-0 text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>วันที่</th>
                                <th>ราคาน้ำยาง (บาท/กก.)</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i    = 1;
                        $sum  = 0;
                        $rows = [];
                        while ($row = mysqli_fetch_assoc($result)) $rows[] = $row;

                        if (count($rows) > 0):
                            foreach ($rows as $row):
                                $sum += $row['price_per_kg'];
                                $d    = date('d/m/Y', strtotime($row['price_date']));
                        ?>
                        <tr>
                            <td class="text-muted small"><?= $i++ ?></td>
                            <td><?= $d ?></td>
                            <td><span class="price-num"><?= number_format($row['price_per_kg'], 2) ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                        <tr class="tfoot-row">
                            <td colspan="2" class="text-end pe-3">เฉลี่ย</td>
                            <td class="text-danger"><?= number_format($sum / count($rows), 2) ?> บาท/กก.</td>
                        </tr>
                        <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">
                                <i class="fa fa-inbox fa-2x d-block mb-2"></i>ไม่มีข้อมูลในเดือนนี้
                            </td>
                        </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    let autoPrice = 0;

    function fetchLatestPrice() {
        fetch('/Farm/api/latest_price.php')
            .then(r => r.json())
            .then(res => {
                if (res.success && res.data) {
                    autoPrice = parseFloat(res.data.price);
                    const d = new Date(res.data.price_date);
                    const m = ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'];
                    document.getElementById('display_price').innerText = autoPrice.toFixed(2);
                    document.getElementById('display_date').innerText  = d.getDate() + ' ' + m[d.getMonth()] + ' ' + (d.getFullYear() + 543);
                    togglePriceInput();
                } else {
                    document.getElementById('display_price').innerText = 'N/A';
                    document.getElementById('display_date').innerText  = 'ยังไม่มีข้อมูลวันนี้';
                    document.getElementById('opt_manual').checked = true;
                    togglePriceInput();
                }
            })
            .catch(() => {
                document.getElementById('display_price').innerText = 'Error';
                document.getElementById('display_date').innerText  = 'ดึงข้อมูลไม่ได้';
            });
    }

    function togglePriceInput() {
        const isAuto = document.getElementById('opt_auto').checked;
        const input  = document.getElementById('price_per_kg');
        if (isAuto) {
            input.value    = autoPrice > 0 ? autoPrice : '';
            input.readOnly = true;
            input.style.color = '#28a745';
        } else {
            input.readOnly = false;
            input.value    = '';
            input.style.color = '#0d6efd';
            input.focus();
        }
    }

    document.addEventListener('DOMContentLoaded', fetchLatestPrice);
</script>
</body>
</html>
