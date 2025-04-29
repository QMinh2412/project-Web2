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