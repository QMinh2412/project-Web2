<?php
    require_once __DIR__ . '/../../common/config/init.php';
    require_once __DIR__ . '/../../common/models/CartDetail.php'; 
    class CartController{
        public function addToCart() {
            // session_start();
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
    }
?>