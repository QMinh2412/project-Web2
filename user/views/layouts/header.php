<?php
    require_once __DIR__ . '/../../controllers/HomeController.php';
    $homeController = new HomeController();
    $userData = $homeController->getAccountData();
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="/project-Web2/user/assets/css/header.css">
<header>
    <div class="header">
        <div id="logo_header"><img src="/project-Web2/common/images/logo3.png" alt="Logo"></div>
        <div class="search_box">
            <form method="GET" action="/project-Web2/user/index.php?page=product&amp;action=search">
                <input type="text" name="search" id="search_box" placeholder="Nhập tên sách bạn cần tìm" autocomplete="off">
                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>
        <div class="cart_box">
            <i class="fa-solid fa-cart-shopping"></i>
            <span>Giỏ hàng</span>
        </div>
        <div class="account_box">
            <?php if($userData): ?>
                <div class="avatar">
                    <img src="<?php echo $userData[1]; ?>" alt="avatar">
                </div>
                <span><?php echo $userData[0]; ?></span>
                <div class="sub_menu" style="display: none;">
                    <ul>
                        <a href="/project-Web2/user/index.php?page=account&action=updateAccount"><li>Cập nhật tài khoản</li></a>
                        <a href="/project-Web2/user/index.php?page=account&action=changepassword"><li>Thay đổi mật khẩu</li></a>
                        <a href="#"><li>Lịch sử giao dịch</li></a>
                        <a href="/project-Web2/user/index.php?page=account&action=logout"><li style="color: red;">Đăng xuất</li></a>
                    </ul>
                </div>
            <?php else: ?>
                <div class="avatar">
                    <img src="/project-Web2/common/images/defaultuser.png" alt="avatar">
                </div>
                <span>Tài khoản</span>
                <div class="sub_menu" style="display: none;">
                    <ul>
                        <a href="/project-Web2/user/views/layouts/login.php"><li>Đăng nhập</li></a>
                        <a href="/project-Web2/user/views/layouts/register.php"><li>Đăng ký</li></a>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
</header>
<script src="/project-Web2/user/assets/js/header.js"></script>