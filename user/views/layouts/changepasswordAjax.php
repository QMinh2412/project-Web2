<link rel="stylesheet" href="/project-Web2/user/assets/css/change_password.css">
<h2>Thay đổi mật khẩu</h2>
<form id="change-password-form" method="POST">
    <label for="old_password">Mật khẩu cũ</label>
    <div class="password-wrapper">
        <input type="password" id="old_password" name="old_password" required>
        <span class="toggle-password" onclick="togglePassword('old_password')">👁</span>
    </div>
    <br>
    <label for="new_password">Mật khẩu mới</label>
    <div class="password-wrapper">
        <input type="password" id="new_password" name="new_password" required>
        <span class="toggle-password" onclick="togglePassword('new_password')">👁</span>
    </div>
    <br>
    <label for="confirm_password">Nhập lại mật khẩu</label>
    <div class="password-wrapper">
        <input type="password" id="confirm_password" name="confirm_password" required>
        <span class="toggle-password" onclick="togglePassword('confirm_password')">👁</span>
    </div>
    <br>
    <button type="submit">Cập nhật</button>
</form>
<p id="message" class="message"></p>

<script>
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);
    }

    document.getElementById('change-password-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        const messageElement = document.getElementById('message');

        if (newPassword !== confirmPassword) {
            messageElement.textContent = 'Mật khẩu mới và nhập lại không khớp!';
            messageElement.className = 'message error';
            messageElement.style.display = 'block';
            return;
        }

        const formData = new FormData(this);

        fetch('/project-Web2/user/index.php?page=account&action=changepasswordAjax', {
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
            messageElement.textContent = data.message;
            messageElement.className = `message ${data.status}`;
            messageElement.style.display = 'block';
            if (data.status === 'success') this.reset();
            setTimeout(() => messageElement.style.display = 'none', 5000);
        })
        .catch(error => {
            console.error('Lỗi:', error);
            messageElement.textContent = error.message;
            messageElement.className = 'message error';
            messageElement.style.display = 'block';
        });
    });
</script>