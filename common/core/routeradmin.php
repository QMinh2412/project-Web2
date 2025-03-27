<?php
require_once __DIR__ . '/../../admin/controllers/dashboardController.php';
require_once __DIR__ . '/../../admin/controllers/importController.php';
require_once __DIR__ . '/../../admin/controllers/orderController.php';
require_once __DIR__ . '/../../admin/controllers/productController.php';
require_once __DIR__ . '/../../admin/controllers/userController.php';


class RouteAdmin {
    public function router($url) {
        // Với mục đích thử nghiệm, ta chỉ chuyển tất cả request đến DashboardController->index()
        $controller = new DashboardController();
        $controller->index();
    }
}