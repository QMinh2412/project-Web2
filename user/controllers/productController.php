<?php
    require_once __DIR__ . '/../../common/config/init.php';
    require_once __DIR__ . '/../../common/models/Category.php';
    require_once __DIR__ . '/../../common/models/Product.php'; 
    require_once __DIR__ . '/../../common/models/Author.php'; 
    require_once __DIR__ . '/../../common/models/Review.php'; 
    class productController {
        protected $bookperpage = 4;

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
                $products = $productModel->getAllProductsWithStatus(1);
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
            $products = $productModel->getAllProductsWithStatus($current_page, $this->bookperpage);
            $totalPage = $productModel->getPaginationWithStatus($current_page, $this->bookperpage);
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

        public function search() {
            $search = isset($_GET['search']) ? trim($_GET['search']) : '';
            $bookName = isset($_GET['book_name']) ? trim($_GET['book_name']) : '';
            $authorName = isset($_GET['author_name']) ? trim($_GET['author_name']) : '';
            $categoryName = isset($_GET['category_name']) ? trim($_GET['category_name']) : '';
            $priceRange = isset($_GET['price_range']) ? (int)$_GET['price_range'] : 0;
            $current_page = isset($_GET['current_page']) ? (int)$_GET['current_page'] : 1;
        
            // Ưu tiên $search, nếu không có thì dùng $bookName
            $searchTerm = $search ?: $bookName;
        
            $productModel = new Product();
            $productsAfterSearch = $productModel->search(
                $searchTerm,
                $current_page,
                $this->bookperpage,
                $authorName,
                $categoryName,
                $priceRange
            );
            $totalPageAfterSearch = $productModel->getPaginationBySearch(
                $searchTerm,
                $current_page,
                $this->bookperpage,
                $authorName,
                $categoryName,
                $priceRange
            );
        
            header('Content-Type: application/json');
            echo json_encode([
                'products' => $productsAfterSearch,
                'totalPage' => $totalPageAfterSearch['totalPages'],
                'currentPage' => $totalPageAfterSearch['currentPage'],
                'searchTerm' => $searchTerm,
                'bookName' => $bookName,
                'authorName' => $authorName,
                'categoryName' => $categoryName,
                'priceRange' => $priceRange
            ]);
            exit;
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
            // session_start();
            $content_comment = isset($_POST['content']) ? $_POST['content'] : "";
            $id_book = $_POST['id_book'];
            $current_account = isset($_SESSION['user_id']) ? $_SESSION['user_id']: "";
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
            // session_start();
            $current_account = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "";

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

        public function buyNow(){
            $current_account = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

            if(!$current_account){
                echo json_encode([
                    'status' => false,
                    'message' => 'Vui lòng đăng nhập để mua hàng'
                ]);
                exit;
            }

            $accountModel = new Account();
            $userModel = new User();
            $accountInfo = $accountModel->getById($current_account);
            $userInfo = $userModel->getById($accountInfo['MaND']);

            $role = $accountModel->getById($current_account)['LoaiTK'];
            if($role !== 0){
                echo json_encode(['status' => false, 'message' => 'Tài khoản của bạn không có quyền mua sản phẩm']);
                exit;
            }

            $bookId = isset($_POST['id_book']) ? $_POST['id_book'] : '';
            $qty = isset($_POST['quantity']) ? $_POST['quantity'] : '';

            if($current_account){
                $productModel = new Product();
                $book = $productModel->getProductById($bookId);
                $bookQty = $book['SoLgTon'];

                if($qty > $bookQty){
                    echo json_encode([
                        'status' => false,
                        'message' => 'Số lượng trong kho không đủ'
                    ]);
                } else {
                    // Lưu thông tin sản phẩm vào session
                    $_SESSION['buy_now'] = [
                        'items' => [[
                            'MaSach' => $book['MaSach'],
                            'TenSach' => $book['TenSach'],
                            'SoLg' => (int)$qty,
                            'GiaBan' => $book['GiaBan'],
                            'DgDanAnh' => $book['DgDanAnh'][0] ?? ''
                        ]]
                    ];
                    $_SESSION['user_info'] = $userInfo;
                    echo json_encode([
                        'status' => true,
                        'message' => 'dang chuyen qua trang thanh toan'
                    ]);
                }
                
                exit();
            }
        }

        public function checkout(){
            $current_account = $_SESSION['user_id'];
            $cartModel = new Cart();
            $my_cart = $cartModel->getCartById($current_account);
            $cart_id = $my_cart['MaGH'];
            $cartDetailModel = new CartDetail();
            $selected_books = $cartDetailModel->getSelectedBookInCart($cart_id);

            if($selected_books){
                echo json_encode([
                    'status' => true,
                    'message' => 'đang chuyển sang thanh toán'
                ]);
            } else {
                echo json_encode([
                    'status' => false,
                    'message' => 'vui long chon san pham truoc khi thanh toan'
                ]);
            }
            exit();
        }

    }
?>