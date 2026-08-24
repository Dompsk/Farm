<?php
// components/menu.php — nav partial only (ไม่มี DOCTYPE/html/head/body)
?>
<nav class="navbar navbar-expand-lg bg-dark navbar-dark shadow-sm"
     style="position:fixed; top:0; left:0; width:100%; z-index:1000;">
  <div class="container-fluid px-4">
    <a class="navbar-brand fw-bold text-warning" href="/Farm/index.php">
      <i class="fa-solid fa-truck me-1"></i>ระบบร้านน้ำยาง!!
    </a>
    <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse" data-bs-target="#mainNav"
            aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav ms-auto gap-1">
        <li class="nav-item">
          <a class="nav-link text-light fw-semibold px-3" href="/Farm/index.php">
            👩🏻‍🌾 จัดการรายชื่อลูกค้า
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light fw-semibold px-3" href="/Farm/views/daily_rubber_receive.php">
            📦 การรับน้ำยางรายวัน
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light fw-semibold px-3" href="/Farm/views/daily_price.php">
            🌳 ราคาน้ำยางรายวัน
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light fw-semibold px-3" href="/Farm/views/payment.php">
            💸 การจ่ายเงินลูกค้า
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- Bootstrap JS (required for navbar toggle) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
