<?php
    require_once __DIR__ . '/../../common/config/init.php';
    require_once __DIR__ . '/../../common/models/Cart.php';
    require_once __DIR__ . '/../../common/models/CartDetail.php';

    class OrderController{
        public function index(){

            ob_start();
            include __DIR__ . '/../views/checkout/checkout.php';
            $main_content = ob_get_clean();
            include __DIR__ . '/../views/layouts/main_layout.php';
        }

        public function showCheckout() {
            // không cần do đã kiểm tra chỗ nút mua ngay và nút thêm vào giỏ hàng
            // $account_id = $_SESSION['account_id'] ?? null;
            // if (!$account_id) {
            //     header("Location: /project-Web2/user/index.php?page=login");
            //     exit;
            // }
    
            // Lấy danh sách sản phẩm từ session
            $source = $_GET['source'];
            $bookList = [];

            if($source == 'cart'){
                $current_account = $_SESSION['account_id'];

                $cartModel = new Cart();
                $cartDetailModel = new CartDetail();
                $productModel = new Product();

                $myCart = $cartModel->getCartById($current_account);
                $myCartId = $myCart['MaGH'];
                $booksInCart = $cartDetailModel->getSelectedBookInCart($myCartId);

                foreach($booksInCart as $book){
                    $bookInfo = $productModel->getProductById($book['MaSach']);
                    $bookList[] = [
                        'MaSach' => $bookInfo['MaSach'],
                        'SoLg' => $book['SoLg'],
                        'TenSach' => $bookInfo['TenSach'],
                        'GiaBan' => $bookInfo['GiaBan']
                    ];
                }
            } else {
                $bookList = $_SESSION['buy_now']['items'] ?? [];
            }
            
            if (empty($bookList)) {
                header("Location: /project-Web2/user/index.php?page=home&error=no_items");
                exit;
            }
    
            // Tính tổng tiền
            $totalPrice = array_sum(array_map(fn($item) => $item['GiaBan'] * $item['SoLg'], $bookList));
            $shippingFee = 5000; // Mặc định phí vận chuyển
    
            ob_start();
            include __DIR__ . '/../views/checkout/checkout.php';
            $main_content = ob_get_clean();
            include __DIR__ . '/../views/layouts/main_layout.php';
        }

        public function placeOrder() {
            $account_id = $_SESSION['account_id'] ?? null;
            if (!$account_id) {
                header("Location: /project-Web2/user/index.php?page=login");
                exit;
            }
    
            $personalInfo = [
                'fullname' => $_POST['txtName'] ?? '',
                'phone' => $_POST['txtPhone'] ?? '',
                'address' => $_POST['txtAddress'] ?? '',
                'note' => $_POST['txtNote'] ?? ''
            ];
            $shipping_method = $_POST['shipping_method'] ?? 1;
            $payment_method = $_POST['payment_method'] ?? 1;

            $source = $_POST['source'];
    
            $bookList = [];

            if($source == 'cart'){
                $current_account = $_SESSION['account_id'];

                $cartModel = new Cart();
                $cartDetailModel = new CartDetail();
                $productModel = new Product();

                $myCart = $cartModel->getCartById($current_account);
                $myCartId = $myCart['MaGH'];
                $booksInCart = $cartDetailModel->getSelectedBookInCart($myCartId);

                foreach($booksInCart as $book){
                    $bookInfo = $productModel->getProductById($book['MaSach']);
                    $bookList[] = [
                        'MaSach' => $bookInfo['MaSach'],
                        'SoLg' => $book['SoLg'],
                        'TenSach' => $bookInfo['TenSach'],
                        'GiaBan' => $bookInfo['GiaBan']
                    ];
                }
            } else {
                $bookList = $_SESSION['buy_now']['items'] ?? [];
            }

            if (empty($items)) {
                header("Location: /project-Web2/user/index.php?page=checkout&error=no_items");
                exit;
            }
    
            // Kiểm tra tồn kho
            $productModel = new Product();
            foreach ($bookList as $item) {
                $book = $productModel->getProductById($item['MaSach']);
                if ($book['SoLgTon'] < $item['SoLg']) {
                    header("Location: /project-Web2/user/index.php?page=checkout&error=stock_insufficient");
                    exit;
                }
            }
    
            // Lưu đơn hàng
            $orderModel = new Order();
            $order_id = $orderModel->createOrder($account_id, $items, $personalInfo, $shipping_method, $payment_method);
            if ($order_id) {
                // Xóa session sau khi đặt hàng
                unset($_SESSION['buy_now']);
                header("Location: /project-Web2/user/index.php?page=orderConfirmation&order_id=$order_id");
                exit;
            } else {
                header("Location: /project-Web2/user/index.php?page=checkout&error=order_failed");
                exit;
            }
        }
    }
?>