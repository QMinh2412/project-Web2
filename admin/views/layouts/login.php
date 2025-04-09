<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="../../assets/css/login.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="login-container">
        <h2>Đăng nhập</h2>
        <!-- Thông báo lỗi -->
        <div id="message"></div>
        <form id="loginForm" method="POST" action="/project-Web2/admin/controllers/loginController.php?action=login">
            <div class="form-group">
                <label for="TenTK">Tên tài khoản:</label>
                <input type="text" name="TenTK" id="TenTK" required />
            </div>
            <div class="form-group">
                <label for="MKTK">Mật khẩu:</label>
                <input type="password" name="MKTK" id="MKTK" required />
            </div>
            <button type="submit">Đăng nhập</button>
        </form>
    </div>

    <script src="../../assets/js/login.js"></script>
</body>
</html>