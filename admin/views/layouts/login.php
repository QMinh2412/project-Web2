<link rel="stylesheet" href="../../assets/css/login.css">
    <body>
        <div class="login-container">
            <h2>Đăng nhập</h2>
            <form action="process_login.php" method="POST">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" required />
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu:</label>
                    <input type="password" name="password" id="password" required />
                </div>
                <button type="submit">Đăng nhập</button>
            </form>
        </div>
    </body>
</html>