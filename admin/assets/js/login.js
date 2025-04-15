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
                if (response.status === 'success') {
                    // Đăng nhập thành công, chuyển hướng đến dashboard
                    window.location.href = '/project-Web2/admin/index.php?page=dashboard&action=index';
                } else {
                    // Hiển thị thông báo lỗi
                    $('#message').text(response.message);
                }
            },
            error: function () {
                $('#message').text('Đã xảy ra lỗi, vui lòng thử lại!');
            }
        });
    });
});