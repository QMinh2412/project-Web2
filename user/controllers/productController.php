<?php

use LDAP\Result;

    require_once __DIR__ . '/../../common/models/Category.php';
    require_once __DIR__ . '/../../common/models/Product.php'; 
    require_once __DIR__ . '/../../common/models/Author.php'; 
    require_once __DIR__ . '/../../common/models/Review.php'; 
    class productController {
        protected $bookperpage = 5;

        public function index() {
            $category_id = isset($_GET['category_id']) ? $_GET['category_id'] : "";
            $current_page = isset($_GET['current_page']) ? $_GET['current_page'] : 1;

            // lấy thử loại sản phẩm từ database
            $categoryModel = new Category();
            $authorModel = new Author();
            $productModel = new Product();
            $categories = $categoryModel->getAllCategories();
            $authors = $authorModel->getAllAuthors();
            
            if(empty($category_id)){
                $products = $productModel->getAllProducts(1);
                $totalPage = $productModel->getPagination(1);
            } else {
                $products = $productModel->getProductByCategory($category_id, $current_page, $this->bookperpage);
                $totalPage = $productModel->getPaginationByCategory($category_id, $current_page, $this->bookperpage);
            }

            ob_start();
            include __DIR__ . '/../views/product/product.php'; // Đảm bảo đường dẫn chính xác
            $main_content = ob_get_clean();

            include __DIR__ . '/../views/layouts/main_layout.php'; // Đảm bảo đường dẫn chính xác
        }

        public function pagingHandleAjax(){
            $current_page = $_GET['current_page'];
            $productModel = new Product();
            $products = $productModel->getAllProducts($current_page, $this->bookperpage);
            $totalPage = $productModel->getPagination($current_page, $this->bookperpage);
            echo json_encode([
                'products' => $products,
                'totalPage' => $totalPage['totalPages']
            ]);
        }

        public function showCategoryAjax(){
            $category_id = $_GET['category_id'];
            $current_page = $_GET['current_page'];
            $productModel = new Product();
            $products = $productModel->getProductByCategory($category_id, $current_page, $this->bookperpage);
            $totalPage = $productModel->getPaginationByCategory($category_id, $current_page, $this->bookperpage);
            echo json_encode([
            'products' => $products,
            'totalPage' => $totalPage['totalPages']
            ]);
        }

        public function showAuthorAjax(){
            $author_id = $_GET['author_id'];
            $current_page = $_GET['current_page'];
            $productModel = new Product();
            $products = $productModel->getProductByAuthor($author_id, $current_page, $this->bookperpage);
            $totalPage = $productModel->getPaginationByAuthor($author_id, $current_page, $this->bookperpage);
            echo json_encode([
            'products' => $products,
            'totalPage' => $totalPage['totalPages']
            ]);
        }

        public function filterPriceRangeAjax(){
            $priceRange = isset($_GET['price_range']) && $_GET['price_range'] !== "" ? explode(',', $_GET['price_range']) : [];
            $current_page = $_GET['current_page'];
            $productModel = new Product();
            $products = $productModel->filterPriceRange($priceRange, $current_page, $this->bookperpage);
            $totalPage = $productModel->getPaginationByPriceRange($priceRange, $current_page, $this->bookperpage);
            echo json_encode([
                'products' => $products,
                'totalPage' => $totalPage['totalPages']
            ]);
        }

        public function search(){
            $search = $_GET['search'];
            $productModel = new Product();
            $productsAfterSearch = $productModel->search($search);
            $totalPageAfterSearch = $productModel->getPaginationBySearch($search);
            ob_start();
            include __DIR__ . '/../views/product/product.php'; // Đảm bảo đường dẫn chính xác
            $main_content = ob_get_clean();

            include __DIR__ . '/../views/layouts/main_layout.php'; // Đảm bảo đường dẫn chính xác
        }

        public function showDetail(){
            $id_book = $_GET['id_book'];
            $productModel = new Product();
            $reviewModel = new Review();
            $book_data = $productModel->getProductById($id_book);
            $orther_books = $productModel->getBooksTypeSame($id_book);
            $book_reviews = $reviewModel->getAllReviewById($id_book);
            ob_start();
            include __DIR__ . '/../views/product/detail.php'; // Đảm bảo đường dẫn chính xác
            $main_content = ob_get_clean();

            include __DIR__ . '/../views/layouts/main_layout.php'; // Đảm bảo đường dẫn chính xác
        }

        public function writeComment(){
            session_start();
            $content_comment = isset($_POST['content']) ? $_POST['content'] : "";
            $id_book = $_POST['id_book'];
            $current_account = isset($_SESSION['account_id']) ? $_SESSION['account_id']: "";
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $current_time = date("Y/m/d H:i:s");

            if (empty($current_account)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Vui lòng đăng nhập trước khi viết đánh giá'
                ]);
                exit;
            }

            if (empty($content_comment)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Vui lòng viết đánh giá trước khi gửi'
                ]);
                exit;
            }

            $reviewModel = new Review();
            $result = $reviewModel->saveComment($content_comment, $id_book, $current_account, $current_time);

            if ($result === false) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Lưu bình luận thất bại'
                ]);
            } else {
                echo json_encode([
                    'success' => true,
                    'new_comment' => $result // Trả về bản ghi vừa lưu
                ]);
            }
            exit;
        }

        public function replyComment(){
            $content = isset($_POST['content']) ? $_POST['content'] : "";
            $comment_id = isset($_POST['comment_id']) ? $_POST['comment_id'] : "";
            session_start();
            $current_account = isset($_SESSION['account_id']) ? $_SESSION['account_id'] : "";

            if (empty($content)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Vui lòng viết phản hồi trước khi gửi'
                ]);
                exit;
            }

            $reviewModel = new Review();
            $result = $reviewModel->saveReply($content, $comment_id, $current_account);

            if ($result === false) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Lưu phản hồi thất bại'
                ]);
            } else {
                echo json_encode([
                    'success' => true,
                    'new_reply' => $result
                ]);
            }
            exit;
        }

    }
?>