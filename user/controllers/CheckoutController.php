<?php
require_once __DIR__ . '/../../common/models/Product.php';
require_once __DIR__ . '/../../common/models/Order.php';

class CheckoutController {
    private $productModel;
    private $orderModel;

    public function __construct() {
        $this->productModel = new Product();
        $this->orderModel = new Order();
    }

    public function showCheckout() {
        if (!isset($_GET['id_book'])) {
            header('Location: /project-Web2/user/index.php');
            exit();
        }
        include __DIR__ . '/../views/layouts/checkout.php';
    }

    public function placeOrder() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /project-Web2/user/index.php');
            exit();
        }

        if (!isset($_SESSION['account_id'])) {
            header('Location: /project-Web2/user/index.php?page=account&action=login');
            exit();
        }

        $account_id = $_SESSION['account_id'];
        $id_book = isset($_POST['id_book']) ? (int)$_POST['id_book'] : 0;
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
        $fullname = $_POST['fullname'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $address = $_POST['address'] ?? '';
        $note = $_POST['note'] ?? '';
        $payment_method = $_POST['payment_method'] ?? 'COD';
        $shipping_method = $_POST['shipping_method'] ?? 'Normal';

        // Lấy thông tin sản phẩm
        $product = $this->productModel->getProductById($id_book);
        if (!$product) {
            echo "Không tìm thấy sản phẩm.";
            echo '<br><a href="/project-Web2/user/index.php">Quay lại trang chủ</a>';
            exit();
        }

        // Tính tổng tiền
        $total = $product['GiaBan'] * $quantity;

        // Lưu đơn hàng vào cơ sở dữ liệu
        $order_id = $this->orderModel->createOrder($account_id, $id_book, $quantity, $total, $fullname, $phone, $address, $note, $payment_method, $shipping_method);

        if ($order_id) {
            // Chuyển hướng đến trang xác nhận đơn hàng
            header('Location: /project-Web2/user/index.php?page=checkout&action=orderSuccess&order_id=' . $order_id);
        } else {
            echo "Đặt hàng thất bại. Vui lòng thử lại.";
            echo '<br><a href="/project-Web2/user/index.php">Quay lại trang chủ</a>';
        }
    }

    public function orderSuccess() {
        $order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;
        $order = $this->orderModel->getById($order_id);

        if (!$order || $order['MaND'] != $_SESSION['account_id']) {
            echo "Không tìm thấy đơn hàng.";
            echo '<br><a href="/project-Web2/user/index.php">Quay lại trang chủ</a>';
            exit();
        }

        echo "<h2>Đặt hàng thành công</h2>";
        echo "<p>Mã đơn hàng: " . htmlspecialchars($order_id) . "</p>";
        echo "<p>Tổng tiền: " . number_format($order['TongTien'], 0, ',', '.') . " đ</p>";
        echo '<a href="/project-Web2/user/index.php">Quay lại trang chủ</a>';
    }
}
?>