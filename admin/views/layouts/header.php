<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ngăn trình duyệt lưu cache
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Nếu session không tồn tại, chuyển hướng về trang login
if (!isset($_SESSION['user_id'])) {
    header("Location: /project-Web2/admin/views/layouts/login.php");
    exit;
}
?>

<script src="./assets/js/header.js"></script>
<script src="./assets/js/login.js"></script>

  <div class="header">
  <button id="mobile-menu-toggle">
    <i class='bx bx-menu' id="mobile-menu-toggle-i"></i>
  </button>
    <div id="logo-header">
      <h4>Admin</h4>
    </div>
    <div id="admin-logo">
      <img src="../common/images/defaultuser.png" alt="Admin Logo">
    </div>
    <div id="admin-name-container">
      <span id="admin-name">
        <?php 
        echo isset($_SESSION['TenTK']) ? htmlspecialchars($_SESSION['TenTK']) : '?'; 
        ?>
      </span>
    </div>
    <div class="menu-down" id="menu-down">
      <ul>
        <li>
          <button id="logoutBtn">Đăng xuất</button>
        </li>
      </ul>
    </div>
  </div>



