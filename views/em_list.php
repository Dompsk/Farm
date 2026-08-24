<?php
include('../config/condb.php');

$query = "SELECT e.em_id, e.em_name, e.em_add, e.em_tel,
                 COUNT(c.c_id) AS cust_count
          FROM employee AS e
          LEFT JOIN customer AS c ON c.em_id = e.em_id
          GROUP BY e.em_id, e.em_name, e.em_add, e.em_tel
          ORDER BY e.em_id ASC";
$result   = mysqli_query($con, $query);
$total_em = mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการลูกจ้าง — Farm</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { background: #f5f6fa; font-family: 'Segoe UI', sans-serif; }

        .page-header { border-bottom: 2px solid #e9ecef; }

        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 18px 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,.07);
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .stat-icon {
            width: 52px; height: 52px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
        }
        .stat-icon.purple { background: #ede9fe; color: #5b21b6; }
        .stat-icon.green  { background: #e8f5e9; color: #2e7d32; }

        .table-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,.07);
            overflow: hidden;
        }
        .table-card .card-toolbar {
            padding: 14px 20px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        table thead th {
            background: #1a1a2e;
            color: #fff;
            font-weight: 500;
            font-size: 0.87rem;
            white-space: nowrap;
            vertical-align: middle;
        }
        table tbody td { vertical-align: middle; font-size: 0.92rem; }
        table tbody tr:hover { background: #f5f3ff; }

        .search-box { max-width: 240px; }

        .badge-cust {
            background: #e3f0ff;
            color: #1565c0;
            border-radius: 20px;
            padding: 3px 10px;
            font-size: .78rem;
            font-weight: 600;
        }
        .no-data { color: #d1d5db; font-size: .82rem; }
    </style>
</head>
<body>
<?php include('../components/menu.php'); ?>
<div class="container-fluid px-4" style="margin-top: 80px; padding-bottom: 60px;">

    <!-- Header -->
    <div class="text-center mb-4 pb-3 page-header">
        <div class="mb-2" style="color:#5b21b6; font-size:2.5rem;">
            <i class="fa-solid fa-hard-hat"></i>
        </div>
        <h3 class="fw-bold mb-1" style="color:#1a1a2e;">รายชื่อลูกจ้างตัดยาง</h3>
        <p class="text-muted mb-0">จัดการข้อมูลลูกจ้างในระบบ</p>
    </div>

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/Farm/index.php" class="text-decoration-none text-primary">
                    <i class="fa-solid fa-house me-1"></i>หน้าหลัก
                </a>
            </li>
            <li class="breadcrumb-item active text-muted">จัดการลูกจ้าง</li>
        </ol>
    </nav>

    <!-- Stat Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon purple"><i class="fa fa-hard-hat"></i></div>
                <div>
                    <div class="fw-bold fs-4"><?= $total_em ?></div>
                    <div class="text-muted small">ลูกจ้างทั้งหมด</div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon green"><i class="fa fa-calendar-day"></i></div>
                <div>
                    <div class="fw-bold fs-5"><?= date('d/m/Y') ?></div>
                    <div class="text-muted small">วันที่ปัจจุบัน</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="table-card">
        <div class="card-toolbar">
            <div class="d-flex align-items-center gap-2">
                <span class="fw-bold"><i class="fa fa-list-ul me-1 text-purple" style="color:#5b21b6;"></i>รายชื่อลูกจ้าง</span>
                <span class="badge" style="background:#ede9fe; color:#5b21b6;"><?= $total_em ?> คน</span>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <input type="text" id="searchInput" class="form-control form-control-sm search-box"
                       placeholder="ค้นหาชื่อลูกจ้าง…" oninput="filterTable()">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-bordered mb-0" id="emTable">
                <thead>
                    <tr class="text-center">
                        <th style="width:60px;">#</th>
                        <th>ชื่อลูกจ้าง</th>
                        <th>ที่อยู่</th>
                        <th>เบอร์โทร</th>
                        <th>ดูแลสวน</th>
                        <th style="width:90px;">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $i = 1;
                while ($row = mysqli_fetch_assoc($result)):
                ?>
                <tr>
                    <td class="text-center text-muted small"><?= $i++ ?></td>
                    <td>
                        <span class="fw-semibold"><?= htmlspecialchars($row['em_name']) ?></span>
                    </td>
                    <td class="text-muted small">
                        <?= !empty($row['em_add']) ? htmlspecialchars($row['em_add']) : '<span class="no-data">—</span>' ?>
                    </td>
                    <td class="text-center">
                        <?php if (!empty($row['em_tel'])): ?>
                            <i class="fa fa-phone text-muted me-1 small"></i><?= htmlspecialchars($row['em_tel']) ?>
                        <?php else: ?>
                            <span class="no-data">—</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <?php if ($row['cust_count'] > 0): ?>
                            <span class="badge-cust">
                                <i class="fa fa-leaf me-1"></i><?= $row['cust_count'] ?> สวน
                            </span>
                        <?php else: ?>
                            <span class="no-data">ยังไม่มี</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <div class="d-flex gap-1 justify-content-center">
                            <a href="em_form_edit.php?em_id=<?= $row['em_id'] ?>"
                               class="btn btn-warning btn-sm" title="แก้ไขข้อมูล">
                                <i class="fa fa-pen"></i>
                            </a>
                            <a href="../actions/em_del_db.php?ID=<?= $row['em_id'] ?>"
                               onclick="return confirmDelete('<?= htmlspecialchars($row['em_name'], ENT_QUOTES) ?>', <?= $row['cust_count'] ?>)"
                               class="btn btn-danger btn-sm" title="ลบ">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function filterTable() {
    const q    = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#emTable tbody tr');
    rows.forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(q) ? '' : 'none';
    });
}

function confirmDelete(name, custCount) {
    if (custCount > 0) {
        return confirm(`ลูกจ้าง "${name}" ยังดูแลอยู่ ${custCount} สวน\nถ้าลบจะทำให้ข้อมูลลูกค้าที่เชื่อมโยงอยู่ถูกกระทบด้วย\nยืนยันการลบ?`);
    }
    return confirm(`ยืนยันการลบลูกจ้าง "${name}"?`);
}
</script>
</body>
</html>
