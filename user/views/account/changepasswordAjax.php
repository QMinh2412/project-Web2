<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="/project-Web2/user/assets/css/change_password.css">
<div class="container_change_password">
    <div class="menu_links">
        <div><a href="/project-Web2/user/index.php?page=account&action=updateAccount">Cập nhật tài khoản</a></div>
        <div class="active"><a href="/project-Web2/user/index.php?page=account&action=changePassword">Thay đổi mật khẩu</a></div>
        <div><a href="/project-Web2/user/index.php?page=order&action=showOrderHistory&current_page=1">Lịch sử đơn hàng</a></div>
    </div>
    <div class="change_password_box">
        <h2>Thay đổi mật khẩu</h2>
        <form id="change-password-form" method="POST">
            <div>
                <label for="old_password">Mật khẩu cũ</label>
                <div class="password-wrapper">
                    <input type="password" id="old_password" name="old_password" required>
                    <span class="toggle-password" onclick="togglePassword('old_password')"><i class="fa-regular fa-eye"></i></span>
                </div>
            </div>
            <div class="err err_old_pass"></div>
            <div>
                <label for="new_password">Mật khẩu mới</label>
                <div class="password-wrapper">
                    <input type="password" id="new_password" name="new_password" required>
                    <span class="toggle-password" onclick="togglePassword('new_password')"><i class="fa-regular fa-eye"></i></span>
                </div>
            </div>
            <div class="err err_new_pass"></div>
            <div>
                <label for="confirm_password">Nhập lại mật khẩu</label>
                <div class="password-wrapper">
                    <input type="password" id="confirm_password" name="confirm_password" required>
                    <span class="toggle-password" onclick="togglePassword('confirm_password')"><i class="fa-regular fa-eye"></i></span>
                </div>
            </div>
            <div class="err err_confirm_pass"></div>
            <button type="submit" id="btn_submit">Cập nhật</button>
        </form>
    </div>
</div>
<!-- <p id="message" class="message"></p> -->

<script src="/project-Web2/user/assets/js/change_password.js"></script>