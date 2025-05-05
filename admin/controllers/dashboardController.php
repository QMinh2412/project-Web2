<?php
    require_once __DIR__ . '/../../common/core/BaseController.php';
    require_once __DIR__ . '/../../common/models/Dashboard.php'; 

    class DashboardController extends BaseController {
        public function index() {
            $dashboardModel = new Dashboard();
        
            $from = isset($_GET['customer-from-date']) ? $_GET['customer-from-date'] : null;
            $to = isset($_GET['customer-to-date']) ? $_GET['customer-to-date'] : null;
        
            $loyalCustomers = $dashboardModel->getLoyalCustomers($from, $to);
            $totalRev = $dashboardModel->getTotalRevenue($from, $to);
            $totalCost = $dashboardModel->getTotalCost($from, $to);
            $bestSellers = $dashboardModel->getBestSellingProducts($from, $to);
        
            $data = [
                'title' => 'Dashboard',
                'from' => $from,
                'to' => $to,
                'loyalCustomers' => $loyalCustomers,
                'totalRev' => $totalRev,
                'totalCost' => $totalCost,
                'bestSellers' => $bestSellers
            ];
        
            $this->render('dashboard/index', $data);
        }
        
        

    }
?>