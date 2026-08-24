<?php
include('../config/condb.php');

$c_id   = intval($_GET['ID']);
$sql    = "SELECT c.*, e.em_name FROM customer AS c
           LEFT JOIN employee AS e ON c.em_id = e.em_id
           WHERE c.c_id = '$c_id' LIMIT 1";
$result = mysqli_query($con, $sql) or die("Error: " . mysqli_error($con));

if (mysqli_num_rows($result) === 0) {
    echo "<script>alert('ไม่พบข้อมูลลูกค้า'); window.location='../index.php';</script>";
    exit;
}
$row = mysqli_fetch_assoc($result);
extract($row);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลลูกค้า — Farm</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { background: #f5f6fa; font-family: 'Segoe UI', sans-serif; }

        .form-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,.08);
            overflow: hidden;
            max-width: 580px;
            margin: 0 auto;
        }
        .form-card-header {
            background: #fff;
            border-bottom: 2px solid #e9ecef;
            padding: 28px 36px 22px;
            text-align: center;
        }
        .form-card-header .icon-circle {
            width: 56px; height: 56px;
            background: #e3f0ff;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.45rem;
            color: #1565c0;
            margin: 0 auto 14px;
        }
        .form-card-header h4 {
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 3px;
            font-size: 1.18rem;
        }
        .form-card-header p {
            color: #6b7280;
            font-size: .85rem;
            margin: 0;
        }
        .id-badge {
            display: inline-flex; align-items: center; gap: 5px;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            padding: 3px 12px;
            font-size: .8rem;
            margin-top: 10px;
            color: #374151;
            font-weight: 600;
        }

        .form-card-body { padding: 28px 36px; }

        .form-label {
            font-weight: 600;
            font-size: .86rem;
            color: #374151;
            margin-bottom: 5px;
        }
        .form-control {
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: .92rem;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-control:focus {
            border-color: #f59e0b;
            box-shadow: 0 0 0 3px rgba(245,158,11,.12);
        }
        .form-control[readonly] {
            background: #f8f9fa;
            color: #6b7280;
            cursor: not-allowed;
        }
        .input-icon-wrap { position: relative; }
        .input-icon-wrap .input-icon {
            position: absolute; left: 13px; top: 50%;
            transform: translateY(-50%);
            color: #9ca3af; font-size: .83rem; pointer-events: none;
        }
        .input-icon-wrap .form-control { padding-left: 36px; }

        .divider { border-top: 1px solid #f1f3f5; margin: 20px 0; }
        .section-label {
            font-size: .76rem; font-weight: 700;
            color: #9ca3af; text-transform: uppercase;
            letter-spacing: .8px; margin-bottom: 14px;
        }

        .btn-save {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            border: none; border-radius: 10px;
            padding: 11px 0; font-weight: 600;
            font-size: .94rem; color: #fff;
            transition: transform .15s, box-shadow .15s;
        }
        .btn-save:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(245,158,11,.35);
            color: #fff;
        }
        .btn-back { border-radius: 10px; padding: 11px 0; font-weight: 600; font-size: .94rem; }
    </style>
</head>
<body>
<?php include('../components/menu.php'); ?>
<div class="container-fluid px-4" style="padding-top:90px; padding-bottom:60px;">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/Farm/index.php" class="text-decoration-none text-primary">
                    <i class="fa-solid fa-house me-1"></i>หน้าหลัก
                </a>
            </li>
            <li class="breadcrumb-item active text-muted">แก้ไขข้อมูลลูกค้า</li>
        </ol>
    </nav>

    <!-- Form Card -->
    <div class="form-card">

        <!-- Header -->
        <div class="form-card-header">
            <div class="icon-circle"><i class="fa-solid fa-user-pen"></i></div>
            <h4>แก้ไขข้อมูลลูกค้า</h4>
            <p>อัพเดตข้อมูลเจ้าของสวนยางพารา</p>
            <span class="id-badge">
                <i class="fa fa-hashtag" style="font-size:.75rem;"></i>
                รหัสลูกค้า <?= htmlspecialchars($c_id) ?>
            </span>
        </div>

        <!-- Body -->
        <div class="form-card-body">
            <form id="editForm" action="../actions/cust_form_edit_db.php" method="POST" novalidate>
                <input type="hidden" name="c_id" value="<?= htmlspecialchars($c_id) ?>">

                <div class="section-label"><i class="fa fa-id-card me-1"></i>ข้อมูลลูกค้า</div>

                <!-- ชื่อเจ้าของสวน -->
                <div class="mb-4">
                    <label for="c_name" class="form-label">
                        ชื่อเจ้าของสวน <span class="text-danger">*</span>
                    </label>
                    <div class="input-icon-wrap">
                        <i class="fa fa-user input-icon"></i>
                        <input type="text" id="c_name" name="c_name" class="form-control"
                               placeholder="ชื่อเจ้าของสวน" required
                               value="<?= htmlspecialchars($c_name) ?>">
                    </div>
                </div>

                <!-- ที่อยู่ -->
                <div class="mb-4">
                    <label for="c_add" class="form-label">
                        ที่อยู่ <span class="text-danger">*</span>
                    </label>
                    <div class="input-icon-wrap">
                        <i class="fa fa-map-marker-alt input-icon"></i>
                        <input type="text" id="c_add" name="c_add" class="form-control"
                               placeholder="บ้านเลขที่ / หมู่บ้าน / ตำบล" required
                               value="<?= htmlspecialchars($c_add) ?>">
                    </div>
                </div>

                <!-- เบอร์โทร -->
                <div class="mb-4">
                    <label for="c_tel" class="form-label">
                        เบอร์โทรศัพท์ <span class="text-danger">*</span>
                    </label>
                    <div class="input-icon-wrap">
                        <i class="fa fa-phone input-icon"></i>
                        <input type="tel" id="c_tel" name="c_tel" class="form-control"
                               placeholder="0xx-xxx-xxxx" required
                               pattern="[0-9]{9,10}" maxlength="10"
                               value="<?= htmlspecialchars($c_tel) ?>">
                    </div>
                </div>

                <div class="divider"></div>

                <!-- ปุ่ม -->
                <div class="row g-3">
                    <div class="col-6">
                        <a href="/Farm/index.php" class="btn btn-outline-secondary btn-back w-100">
                            <i class="fa fa-arrow-left me-1"></i>ยกเลิก
                        </a>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-save w-100" id="btnSave">
                            <i class="fa fa-save me-1"></i>บันทึกการแก้ไข
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const form    = document.getElementById('editForm');
    const btnSave = document.getElementById('btnSave');

    form.addEventListener('submit', function (e) {
        if (!form.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
            form.classList.add('was-validated');
            return;
        }
        btnSave.disabled = true;
        btnSave.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>กำลังบันทึก…';
    });

    document.getElementById('c_tel').addEventListener('input', function () {
        this.value = this.value.replace(/\D/g, '');
    });
</script>
</body>
</html>
