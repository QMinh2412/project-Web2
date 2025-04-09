<?php
  // //khi chưa đăng nhập thì không cho vào trang này//
  // session_start();
  // if (!isset($_SESSION['user_id'])) {
  //     header("Location: /project-Web2/admin/views/layouts/login.php");
  //     exit;
  // }
  // //kiểm tra quyền admin//
  // if ($_SESSION['role'] != 'admin') {
  //     header("Location: /project-Web2/user/views/home/index.php");
  //     exit;
  // }
?>

<!-- header.php -->
<header>
  <div class="header">
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
        <li><button onclick="location.href='/project-Web2/admin/views/layouts/login.php'">Đổi tài khoản</button></li>
        <li><button onclick="location.href='/project-Web2/admin/views/layouts/login.php'">Đăng xuất</button></li>
      </ul>
    </div>
  </div>
<script src="./assets/js/header.js"></script>
</header>