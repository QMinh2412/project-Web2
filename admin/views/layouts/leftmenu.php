<script src="./assets/js/leftmenu.js"></script>

<div id="left-menu">
    <a href="?page=dashboard&action=index">
        <div class="menuitems">
            <i class='bx bx-stats'></i>
            <span class="menuitems-span">Thống kê doanh thu</span>
        </div>
    </a>

    <a href="?page=category&action=index">
        <div class="menuitems">
            <i class='bx bx-category'></i>
            <span class="menuitems-span">Danh mục sách</span>
        </div>
    </a>

    <a href="?page=product&action=index&current_page=1">
        <div class="menuitems">
            <i class='bx bx-book'></i>
            <span class="menuitems-span">Sản phẩm</span>
        </div>
    </a>

    <a href="?page=user&action=index">
        <div class="menuitems">
            <i class='bx bxs-user-account'></i>
            <span class="menuitems-span">Tài khoản</span>
        </div>
    </a>
    
    <div class="menuitems dropdown">
        <div class="dropdown-header">
            <i class='bx bx-box'></i>
            <span class="menuitems-span">Quản lý kho</span>
            <i class='bx bxs-chevron-down' id="storage-arrow-down"></i>
        </div>
        <div class="dropdown-content">
            <a href="?page=warehouse&action=history">
                <div class="menuitems">
                    <i class='bx bx-history'></i>
                    <span class="menuitems-span" id="dropdownitems">Lịch sử nhập hàng</span>
                </div>
            </a>
            <a href="?page=warehouse&action=index">
                <div class="menuitems">
                    <i class='bx bx-download'></i>
                    <span class="menuitems-span" id="dropdownitems">Nhập sách</span>
                </div>
            </a>
        </div>
    </div>
    
    <a href="?page=order&action=index">
        <div class="menuitems" >
            <i class='bx bx-cart'></i>
            <span class="menuitems-span">Đơn hàng</span>
        </div>
    </a>

    <a href="?page=review&action=index">
        <div class="menuitems">
            <i class='bx bx-comment'></i>
            <span class="menuitems-span">Đánh giá</span>
        </div>
    </a>

</div>
