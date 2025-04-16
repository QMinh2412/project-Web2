<?php
  // Nếu session không tồn tại nhưng cookie có, khôi phục session từ cookie
  if (!isset($_SESSION['user_id']) && isset($_COOKIE['user_id'])) {
      $_SESSION['user_id'] = $_COOKIE['user_id'];
      $_SESSION['role'] = $_COOKIE['role'];
      $_SESSION['TenTK'] = $_COOKIE['TenTK'];
  }
  
  // Kiểm tra trạng thái đăng nhập
  if (isset($_SESSION['user_id'])) {
      $TenTK = $_SESSION['TenTK']; 
  } 
?>

<!-- header.php -->
<header>
  <div class="header">
  <button id="mobile-menu-toggle">
    <i class='bx bx-menu' id="mobile-menu-toggle-i"></i>
  </button>
    <div id="logo_header">
      <img src="../common/images/logo3.png" alt="logo">
    </div>
    <div id="admin-logo">
      <img src="../common/images/defaultuser.png" alt="Admin Logo">
    </div>
    <div id="admin-name-container">
      <span id="admin-name">
        <?php 
        // Kiểm tra nếu TenTK tồn tại trong session
        echo isset($_SESSION['TenTK']) ? htmlspecialchars($_SESSION['TenTK']) : 'Tên không xác định'; 
        ?>
      </span>
    </div>
    <div class="menu-down" id="menu-down">
      <ul>
        <li><button onclick="location.href='/project-Web2/admin/views/layouts/login.php'">Đăng xuất</button></li>
      </ul>
    </div>
  </div>
<script src="./assets/js/header.js"></script>
</header>