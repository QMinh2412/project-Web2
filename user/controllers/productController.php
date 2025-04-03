<?php
    require_once __DIR__ . '/../../common/models/Category.php';
    require_once __DIR__ . '/../../common/models/Product.php'; 
    require_once __DIR__ . '/../../common/models/Author.php'; 
    class productController {
        public function index() {
            // lấy thử loại sản phẩm từ database
            $categoryModel = new Category();
            $authorModel = new Author();
            $productModel = new Product();
            $categories = $categoryModel->getAllCategories();
            $authors = $authorModel->getAllAuthors();
            $products = $productModel->getAllProducts(1);
            $totalPage = $productModel->getPagination(2);
            ob_start();
            include __DIR__ . '/../views/product/product.php'; // Đảm bảo đường dẫn chính xác
            $main_content = ob_get_clean();

            include __DIR__ . '/../views/layouts/main_layout.php'; // Đảm bảo đường dẫn chính xác
        }
    }
?>