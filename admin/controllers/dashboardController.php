<?php
    require_once __DIR__ . '/../../common/core/BaseController.php';
    require_once __DIR__ . '/../../common/models/Dashboard.php'; 

    class DashboardController extends BaseController {
        public function index() {
            // Lấy danh sách khách hàng thân thiết
            $orderModel = new Order();
            $dashboardModel = new Dashboard();
            $loyalCustomers = $dashboardModel->getLoyalCustomers();
            $totalRev = $dashboardModel->getTotalRevenue();
            $totalCost = $dashboardModel->getTotalCost();
            $bestSellers = $dashboardModel->getBestSellingProducts();

            // Chuẩn bị dữ liệu để gửi vào view
            $data = [
                'title' => 'Dashboard',
                'loyalCustomers' => $loyalCustomers, // Truyền danh sách khách hàng vào view
                'totalRev' => $totalRev,
                'totalCost' => $totalCost,
                'bestSellers' => $bestSellers
            ];

            $this->render('dashboard/index', $data);
        }

    }
?>