<link rel="stylesheet" href="/project-Web2/user/assets/css/checkout.css">
<div class="container_checkout_box">
    <?php if (!empty($bookList)): ?>
        <form action="/project-Web2/user/index.php?page=checkout&action=placeOrder" method="POST">
            <div class="info_method">
                <div class="info">
                    <div class="title">Thông tin cá nhân</div>
                    <div class="pertional_info">
                        <div>
                            <label for="txtName">Họ tên: </label>
                            <input type="text" name="txtName" id="txtName" required>
                        </div>
                        <div>
                            <label for="txtPhone">SĐT: </label>
                            <input type="text" name="txtPhone" id="txtPhone" required>
                        </div>
                        <div>
                            <label for="txtAddress">Địa chỉ:</label>
                            <input type="text" name="txtAddress" id="txtAddress" required>
                        </div>
                        <div>
                            <label for="txtNote">Ghi chú:</label>
                            <textarea name="txtNote" id="txtNote" rows="3" columns="20"></textarea>
                        </div>
                    </div>
                </div>
                <div class="method">
                    <div class="title">Phương thức</div>
                    <div class="method_box">
                        <div class="shipping_method">
                            <div>Phương thức vận chuyển</div>
                            <div><input type="radio" name="shipping_method" id="regular" value=1 checked> <label for="regular">Giao hàng thông thường</label></div>
                            <div><input type="radio" name="shipping_method" id="express" value=2> <label for="express">Giao hàng hỏa tốc</label></div>
                        </div>
                        <div class="payment_method">
                            <div>Phương thức thanh toán</div>
                            <div><input type="radio" name="payment_method" id="cod" value=1 checked> <label for="cod">Thanh toán khi nhận hàng</label></div>
                            <div><input type="radio" name="payment_method" id="qr" value=2> <label for="qr">Thanh toán bằng mã QR</label></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="order">
                <div class="book_list_header">
                    <span class="book_name">Tên Sách</span>
                    <span class="book_qty">Số lượng</span>
                    <span class="book_price">Giá bán</span>
                </div>
                <div class="book_list">
                    <?php foreach ($bookList as $book): ?>
                        <div class="book">
                            <span class="book_name"><?php echo htmlspecialchars($book['TenSach']); ?></span>
                            <span class="book_qty"><?php echo $book['SoLg']; ?></span>
                            <span class="book_price"><?php echo number_format($book['GiaBan'], 0, ',', '.'); ?> đ</span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- <div class="price_fee">
                    <div class="total_price_order">
                        <span>Tiền hàng:</span>
                        <span class="total_price"><?php echo number_format($totalPrice, 0, ',', '.'); ?> đ</span>
                    </div>
                    <div class="fee_order">
                        <span>Phí vận chuyển:</span>
                        <span><?php echo number_format($shippingFee, 0, ',', '.'); ?> đ</span>
                    </div>
                </div> -->
                <div class="total_bill">
                    <span>Tiền hàng:</span>
                    <span><?php echo number_format($totalPrice, 0, ',', '.'); ?> đ</span>
                </div>
            </div>
            <div class="btn_box">
                <button type="submit" id="btn_submit">Đặt hàng</button>
            </div>
        </form>
    <?php else: ?>
        <div style="color: red; font-size: 24px; font-weight: bold; padding: 20px;">Không có sản phẩm nào được chọn</div>
    <?php endif; ?>

    <div id="container_confirm" style="display: none;">
        <form id="confirmInfo">
                <h2>Xác nhận thông tin</h2>
                <div class="info_method_confirm">
                    <div class="pertional_info_confirm">
                        <div class="name_confirm">Tên: tên khách hàng</div>
                        <div class="phone_confirm">SĐT: 0123456789</div>
                        <div class="address_confirm">Địa chỉ: địa chỉ nhận hàng</div>
                    </div>
                    <div class="method_confirm">
                        <div class="shipping_method_confirm">Phương thức vận chuyển: phương thức vận chuyển</div>
                        <div class="payment_method_confirm">Phương thức thanh toán: phương thức thanh toán</div>
                        <div class="note_confirm">Ghi chú: nội dung</div>
                    </div>
                </div>
                <div class="book_list_header_confirm">
                    <span class="book_name_header_confirm">Tên sách</span>
                    <span class="book_quantity_header_confirm">Số lượng</span>
                    <span class="book_price_header_confirm">Giá</span>
                </div>
                <div class="book_list_confirm">
                    <?php foreach ($bookList as $book): ?>
                        <div class="book">
                            <span class="book_name"><?php echo htmlspecialchars($book['TenSach']); ?></span>
                            <span class="book_qty"><?php echo $book['SoLg']; ?></span>
                            <span class="book_price"><?php echo number_format($book['GiaBan'], 0, ',', '.'); ?> đ</span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="price_fee">
                    <div class="total_price_order">
                        <span>Tiền hàng:</span>
                        <span class="total_price"><?php echo number_format($totalPrice, 0, ',', '.'); ?> đ</span>
                    </div>
                    <div class="fee_order">
                        <span>Phí vận chuyển:</span>
                        <span><?php echo number_format($shippingFee, 0, ',', '.'); ?> đ</span>
                    </div>
                </div>
                <div class="total_bill">
                    <span>Tiền hàng:</span>
                    <span><?php echo number_format($totalPrice, 0, ',', '.'); ?> đ</span>
                </div>
                <div class="btn_box">
                    <button id="close">Hủy</button>
                    <button type="submit">Đặt hàng</button>
                </div>
            </form>
    </div>
</div>
<script src="/project-Web2/user/assets/js/checkout.js"></script>