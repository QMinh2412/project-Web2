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
            $totalPage = $productModel->getPagination(1);
            ob_start();
            include __DIR__ . '/../views/product/product.php'; // Đảm bảo đường dẫn chính xác
            $main_content = ob_get_clean();

            include __DIR__ . '/../views/layouts/main_layout.php'; // Đảm bảo đường dẫn chính xác
        }

        public function pagingHandleAjax(){
            $current_page = $_GET['current_page'];
            $productModel = new Product();
            $products = $productModel->getAllProducts($current_page);
            $totalPage = $productModel->getPagination($current_page);
            echo json_encode([
                'products' => $products,
                'totalPage' => $totalPage['totalPages']
            ]);
        }

        public function showCategoryAjax(){
            $category_id = $_GET['category_id'];
            $current_page = $_GET['current_page'];
            $productModel = new Product();
            $products = $productModel->getProductByCategory($category_id, $current_page);
            $totalPage = $productModel->getPaginationByCategory($category_id, $current_page);
            echo json_encode([
            'products' => $products,
            'totalPage' => $totalPage['totalPages']
            ]);
        }

        public function showAuthorAjax(){
            $author_id = $_GET['author_id'];
            $current_page = $_GET['current_page'];
            $productModel = new Product();
            $products = $productModel->getProductByAuthor($author_id, $current_page);
            $totalPage = $productModel->getPaginationByAuthor($author_id, $current_page);
            echo json_encode([
            'products' => $products,
            'totalPage' => $totalPage['totalPages']
            ]);
        }

        public function filterPriceRangeAjax(){
            $priceRange = isset($_GET['price_range']) && $_GET['price_range'] !== "" ? explode(',', $_GET['price_range']) : [];
            $current_page = $_GET['current_page'];
            $productModel = new Product();
            $products = $productModel->filterPriceRange($priceRange, $current_page);
            $totalPage = $productModel->getPaginationByPriceRange($priceRange, $current_page);
            echo json_encode([
                'products' => $products,
                'totalPage' => $totalPage['totalPages']
            ]);
        }
    }
?>