<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Farm</title>

  <!-- Bootstrap 5 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  
  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

  <style>
    nav {
      width: 100%;
      background-color: #333;
      padding: 20px;
      position: fixed; /* ทำให้เมนูคงที่ */
      top: 0; /* อยู่ที่ด้านบนของหน้า */
      left: 0; /* เริ่มต้นจากขอบซ้าย */
      z-index: 1000; /* ทำให้เมนูอยู่เหนือเนื้อหาอื่น ๆ */
    }

    nav a {
      color: white;
      text-decoration: none;
      margin: 10px;
    }

    .navbar-nav .nav-link {
      transition: 0.3s;
    }

    .navbar-nav .nav-link:hover {
      color: #f8c102 !important; /* เปลี่ยนเป็นสีทองเมื่อโฮเวอร์ */
    }

    body {
      margin-top: 80px; /* ปรับระยะห่างด้านบนเพื่อให้เนื้อหาไม่ทับกับ Navbar */
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-dark navbar-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold text-warning" href="customer_list.php">
      <i class="fa-solid fa-truck" ></i> ระบบร้านน้ำยาง!!
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto">
      <li class="nav-item">
          <a class="nav-link text-light fw-semibold" href="customer_list.php">👩🏻‍🌾 จัดการรายชื่อลูกค้า</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light fw-semibold" href="daily_rubber_receive.php">📦 การรับน้ำยางรายวัน</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light fw-semibold" href="daily_price.php">🌳 ราคาน้ำยางรายวัน</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light fw-semibold" href="payment.php">💸 การจ่ายเงินลูกค้า</a>
        </li>
        
        
    
      </ul>
    </div>
  </div>
</nav>

<!-- Bootstrap JS (ต้องมีเพื่อให้ Navbar Toggle ทำงาน) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
