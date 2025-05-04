<?php
    require_once __DIR__ . '/../../common/config/init.php';
    require_once __DIR__ . '/../../common/models/Account.php';
    require_once __DIR__ . '/../../common/models/Category.php';
    require_once __DIR__ . '/../../common/models/Product.php';
    require_once __DIR__ . '/../../common/models/OrderDetail.php';
    require_once __DIR__ . '/../../common/models/ImportDetail.php';

    class HomeController {
        public function getAccountData() {
            // session_start();
            if (isset($_SESSION['user_id'])) {
                $accountModel = new Account();
                $name  = $accountModel->getNameById($_SESSION['user_id']);
                $image = $accountModel->getImage($_SESSION['user_id']);
                return [$name, $image];
            }
            return null;
        }

        public function index() {
            // Định nghĩa biến $content
            $content = 'hello world'; 

            $productModel = new Product();
            $orderDetailModel = new OrderDetail();
            $importDetailModel = new ImportDetail();

            $bestSellingBookIds = $orderDetailModel->getBestSellingBooks();
            $bestSellingBooks = [];
            foreach($bestSellingBookIds as $book){
                $bestSellingBooks[] = $productModel->getProductById($book['MaSach']);
            }

            $newImportedBookIds = $importDetailModel->getNewImportBook();
            $newImportedBooks = [];
            foreach($newImportedBookIds as $book){
                $newImportedBooks[] = $productModel->getProductById($book['MaSach']);
            }


            $categoryModel = new Category();
            $categories = $categoryModel->getCategoryLimit(); // Lấy tất cả thể loại
        
            // Bắt đầu buffering để lấy nội dung từ index.php
            ob_start();
            include __DIR__ . '/../views/home/index.php'; // Đảm bảo đường dẫn chính xác
            $main_content = ob_get_clean(); 
        
            // Gọi file main_layout.php với $main_content đã được định nghĩa
            include __DIR__ . '/../views/layouts/main_layout.php'; // Đảm bảo đường dẫn chính xác
        }
        
    }
    
?>