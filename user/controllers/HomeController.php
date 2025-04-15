<?php
    require_once __DIR__ . '/../../common/models/Account.php';
    require_once __DIR__ . '/../../common/models/Category.php';
    require_once __DIR__ . '/../../common/models/Product.php';

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
            $content = 'hello world'; 

            $categoryModel = new Category();
            $categories = $categoryModel->getCategoryLimit(); // Lấy tất cả thể loại

            $productModel = new Product();
            $products1 = $productModel->getProductByCategory(1, 1, 6); // Lấy tất cả sản phẩm
            $category1 = $categoryModel->getCategoryById(1); // Lấy thể loại 1
            $products2 = $productModel->getProductByCategory(4, 1, 6);
            $category2 = $categoryModel->getCategoryById(4);
        
            // Bắt đầu buffering để lấy nội dung từ index.php
            ob_start();
            include __DIR__ . '/../views/home/index.php'; // Đảm bảo đường dẫn chính xác
            $main_content = ob_get_clean(); 
        
            // Gọi file main_layout.php với $main_content đã được định nghĩa
            include __DIR__ . '/../views/layouts/main_layout.php'; // Đảm bảo đường dẫn chính xác
        }
        
    }
    
?>