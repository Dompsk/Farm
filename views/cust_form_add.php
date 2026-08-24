<?php
include('../config/condb.php');

// ดึงรายชื่อพนักงาน (ลูกจ้างตัด) สำหรับ dropdown
$sql_em = "SELECT em_id, em_name FROM employee ORDER BY em_name ASC";
$result_em = mysqli_query($con, $sql_em);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มลูกค้าใหม่ — Farm</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            background: #f5f6fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .form-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            max-width: 600px;
            margin: 0 auto;
        }

        .form-card-header {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            padding: 32px 36px 28px;
            text-align: center;
            color: #fff;
        }

        .form-card-header .icon-circle {
            width: 68px;
            height: 68px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin: 0 auto 14px;
            border: 2px solid rgba(255, 255, 255, 0.25);
        }

        .form-card-header h4 {
            font-weight: 700;
            margin-bottom: 4px;
            font-size: 1.3rem;
        }

        .form-card-header p {
            opacity: 0.75;
            font-size: 0.88rem;
            margin: 0;
        }

        .form-card-body {
            padding: 32px 36px;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.88rem;
            color: #374151;
            margin-bottom: 6px;
        }

        .form-control, .form-select {
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 0.93rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus, .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.12);
        }

        .input-icon-wrap {
            position: relative;
        }

        .input-icon-wrap .input-icon {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 0.85rem;
            pointer-events: none;
        }

        .input-icon-wrap .form-control,
        .input-icon-wrap .form-select {
            padding-left: 36px;
        }

        .btn-submit {
            background: linear-gradient(135deg, #0d6efd, #0a58ca);
            border: none;
            border-radius: 10px;
            padding: 11px 0;
            font-weight: 600;
            font-size: 0.95rem;
            letter-spacing: 0.3px;
            transition: transform 0.15s, box-shadow 0.15s;
        }

        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(13, 110, 253, 0.35);
        }

        .btn-back {
            border-radius: 10px;
            padding: 11px 0;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .divider {
            border-top: 1px solid #f1f3f5;
            margin: 24px 0;
        }

        .section-label {
            font-size: 0.78rem;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 16px;
        }

        /* Validation feedback */
        .form-control.is-invalid,
        .form-select.is-invalid {
            border-color: #dc3545;
        }
    </style>
</head>
<body>
<?php include('../components/menu.php'); ?>
<div class="container-fluid px-4" style="padding-top: 90px; padding-bottom: 60px;">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/Farm/index.php" class="text-decoration-none text-primary">
                    <i class="fa-solid fa-house me-1"></i>หน้าหลัก
                </a>
            </li>
            <li class="breadcrumb-item active text-muted">เพิ่มลูกค้าใหม่</li>
        </ol>
    </nav>

    <!-- Form Card -->
    <div class="form-card">

        <!-- Header -->
        <div class="form-card-header">
            <div class="icon-circle">
                <i class="fa-solid fa-user-plus"></i>
            </div>
            <h4>เพิ่มลูกค้าใหม่</h4>
            <p>กรอกข้อมูลเจ้าของสวนยางพาราให้ครบถ้วน</p>
        </div>

        <!-- Body -->
        <div class="form-card-body">
            <form id="addCustomerForm" action="../actions/cust_add_db.php" method="POST" novalidate>

                <!-- ข้อมูลส่วนตัว -->
                <div class="section-label">
                    <i class="fa fa-id-card me-1"></i>ข้อมูลลูกค้า
                </div>

                <!-- ชื่อเจ้าของสวน -->
                <div class="mb-4">
                    <label for="c_name" class="form-label">
                        ชื่อเจ้าของสวน <span class="text-danger">*</span>
                    </label>
                    <div class="input-icon-wrap">
                        <i class="fa fa-user input-icon"></i>
                        <input
                            type="text"
                            id="c_name"
                            name="c_name"
                            class="form-control"
                            placeholder="ระบุชื่อเจ้าของสวน"
                            required
                            autocomplete="off"
                        >
                    </div>
                </div>

                <!-- ที่อยู่ -->
                <div class="mb-4">
                    <label for="c_add" class="form-label">
                        ที่อยู่ <span class="text-danger">*</span>
                    </label>
                    <div class="input-icon-wrap">
                        <i class="fa fa-map-marker-alt input-icon"></i>
                        <input
                            type="text"
                            id="c_add"
                            name="c_add"
                            class="form-control"
                            placeholder="บ้านเลขที่ / หมู่บ้าน / ตำบล"
                            required
                            autocomplete="off"
                        >
                    </div>
                </div>

                <!-- เบอร์โทร -->
                <div class="mb-4">
                    <label for="c_tel" class="form-label">
                        เบอร์โทรศัพท์ <span class="text-danger">*</span>
                    </label>
                    <div class="input-icon-wrap">
                        <i class="fa fa-phone input-icon"></i>
                        <input
                            type="tel"
                            id="c_tel"
                            name="c_tel"
                            class="form-control"
                            placeholder="0xx-xxx-xxxx"
                            required
                            pattern="[0-9]{9,10}"
                            maxlength="10"
                            autocomplete="off"
                        >
                    </div>
                    <div class="form-text text-muted" style="font-size:0.8rem;">
                        <i class="fa fa-info-circle me-1"></i>กรอกตัวเลข 9-10 หลัก (ไม่ต้องใส่ขีด)
                    </div>
                </div>

                <div class="divider"></div>

                <!-- ลูกจ้างตัด -->
                <div class="section-label">
                    <i class="fa fa-users me-1"></i>ลูกจ้างที่ดูแล
                </div>

                <div class="mb-4">
                    <!-- Label + Checkbox toggle -->
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <label for="em_name_new" class="form-label mb-0">
                            ลูกจ้างตัด <span class="text-danger">*</span>
                        </label>
                        <div class="form-check form-switch mb-0" style="cursor:pointer;">
                            <input class="form-check-input" type="checkbox" role="switch"
                                   id="toggleExistEm" onchange="toggleEmMode()">
                            <label class="form-check-label text-muted" for="toggleExistEm"
                                   style="font-size:0.82rem; cursor:pointer;">
                                <i class="fa fa-list-ul me-1"></i>เลือกจากรายชื่อเดิม
                            </label>
                        </div>
                    </div>

                    <!-- MODE A: พิมพ์ชื่อใหม่ (default) -->
                    <div id="wrapNewEm">
                        <div class="input-icon-wrap">
                            <i class="fa fa-hard-hat input-icon"></i>
                            <input
                                type="text"
                                id="em_name_new"
                                name="em_name_new"
                                class="form-control"
                                placeholder="พิมพ์ชื่อลูกจ้างตัด"
                                required
                                autocomplete="off"
                            >
                        </div>
                        <div class="form-text text-muted" style="font-size:0.8rem;">
                            <i class="fa fa-info-circle me-1"></i>ระบบจะสร้างลูกจ้างใหม่ให้อัตโนมัติ
                        </div>
                    </div>

                    <!-- MODE B: เลือกจาก dropdown (ซ่อนไว้ก่อน) -->
                    <div id="wrapExistEm" style="display:none;">
                        <div class="input-icon-wrap">
                            <i class="fa fa-hard-hat input-icon"></i>
                            <select id="em_id" name="em_id" class="form-select">
                                <option value="" disabled selected>— เลือกลูกจ้างตัด —</option>
                                <?php
                                    mysqli_data_seek($result_em, 0);
                                    while ($em = mysqli_fetch_assoc($result_em)):
                                ?>
                                    <option value="<?= $em['em_id'] ?>"><?= htmlspecialchars($em['em_name']) ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
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
                        <button type="submit" class="btn btn-primary btn-submit w-100" id="btnSubmit">
                            <i class="fa fa-save me-1"></i>บันทึกข้อมูล
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    /* ===== Toggle โหมดลูกจ้าง ===== */
    function toggleEmMode() {
        const useExist  = document.getElementById('toggleExistEm').checked;
        const wrapNew   = document.getElementById('wrapNewEm');
        const wrapExist = document.getElementById('wrapExistEm');
        const inputNew  = document.getElementById('em_name_new');
        const selectEx  = document.getElementById('em_id');

        if (useExist) {
            // โหมด dropdown
            wrapNew.style.display   = 'none';
            wrapExist.style.display = '';
            inputNew.removeAttribute('required');
            inputNew.value = '';
            selectEx.setAttribute('required', '');
        } else {
            // โหมดพิมพ์ใหม่
            wrapNew.style.display   = '';
            wrapExist.style.display = 'none';
            selectEx.removeAttribute('required');
            selectEx.value = '';
            inputNew.setAttribute('required', '');
        }
    }

    /* ===== Validation + Anti-double-submit ===== */
    const form      = document.getElementById('addCustomerForm');
    const btnSubmit = document.getElementById('btnSubmit');

    form.addEventListener('submit', function (e) {
        // ตรวจสอบ dropdown ถ้าอยู่ในโหมด dropdown
        const useExist = document.getElementById('toggleExistEm').checked;
        if (useExist) {
            const selectEx = document.getElementById('em_id');
            if (!selectEx.value) {
                e.preventDefault();
                selectEx.classList.add('is-invalid');
                selectEx.focus();
                return;
            } else {
                selectEx.classList.remove('is-invalid');
            }
        }

        if (!form.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
            form.classList.add('was-validated');
            return;
        }

        // ป้องกันคลิกซ้ำ
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>กำลังบันทึก…';
    });

    // อนุญาตเฉพาะตัวเลขในช่องเบอร์โทร
    document.getElementById('c_tel').addEventListener('input', function () {
        this.value = this.value.replace(/\D/g, '');
    });

    // ล้าง invalid state เมื่อเปลี่ยน dropdown
    document.getElementById('em_id').addEventListener('change', function () {
        this.classList.remove('is-invalid');
    });
</script>
</body>
</html>
