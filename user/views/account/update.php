<?php
    // Định dạng ngày sinh nếu có
    $dob = !empty($userInfo['NgSinhND']) ? date('Y-m-d', strtotime($userInfo['NgSinhND'])) : '';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Cập nhật tài khoản</title>
    <link rel="stylesheet" href="/project-Web2/user/assets/css/update.css">
</head>
<body>
    <div class="container_update_account">
        <div class="menu_links">
            <div class="active"><a href="#">Cập nhật tài khoản</a></div>
            <div><a href="#">Thay đổi mật khẩu</a></div>
            <div><a href="#">Lịch sử đơn hàng</a></div>
        </div>
        <div class="info_box">
            <h2>Cập nhật tài khoản</h2>
            <form id="update-account-form" method="POST" enctype="multipart/form-data">
                <div>
                    <label for="fullname">Họ tên</label>
                    <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($userInfo['TenND'] ?? ''); ?>" required>
                </div>
        
                <div>
                    <label for="username">Tên tài khoản</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($accountInfo['TenTK'] ?? ''); ?>" required>
                </div>
        
                <div>
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($userInfo['EmailND'] ?? ''); ?>" required>
                </div>
        
                <div>
                    <label for="dob">Ngày sinh</label>
                    <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($dob ?? ''); ?>">
                </div>

                <div>
                    <label for="gender">Giới tính</label>
                    <select id="gender" name="gender">
                        <option value="1" <?php echo ($userInfo['GioiTinhND'] ?? 1) == 1 ? 'selected' : ''; ?>>Nam</option>
                        <option value="0" <?php echo ($userInfo['GioiTinhND'] ?? 1) == 0 ? 'selected' : ''; ?>>Nữ</option>
                    </select>
                </div>

                <div>
                    <label for="address">Địa chỉ</label>
                    <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($userInfo['DcND'] != 'undefined' ?? ''); ?>">
                </div>

                <div>
                    <label for="phone">Số điện thoại</label>
                    <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($userInfo['SDT'] ?? ''); ?>">
                </div>
        
                <div>
                    <label for="image">Chọn tệp ảnh</label>
                    <input type="file" id="image" name="image" accept="image/*">
                </div>
                <button type="submit" id="btnSubmit">Cập nhật</button>
            </form>
        </div>
    </div>
    <p id="message" class="message"></p>

    <script src="/project-Web2/user/assets/js/updateAccount.js"></script>
</body>
</html>