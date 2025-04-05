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
                <input type="email" name="email" id="email" autocomplete="email" />
            </div>
            <div class="err err_email"></div>
            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" name="password" id="password" autocomplete="current-password"/>
            </div>
            <div class="err err_password"></div>
            <button type="submit">Đăng nhập</button>
        </form>
    </div>

    <script src="../../assets/js/login.js"></script>
</body>
</html>

