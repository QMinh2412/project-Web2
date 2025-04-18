<?php
    require_once __DIR__ . '/../../common/config/init.php';
    require_once __DIR__ . '/../../common/models/CartDetail.php'; 
    require_once __DIR__ . '/../../common/models/Cart.php'; 
    require_once __DIR__ . '/../../common/models/Product.php'; 

    class CartController{
        public function index(){
            // lây dữ liệu
            $cartModel = new Cart();
            $cartDetailModel = new CartDetail();
            $productModel = new Product();
            $current_account = $_SESSION['account_id'];
            $myCart = $cartModel->getCartById($current_account);
            $myCartId = $myCart['MaGH'];
            $bookInMyCart = $cartDetailModel->getBookInCartByCartId($myCartId);

            ob_start();
            include __DIR__ . '/../../user/views/cart/cartDetail.php';
            $main_content = ob_get_clean();
            include __DIR__ . '/../../user/views/layouts/main_layout.php';
        }

        public function addToCart() {
            header('Content-Type: application/json; charset=utf-8');
            $current_account = isset($_SESSION['account_id']) ? $_SESSION['account_id'] : "";
    
            if (empty($current_account)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Đăng nhập để thêm vào giỏ hàng cá nhân'
                ]);
                exit;
            }
    
            $id_book = isset($_POST['id_book']) ? $_POST['id_book'] : "";
            $qty = isset($_POST['quantity']) ? $_POST['quantity'] : 1;
    
            $cartDetailModel = new CartDetail();
            $cartDetail = $cartDetailModel->addToCart($current_account, $id_book, $qty);
    
            if (!$cartDetail) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Sản phẩm đã tồn tại trong giỏ hàng, vui lòng kiểm tra giỏ hàng của ban.'
                ]);
            } else {
                echo json_encode([
                    'success' => true,
                    'message' => 'Thêm vào giỏ hàng thành công'
                ]);
            }
            exit;
        }


        public function updateStatus() {
            // header('Content-Type: application/json; charset=utf-8');
        
            $bookId = $_POST['bookId'] ?? null;
            $status = $_POST['status'] ?? null;
            $account_id = $_SESSION['account_id'];
        
            if (!$bookId || !isset($status)) {
                echo json_encode(['status' => false, 'message' => 'Dữ liệu không hợp lệ']);
                return;
            }
        
            $cartDetailModel = new CartDetail();
            $result = $cartDetailModel->updateCartStatus($bookId, $status, $account_id);
        
            echo json_encode([
                'status' => $result,
                'message' => $result ? 'Cập nhật thành công' : 'Không thể cập nhật trạng thái sản phẩm'
            ]);
        }

        public function remove() {
            $bookId = $_POST['bookId'] ?? null;
            $account_id = $_SESSION['account_id'];
    
            if (!$bookId) {
                echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
                return;
            }
    
            $cartDetailModel = new CartDetail();
            $result = $cartDetailModel->removeFromCart($bookId, $account_id);
    
            echo json_encode([
                'success' => $result,
                'message' => $result ? 'Xóa thành công' : 'Lỗi khi xóa sản phẩm'
            ]);
        }

        public function updateQuantity() {
            $bookId = $_POST['bookId'] ?? null;
            $quantity = $_POST['quantity'] ?? null;
            $account_id = $_SESSION['account_id'];
    
            if (!$bookId || !is_numeric($quantity) || $quantity < 1) {
                echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
                return;
            }
    
            $cartDetailModel = new CartDetail();
            $result = $cartDetailModel->updateCartQuantity($bookId, $quantity, $account_id);
    
            echo json_encode([
                'success' => $result,
                'message' => $result ? 'Cập nhật số lượng thành công' : 'Lỗi khi cập nhật số lượng'
            ]);
        }
    }
?>