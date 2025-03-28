<?php
    require_once __DIR__ . '/../../common/models/Account.php';

    class HomeController {
        public function getAccountData() {
            session_start();
            if (isset($_SESSION['account_id'])) {
                $accountModel = new Account();
                $name  = $accountModel->getNameById($_SESSION['account_id']);
                $image = $accountModel->getImage($_SESSION['account_id']);
                return [$name, $image];
            }
            return null;
        }

        public function index() {
            // Định nghĩa biến $content
            // $content = 'hello world'; 
        
            // Bắt đầu buffering để lấy nội dung từ index.php
            ob_start();
            include '../views/home/index.php'; 
            $main_content = ob_get_clean(); 
        
            // Gọi file main_layout.php với $main_content đã được định nghĩa
            include __DIR__ . '/../views/layouts/main_layout.php'; // Đảm bảo đường dẫn chính xác
        }
        
    }
    
?>