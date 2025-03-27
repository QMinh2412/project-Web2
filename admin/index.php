<?php
// admin/index.php
// Entry point for the Admin section of the website

session_start(); // Nếu muốn dùng session để quản lý đăng nhập admin

// (Optional) Kiểm tra xem user có quyền truy cập admin hay không
// if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
//     header('Location: /user/account/login');
//     exit;
// }

// Nạp file RouteAdmin (điều hướng cho admin)
require_once __DIR__ . '/../common/core/routeradmin.php';

// Lấy đường dẫn hiện tại
$currentUrl = $_SERVER['REQUEST_URI'];
echo $currentUrl;

// Khởi tạo router và điều hướng
$route = new RouteAdmin();
$route->router($currentUrl);
?>