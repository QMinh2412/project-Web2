

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('admin-logo').addEventListener('click', function () {
        document.getElementById('menu-down').classList.toggle('active');
    });
    const btn = document.getElementById('logoutBtn');
    if (!btn) return;

    btn.addEventListener('click', function (e) {
        e.preventDefault();

        // Gọi controller logout để destroy session
        fetch('/project-Web2/admin/controllers/loginController.php?action=logout', {
            method: 'GET',
            credentials: 'include'
        })
        .then(() => {
            // Chuyển hướng đến trang login
            window.location.replace('/project-Web2/admin/views/layouts/login.php');
        })
        .catch(() => {
            alert('Logout thất bại, thử lại.');
        });
    });
});