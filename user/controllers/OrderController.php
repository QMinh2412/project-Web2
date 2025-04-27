<?php
    require_once __DIR__ . '/../../common/config/init.php';
    require_once __DIR__ . '/../../common/models/Cart.php';
    require_once __DIR__ . '/../../common/models/CartDetail.php';
    require_once __DIR__ . '/../../common/models/Order.php';
    require_once __DIR__ . '/../../common/models/OrderDetail.php';
    require_once __DIR__ . '/../../common/models/Product.php';


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

                $accountModel = new Account();
                $userModel = new User();
                $accountInfo = $accountModel->getById($current_account);
                $userInfo = $userModel->getById($accountInfo['MaND']);

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
                $userInfo = $_SESSION['user_info'] ?? [];
            }
            
            if (empty($bookList)) {
                header("Location: /project-Web2/user/index.php?page=home&error=no_items");
                exit;
            }
    
            // Tính tổng tiền
            $totalPrice = array_sum(array_map(fn($item) => $item['GiaBan'] * $item['SoLg'], $bookList));
            $shippingFee = $totalPrice * 0.05; // Mặc định phí vận chuyển
    
            ob_start();
            include __DIR__ . '/../views/checkout/checkout.php';
            $main_content = ob_get_clean();
            include __DIR__ . '/../views/layouts/main_layout.php';
        }

        public function placeOrder() {
            $account_id = $_SESSION['account_id'] ?? null;
            $name = $_POST['name'] ?? null;
            $phone = $_POST['phone'] ?? null;
            $address = $_POST['address'] ?? null;
            $note = $_POST['note'] ?? null;
            $shippingMethod = $_POST['shippingMethod'] ?? null;
            $paymentMethod = $_POST['paymentMethod'] ?? null;
            $total_bill = $_POST['total_bill'] ?? null;
            $source = $_POST['source'] ?? null;

            // Kiểm tra dữ liệu đầu vào
            if (!$account_id || !$name || !$phone || !$address || !$shippingMethod || !$paymentMethod || !$total_bill) {
                echo json_encode(['status' => 'error', 'message' => 'Thiếu thông tin bắt buộc']);
                exit;
            }

            $orderModel = new Order();
            $orderDetailModel = new OrderDetail();
            $createDate = date('Y-m-d H:i:s'); // Định dạng DATETIME

            if ($source == 'cart') {

                $cartModel = new Cart();
                $cartDetailModel = new CartDetail();
                $productModel = new Product();

                $myCart = $cartModel->getCartById($account_id);
                if (!$myCart) {
                    echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy giỏ hàng']);
                    exit;
                }

                $myCartId = $myCart['MaGH'];
                $booksInCart = $cartDetailModel->getSelectedBookInCart($myCartId);
                if (empty($booksInCart)) {
                    echo json_encode(['status' => 'error', 'message' => 'Giỏ hàng trống']);
                    exit;
                }

                // Create order
                $newOrderId = $orderModel->createOrder(2, $account_id, $createDate, 1, $note, $address, $phone, $paymentMethod, $shippingMethod, $total_bill);
                if (!$newOrderId) {
                    echo json_encode(['status' => 'error', 'message' => 'Không thể tạo hóa đơn trong giỏ hàng']);
                    exit;
                }

                // Create order details
                foreach ($booksInCart as $book) {
                    if (!$orderDetailModel->createOrderDetail($newOrderId, $book['MaSach'], $book['SoLg'])) {
                        echo json_encode(['status' => 'error', 'message' => 'Không thể tạo chi tiết hóa đơn trong giỏ hàng']);
                        exit;
                    }
                }

                // Xóa giỏ hàng sau khi đặt hàng thành công
                foreach ($booksInCart as $book) {
                    if(!$cartDetailModel->removeFromCart($book['MaSach'], $account_id)){
                        echo json_encode(['status' => 'error', 'message' => 'Không thể xóa sản phẩm khỏi giỏ hàng']);
                        exit;
                    }
                }

                // Cập nhật lại số lượng sách trong kho
                foreach ($booksInCart as $book) {
                    if(!$productModel->updateStock($book['MaSach'], $book['SoLg'])){
                        echo json_encode(['status' => 'error', 'message' => 'Không thể cập nhật số lượng sách trong kho']);
                        exit;
                    }
                }

                echo json_encode(['status' => 'success', 'order_id' => $newOrderId, 'message' => 'Đặt hàng thành công trong giỏ hàng']);                            

            } else {
                $cartModel = new Cart();
                $cartDetailModel = new CartDetail();
                $productModel = new Product();

                $booksInCart = $_SESSION['buy_now']['items'] ?? [];
                if (empty($booksInCart)) {
                    echo json_encode(['status' => 'error', 'message' => 'Không có sản phẩm để đặt hàng']);
                    exit;
                }

                // Create order
                $newOrderId = $orderModel->createOrder(2, $account_id, $createDate, 1, $note, $address, $phone, $paymentMethod, $shippingMethod, $total_bill);
                if (!$newOrderId) {
                    echo json_encode(['status' => 'error', 'message' => 'Không thể tạo hóa đơn']);
                    exit;
                }

                // Create order details
                foreach ($booksInCart as $book) {
                    if (!$orderDetailModel->createOrderDetail($newOrderId, $book['MaSach'], $book['SoLg'])) {
                        echo json_encode(['status' => 'error', 'message' => 'Không thể tạo chi tiết hóa đơn']);
                        exit;
                    }
                }

                // Cập nhật lại số lượng sách trong kho
                foreach ($booksInCart as $book) {
                    if(!$productModel->updateStock($book['MaSach'], $book['SoLg'])){
                        echo json_encode(['status' => 'error', 'message' => 'Không thể cập nhật số lượng sách trong kho']);
                        exit;
                    }
                }

                echo json_encode(['status' => 'success', 'order_id' => $newOrderId, 'message' => 'Đặt hàng thành công trong sản phẩm']);
            }
        }

        public function calculateFeeShip(){
            $totalPrice = isset($_GET['totalPrice']) ? $_GET['totalPrice'] : 0;
            $shipMethod = isset($_GET['shipMethod']) ? $_GET['shipMethod'] : 1;

            $totalPrice = floatval($totalPrice);

            if($shipMethod == 1){
                echo json_encode($totalPrice * 0.05);
            } else {
                echo json_encode($totalPrice * 0.1);
            }
        }
    }
?>