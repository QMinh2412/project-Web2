<link rel="stylesheet" href="/project-Web2/user/assets/css/checkout.css">
<?php
session_start();
require_once __DIR__ . '/../../../common/models/Product.php';
require_once __DIR__ . '/../../../common/models/User.php';

// Lấy id_book từ URL
$id_book = isset($_GET['id_book']) ? (int)$_GET['id_book'] : 0;

// Lấy số lượng từ URL (nếu có), mặc định là 1 nếu không có
$quantity = isset($_GET['quantity']) ? (int)$_GET['quantity'] : 1;

// Lấy thông tin sản phẩm
$productModel = new Product();
$product = $productModel->getProductById($id_book);

// Kiểm tra nếu không tìm thấy sản phẩm
if (!$product) {
    echo "Không tìm thấy sản phẩm.";
    echo '<br><a href="/project-Web2/user/index.php">Quay lại trang chủ</a>';
    exit();
}

// Lấy thông tin người dùng nếu đã đăng nhập
$user = null;
if (isset($_SESSION['account_id'])) {
    $userModel = new User();
    $user = $userModel->getById($_SESSION['account_id']);
}
?>


<body>
    <h2>Thanh toán</h2>
    <form id="checkout-form" method="POST" action="/project-Web2/user/index.php?page=checkout&action=placeOrder">
        <!-- Phần nhập thông tin người mua -->
        <div id="info-section">
            <label for="fullname">Họ tên *</label>
            <input type="text" id="fullname" name="fullname" value="<?php echo isset($user) ? htmlspecialchars($user['TenND'] ?? '') : ''; ?>" required>

            <label for="phone">Số điện thoại *</label>
            <input type="text" id="phone" name="phone" value="<?php echo isset($user) ? htmlspecialchars($user['SDT'] ?? '') : ''; ?>" required>

            <label for="address">Địa chỉ *</label>
            <input type="text" id="address" name="address" value="<?php echo isset($user) ? htmlspecialchars($user['DcND'] ?? '') : ''; ?>" required>

            <label for="note">Ghi chú (nếu có)</label>
            <textarea id="note" name="note"></textarea>
        </div>

        <!-- Phần thanh toán -->
        <div id="payment-section">
            <h3>Phương thức thanh toán</h3>
            <div class="radio-group">
                <input type="radio" id="cod" name="payment_method" value="COD" checked>
                <label for="cod">COD</label>
            </div>
            <div class="radio-group">
                <input type="radio" id="qr" name="payment_method" value="QR">
                <label for="qr">Thanh toán qua mã QR</label>
            </div>

            <h3>Phương thức vận chuyển</h3>
            <div class="radio-group">
                <input type="radio" id="normal" name="shipping_method" value="Normal" checked>
                <label for="normal">Giao hàng thông thường</label>
            </div>
            <div class="radio-group">
                <input type="radio" id="express" name="shipping_method" value="Express">
                <label for="express">Giao hàng hỏa tốc</label>
            </div>

            <h3>Đơn hàng</h3>
            <table>
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá sản phẩm</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo htmlspecialchars($product['TenSach'] ?? ''); ?></td>
                        <td><?php echo $quantity; ?></td>
                        <td><?php echo number_format($product['GiaBan'] ?? 0, 0, ',', '.') . ' đ'; ?></td>
                    </tr>
                </tbody>
            </table>

            <div class="total">
                <?php
                $subtotal = $product['GiaBan'] * $quantity;
                $shipping_fee = 0;
                ?>
                Tiền hàng: <?php echo number_format($subtotal, 0, ',', '.') . ' đ'; ?><br>
                Phí vận chuyển: <span id="shipping-fee">0 đ</span><br>
                Tổng: <span id="total"><?php echo number_format($subtotal, 0, ',', '.') . ' đ'; ?></span>
            </div>

            <!-- Hidden inputs để gửi dữ liệu -->
            <input type="hidden" name="id_book" value="<?php echo $id_book; ?>">
            <input type="hidden" name="quantity" value="<?php echo $quantity; ?>">
            <input type="hidden" name="shipping_fee" id="shipping-fee-hidden" value="0">
            <input type="hidden" name="total" id="total-hidden" value="<?php echo $subtotal; ?>">
        </div>

        <button type="submit">Đặt hàng</button>
    </form>

    <script>
        const subtotal = <?php echo $subtotal; ?>;
        const normalShippingRate = 0.05; // 5%
        const expressShippingRate = 0.10; // 10%

        function updateShippingFee() {
            const shippingMethod = document.querySelector('input[name="shipping_method"]:checked').value;
            let shippingFee = 0;
            if (shippingMethod === 'Normal') {
                shippingFee = subtotal * normalShippingRate;
            } else if (shippingMethod === 'Express') {
                shippingFee = subtotal * expressShippingRate;
            }

            const total = subtotal + shippingFee;

            document.getElementById('shipping-fee').textContent = new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(shippingFee);
            document.getElementById('total').textContent = new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(total);
            document.getElementById('shipping-fee-hidden').value = shippingFee;
            document.getElementById('total-hidden').value = total;
        }

        // Gắn sự kiện cho các radio button
        document.querySelectorAll('input[name="shipping_method"]').forEach(radio => {
            radio.addEventListener('change', updateShippingFee);
        });

        // Cập nhật phí vận chuyển ngay khi tải trang
        updateShippingFee();

        // Xử lý sự kiện submit form
        document.getElementById('checkout-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Ngăn form submit mặc định

            // Gửi form bằng fetch
            fetch(this.action, {
                method: 'POST',
                body: new FormData(this)
            })
            .then(response => response.text())
            .then(data => {
                // Hiển thị thông báo thành công
                alert('Đặt hàng thành công');
                // Chuyển hướng về trang index
                window.location.href = '/project-Web2/user/index.php';
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Đặt hàng thất bại, vui lòng thử lại');
            });
        });
    </script>
</body>
</html>