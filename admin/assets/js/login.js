document.getElementById('loginForm').addEventListener('submit', async function (event) {
    event.preventDefault();

    // Lấy giá trị từ các trường input
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();

    // Xóa thông báo lỗi cũ
    document.querySelector('.err_email').textContent = '';
    document.querySelector('.err_password').textContent = '';

    // Kiểm tra dữ liệu đầu vào
    let hasError = false;
    if (!email) {
        document.querySelector('.err_email').textContent = 'Vui lòng nhập email.';
        hasError = true;
    }
    if (!password) {
        document.querySelector('.err_password').textContent = 'Vui lòng nhập mật khẩu.';
        hasError = true;
    }

    if (hasError) return;

    try {
        // Gửi yêu cầu đăng nhập đến server
        const response = await fetch('../../api/login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ email, password }),
        });

        const result = await response.json();

        if (response.ok) {
            // Đăng nhập thành công, chuyển hướng đến trang chính
            window.location.href = '../views/layouts/main_layout.php';
        } else {
            // Hiển thị lỗi từ server
            if (result.errorField === 'email') {
                document.querySelector('.err_email').textContent = result.message;
            } else if (result.errorField === 'password') {
                document.querySelector('.err_password').textContent = result.message;
            } else {
                alert(result.message || 'Đã xảy ra lỗi, vui lòng thử lại.');
            }
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Không thể kết nối đến server. Vui lòng thử lại sau.');
    }
});

//check nếu loại tài khoản là 0, 1 nếu 1 thì chuyển hướng về trang admin dựa vào 