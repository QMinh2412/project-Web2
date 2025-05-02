<script src="./assets/js/leftmenu.js"></script>
<?php
$role = isset($_SESSION['role']) ? $_SESSION['role'] : null;
?>
<div id="left-menu">

    <div class="menuitems" id="admin-menu-icon">
        <i class='bx bx-menu'></i>  
    </div>
    
    <?php if ($role == 2 || $role == 4): ?>
    <a href="?page=dashboard&action=index">
        <div class="menuitems">
            <i class='bx bx-stats'></i>
            <span class="menuitems-span">Thống kê doanh thu</span>
        </div>
    </a>
    <?php endif; ?>

    <?php if ($role == 1 || $role == 4 ): ?>
    <a href="?page=category&action=index">
        <div class="menuitems">
            <i class='bx bx-category'></i>
            <span class="menuitems-span">Danh mục sách</span>
        </div>
    </a>
    <?php endif; ?>
    
    <?php if ($role == 1 || $role == 4): ?>
    <a href="?page=product&action=index&current_page=1">
        <div class="menuitems">
            <i class='bx bx-book'></i>
            <span class="menuitems-span">Sản phẩm</span>
        </div>
    </a>
    <?php endif; ?>

    <?php if ($role == 3 || $role == 4): ?>
    <a href="?page=user&action=index">
        <div class="menuitems">
            <i class='bx bxs-user-account'></i>
            <span class="menuitems-span">Tài khoản</span>
        </div>
    </a>
    <?php endif; ?>

    <?php if ($role == 1 || $role == 4): ?>
    <a href="?page=import&action=index">
        <div class="menuitems">
            <i class='bx bx-box'></i>
            <span class="menuitems-span">Quản lý kho</span>
        </div>
    </a>
    <?php endif; ?>

    <?php if ($role == 2 || $role == 4): ?>
    <a href="?page=order&action=index">
        <div class="menuitems" >
            <i class='bx bx-cart'></i>
            <span class="menuitems-span">Đơn hàng</span>
        </div>
    </a>
    <?php endif; ?>

    <?php if ($role == 2 || $role == 4): ?>
    <a href="?page=review&action=index">
        <div class="menuitems">
            <i class='bx bx-comment'></i>
            <span class="menuitems-span">Đánh giá</span>
        </div>
    </a>
    <?php endif; ?>
</div>
