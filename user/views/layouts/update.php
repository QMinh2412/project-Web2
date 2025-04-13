<?php
require_once __DIR__ . '/../../../common/models/Account.php';
require_once __DIR__ . '/../../../common/models/User.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['account_id'])) {
    header('Location: /project-Web2/user/index.php');
    exit();
}

// Lấy thông tin tài khoản
$accountModel = new Account();
$userModel = new User();
$accountInfo = $accountModel->getById($_SESSION['account_id']);
$userInfo = $userModel->getById($_SESSION['account_id']);

// Kiểm tra nếu không tìm thấy thông tin người dùng
if (!$userInfo || !$accountInfo) {
    echo "Không tìm thấy thông tin tài khoản. Vui lòng đăng nhập lại.";
    echo '<br><a href="/project-Web2/user/index.php?page=account&action=logout">Đăng xuất</a>';
    exit();
}

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
    <h2>Cập nhật tài khoản</h2>
    <form id="update-account-form" method="POST" enctype="multipart/form-data">
        <label for="fullname">Họ tên</label>
        <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($userInfo['TenND'] ?? ''); ?>" required>

        <label for="username">Tên tài khoản</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($accountInfo['TenTK'] ?? ''); ?>" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($userInfo['EmailND'] ?? ''); ?>" required>

        <?php if (!empty($userInfo['NgSinhND'])): ?>
            <label for="dob">Ngày sinh</label>
            <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($dob); ?>">
        <?php endif; ?>

        <?php if (!empty($userInfo['GioiTinhND'])): ?>
            <label for="gender">Giới tính</label>
            <select id="gender" name="gender">
                <option value="Nam" <?php echo ($userInfo['GioiTinhND'] ?? '') === 'Nam' ? 'selected' : ''; ?>>Nam</option>
                <option value="Nữ" <?php echo ($userInfo['GioiTinhND'] ?? '') === 'Nữ' ? 'selected' : ''; ?>>Nữ</option>
                <option value="Khác" <?php echo ($userInfo['GioiTinhND'] ?? '') === 'Khác' ? 'selected' : ''; ?>>Khác</option>
            </select>
        <?php else: ?>
            <label for="gender">Giới tính</label>
            <select id="gender" name="gender">
                <option value="Nam">Nam</option>
                <option value="Nữ">Nữ</option>
                <option value="Khác">Khác</option>
            </select>
        <?php endif; ?>

        <?php if (!empty($userInfo['DcND'])): ?>
            <label for="address">Địa chỉ</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($userInfo['DcND']); ?>">
        <?php endif; ?>

        <?php if (!empty($userInfo['SDT'])): ?>
            <label for="phone">Số điện thoại</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($userInfo['SDT'] ?? ''); ?>">
        <?php endif; ?>

        <label for="image">Chọn tệp ảnh</label>
        <input type="file" id="image" name="image" accept="image/*">

        <button type="submit">Cập nhật</button>
    </form>
    <p id="message" class="message"></p>

    <script>
        document.getElementById('update-account-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('/project-Web2/user/index.php?page=account&action=updateAccountAjax', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => { throw new Error('Phản hồi không hợp lệ: ' + text); });
                }
                return response.json();
            })
            .then(data => {
                const messageElement = document.getElementById('message');
                messageElement.textContent = data.message;
                messageElement.className = `message ${data.status}`;
                messageElement.style.display = 'block';
                if (data.status === 'success') {
                    setTimeout(() => window.location.href = '/project-Web2/user/index.php', 2000);
                }
            })
            .catch(error => {
                console.error('Lỗi:', error);
                const messageElement = document.getElementById('message');
                messageElement.textContent = error.message;
                messageElement.className = 'message error';
                messageElement.style.display = 'block';
            });
        });
    </script>
</body>
</html>