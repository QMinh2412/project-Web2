<?php
    require_once __DIR__ . '/../../controllers/HomeController.php';
    $homeController = new HomeController();
    $userData = $homeController->getAccountData();
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="/project-Web2/user/assets/css/header.css">
<header>
    <div class="header">
        <a href="/project-Web2/user/index.php"><div id="logo_header"><img src="/project-Web2/common/images/logo3.png" alt="Logo"></div></a>
        <div class="search_box">
            <form id="basic_search">
                <button id="advanced" type="button">Nâng cao</button>
                <input type="text" name="name" id="search_box" placeholder="Nhập tên sách bạn cần tìm" autocomplete="off">
                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>
        <div class="product_box">
            <a href="/project-Web2/user/index.php?page=product&current_page=1">
                <i class="fa-solid fa-book"></i>
                <span>Sản phẩm</span>
            </a>
        </div>
        <div class="cart_box">
            <a href="/project-Web2/user/index.php?page=cart">
                <i class="fa-solid fa-cart-shopping"></i>
                <span>Giỏ hàng</span>
            </a>
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
                        <a href="/project-Web2/user/index.php?page=account&action=changePassword"><li>Thay đổi mật khẩu</li></a>
                        <a href="/project-Web2/user/index.php?page=order&action=showOrderHistory&current_page=1"><li>Lịch sử giao dịch</li></a>
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
    <div id="advanced_search_box">
        <form id="advanced_search">
            <div id="book_name_box">
                <label for="book_name">Tên sách: </label>
                <input type="text" name="book_name" id="book_name">
            </div>
            <div id="author_name_box">
                <label for="author_name">Tên tác giả: </label>
                <input type="text" name="author_name" id="author_name">
            </div>
            <div id="category_name_box">
                <label for="category_name">Tên thể loại: </label>
                <input type="text" name="category_name" id="category_name">
            </div>
            <div id="price_range_box">
                <label for="price_range">Khoảng giá: </label>
                <div class="range-container">
                    <input type="range" name="price_range" id="price_range" min="0" max="1000000" value="500000">
                    <span class="range-value">500,000</span>
                </div>
            </div>
            <div id="btn_box">
                <button id="close" type="button">Hủy</button>
                <button type="submit">Tìm kiếm</button>
            </div>
        </form>
    </div>
</header>
<script src="/project-Web2/user/assets/js/header.js"></script>
<?php if (isset($_GET['page']) && $_GET['page'] === 'product'): ?>
    <script src="/project-Web2/user/assets/js/product.js"></script>
<?php endif; ?>