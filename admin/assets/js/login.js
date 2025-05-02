$(document).ready(function () {
    $('#loginForm').on('submit', function (e) {
        e.preventDefault(); // Ngăn form gửi yêu cầu tải lại trang

        // Lấy dữ liệu từ form
        const TenTK = $('#TenTK').val();
        const MKTK = $('#MKTK').val();

        // Gửi yêu cầu AJAX
        $.ajax({
            url: '/project-Web2/admin/controllers/loginController.php?action=login',
            type: 'POST',
            data: { TenTK: TenTK, MKTK: MKTK },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success' && response.redirect) {
                    // Đăng nhập thành công, chuyển hướng đến URL được trả về
                    window.location.href = response.redirect;
                } else {
                    // Hiển thị thông báo lỗi
                    $('#message').text(response.message || 'Đã xảy ra lỗi, vui lòng thử lại!');
                }
            },
            error: function () {
                $('#message').text('Đã xảy ra lỗi, vui lòng thử lại!');
            }
        });
    });
});