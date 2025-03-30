<?php
// Bắt đầu session
session_start();

// Kiểm tra nếu người dùng đã đăng nhập, chuyển hướng đến trang chính
if (isset($_SESSION['user_id'])) {
    header("Location: main_layout.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="../../assets/css/login.css">
</head>
<body>
    <div class="login-container">
        <h2>Đăng nhập</h2>
        <form id="loginForm">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" autocomplete="email" required />
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" name="password" id="password" autocomplete="current-password" required />
            </div>
            <p class="err_message" style="color: red;"></p>
            <button type="submit">Đăng nhập</button>
            <span class="err_email" style="color: red;"></span>
            <span class="err_password" style="color: red;"></span>
        </form>
        <div class="register-link">
            Chưa có tài khoản? <a href="register.php">Đăng ký</a>
        </div>
    </div>

    <script src="../../assets/js/login.js"></script>
</body>
</html>

