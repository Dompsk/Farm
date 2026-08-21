<?php
include('config/condb.php');
include('components/menu.php');

$query  = "SELECT c.c_id, c.c_name, c.c_add, c.c_tel, e.em_name
           FROM customer AS c
           JOIN employee AS e ON c.em_id = e.em_id
           ORDER BY c.c_id ASC";
$result = mysqli_query($con, $query);
$total  = mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจัดการรายชื่อลูกค้า — Farm</title>
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
        .stat-icon.blue  { background: #e3f0ff; color: #1565c0; }
        .stat-icon.green { background: #e8f5e9; color: #2e7d32; }

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
        table tbody tr:hover { background: #f0f4ff; }

        .search-box { max-width: 260px; }
    </style>
</head>
<body>
<div class="container-fluid px-4" style="margin-top: 30px; padding-bottom: 60px;">

    <!-- Header -->
    <div class="text-center mb-4 pb-3 page-header">
        <div class="mb-2" style="color:#0d6efd; font-size:2.5rem;">
            <i class="fa-solid fa-users"></i>
        </div>
        <h3 class="fw-bold mb-1" style="color:#1a1a2e;">รายชื่อลูกค้า (เจ้าของสวน)</h3>
        <p class="text-muted mb-0">จัดการข้อมูลลูกค้าและเจ้าของสวนยางพารา</p>
    </div>

    <!-- Stat Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon blue"><i class="fa fa-user-friends"></i></div>
                <div>
                    <div class="fw-bold fs-4"><?= $total ?></div>
                    <div class="text-muted small">เจ้าของสวนทั้งหมด</div>
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
                <span class="fw-bold"><i class="fa fa-list-ul me-1 text-primary"></i>รายชื่อลูกค้า</span>
                <span class="badge bg-primary"><?= $total ?> ราย</span>
            </div>
            <div class="d-flex gap-5 align-items-center">
                <input type="text" id="searchInput" class="form-control form-control-sm search-box"
                       placeholder="ค้นหาชื่อหรือเบอร์โทร…" oninput="filterTable()">
                <a href="views/cust_form_add.php" class="btn btn-success btn-sm" style="white-space: nowrap;">
                    <i class="fa-solid fa-plus me-1"></i>เพิ่มลูกค้า
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-bordered mb-0" id="customerTable">
                <thead>
                    <tr class="text-center">
                        <th style="width:60px;">#</th>
                        <th>ชื่อเจ้าของสวน</th>
                        <th>ที่อยู่</th>
                        <th>เบอร์โทร</th>
                        <th>ลูกจ้างตัด</th>
                        <th style="width:110px;">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                mysqli_data_seek($result, 0);
                $i = 1;
                while ($row = mysqli_fetch_assoc($result)):
                ?>
                <tr>
                    <td class="text-center text-muted small"><?= $i++ ?></td>
                    <td>
                        <span class="fw-semibold"><?= htmlspecialchars($row['c_name']) ?></span>
                    </td>
                    <td class="text-muted small"><?= htmlspecialchars($row['c_add']) ?></td>
                    <td class="text-center">
                        <i class="fa fa-phone text-muted me-1 small"></i><?= htmlspecialchars($row['c_tel']) ?>
                    </td>
                    <td>
                        <i class="fa fa-user text-muted me-3 small"></i><?= htmlspecialchars($row['em_name']) ?>
                    </td>
                    <td class="text-center">
                        <div class="d-flex gap-1 justify-content-center">
                            <a href="views/cust_form_edit.php?act=edit&ID=<?= $row['c_id'] ?>"
                               class="btn btn-warning btn-sm" title="แก้ไขข้อมูล">
                                <i class="fa fa-pen"></i>
                            </a>
                            <a href="views/em_form_edit.php?act=edit&ID=<?= $row['c_id'] ?>"
                               class="btn btn-outline-secondary btn-sm" title="แก้ไขลูกจ้าง">
                                <i class="fa fa-user-edit"></i>
                            </a>
                            <a href="actions/cust_del_db.php?ID=<?= $row['c_id'] ?>"
                               onclick="return confirm('ยืนยันการลบรายชื่อลูกค้านี้?')"
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

<script>
function filterTable() {
    const q     = document.getElementById('searchInput').value.toLowerCase();
    const rows  = document.querySelectorAll('#customerTable tbody tr');
    rows.forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(q) ? '' : 'none';
    });
}
</script>
</body>
</html>