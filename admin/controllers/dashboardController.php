<?php
    require_once __DIR__ . '/../../common/core/BaseController.php';
    require_once __DIR__ . '/../../common/models/Dashboard.php'; 

    class DashboardController extends BaseController {
        private $customerModel;

        public function __construct() {
            $this->customerModel = new Customer(); // Khởi tạo model Customer
        }

        public function index() {
            // Lấy danh sách khách hàng thân thiết
            $loyalCustomers = $this->customerModel->getLoyalCustomers();

            // Chuẩn bị dữ liệu để gửi vào view
            $data = [
                'title' => 'Dashboard',
                'loyalCustomers' => $loyalCustomers // Truyền danh sách khách hàng vào view
            ];

            $this->render('dashboard/index', $data);
        }

        public function favoriteCustomers() {
            // Lấy danh sách khách hàng thân thiết
            $loyalCustomers = $this->customerModel->getLoyalCustomers();

            $data = [
                'title' => 'Khách hàng thân thiết',
                'loyalCustomers' => $loyalCustomers
            ];

            // Gọi phương thức render để hiển thị view favoritecus.php
            $this->render('dashboard/favoritecus', $data);
        }
    }
?>