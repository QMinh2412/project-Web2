<link rel="stylesheet" href="/project-Web2/user/assets/css/checkout.css">
<div class="container_checkout_box">
    <?php if (!empty($bookList)): ?>
        <?php print_r($userInfo); ?>
        <form action="/project-Web2/user/index.php?page=checkout&action=placeOrder" method="POST" id="formInfo">
            <div class="info_method">
                <div class="info">
                    <div class="title">Thông tin cá nhân</div>
                    <div class="pertional_info">
                        <div>
                            <label for="txtName">Họ tên: </label>
                            <input type="text" name="txtName" id="txtName" 
                                value="<?php if(isset($userInfo['TenND'])) echo $userInfo['TenND'];  ?>">
                        </div>
                        <div>
                            <label for="txtPhone">SĐT: </label>
                            <input type="text" name="txtPhone" id="txtPhone" 
                                value="<?php if(isset($userInfo['SDT'])) echo $userInfo['SDT'];  ?>">
                        </div>
                        <div>
                            <label for="txtAddress">Địa chỉ:</label>
                            <input type="text" name="txtAddress" id="txtAddress" 
                                value="<?php if( !empty($userInfo['DcND']) && $userInfo['DcND'] != 'undefined') echo $userInfo['DcND'];  ?>">
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
                            <div><input type="radio" name="shipping_method" id="regular" value="1" checked> <label for="regular">Giao hàng thông thường</label></div>
                            <div><input type="radio" name="shipping_method" id="express" value="2"> <label for="express">Giao hàng hỏa tốc</label></div>
                        </div>
                        <div class="payment_method">
                            <div>Phương thức thanh toán</div>
                            <div><input type="radio" name="payment_method" id="cod" value="1" checked> <label for="cod">Thanh toán khi nhận hàng</label></div>
                            <div><input type="radio" name="payment_method" id="qr" value="2"> <label for="qr">Thanh toán bằng mã QR</label></div>
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
                        <div class="book" data-id=<?php echo $book['MaSach']; ?> >
                            <span class="book_name"><?php echo htmlspecialchars($book['TenSach']); ?></span>
                            <span class="book_qty"><?php echo $book['SoLg']; ?></span>
                            <span class="book_price"><?php echo number_format($book['GiaBan'], 0, ',', '.'); ?> đ</span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="price_fee">
                    <div class="total_price_order">
                        <span>Tiền hàng:</span>
                        <span class="total_price"><?php echo number_format($totalPrice, 0, ',', ','); ?> đ</span>
                    </div>
                    <div class="fee_order">
                        <span>Phí vận chuyển:</span>
                        <span class="fee"><?php echo number_format($shippingFee, 0, ',', ','); ?> đ</span>
                    </div>
                </div>
                <div class="total_bill">
                    <span>Tiền hàng:</span>
                    <span><?php echo number_format($totalPrice + $shippingFee, 0, ',', '.'); ?> đ</span>
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
                        <div class="name_confirm">Tên: <i>Tên khách hàng</i></div>
                        <div class="phone_confirm">SĐT: <i>Tên khách hàng</i></div>
                        <div class="address_confirm">Địa chỉ: <i>Địa chỉ nhận hàng</i></div>
                    </div>
                    <div class="method_confirm">
                        <div class="shipping_method_confirm">PTVC: <i>phương thức vận chuyển</i></div>
                        <div class="payment_method_confirm">PTTT: <i>phương thức thanh toán</i></div>
                        <div class="note_confirm">Ghi chú: <i>nội dung</i></div>
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
                        <span id="total_price"><?php echo number_format($totalPrice, 0, ',', '.'); ?> đ</span>
                    </div>
                    <div class="fee_order">
                        <span>Phí vận chuyển:</span>
                        <span id="fee"><?php echo number_format($shippingFee, 0, ',', '.'); ?> đ</span>
                    </div>
                </div>
                <div class="total_bill">
                    <span>Tiền hàng:</span>
                    <span id="total_bill"><?php echo number_format($totalPrice, 0, ',', '.'); ?> đ</span>
                </div>
                <div class="btn_box">
                    <button id="close">Hủy</button>
                    <button type="submit">Xác nhận</button>
                </div>
            </form>
    </div>

    <div id="container_transfer_payment" style="display: none;">
        <div id="transfer_info_box">
            <h2>Xác nhận thanh toán</h2>
            <p>Cảm ơn bạn đã đặt hàng! Vui lòng thực hiện các bước chuyển khoản theo thông tin bên dưới</p>
            <div id="order_info">
                <h3>Thông tin đơn hàng</h3>
                <div id="order_id">Mã đơn hàng: <span>Mã đơn hàng</span></div>
                <div id="total_order">Tổng tiền: <span>Tổng tiền hóa đơn</span></div>
                <div id="name">Tên khách hàng: <span>Tên khách hàng</span></div>
                <div id="address">Địa chỉ: <span>Địa chỉ nhận hàng</span></div>
                <div id="phone">Số điện thoại: <span>số điện đoại</span></div>
            </div>
            <div id="transfer_info">
                <h3>Thông tin chuyển khoản</h3>
                <div id="bank">Ngân hàng: <span>Techcombank</span></div>
                <div id="account_number">Số tài khoản: <span>0123456789</span></div>
                <div id="account_holder">Chủ tài khoản: <span>BookstoreStudent</span></div>
                <div id="branch">Chi nhánh: <span>TP Hồ Chí Minh</span></div>
                <div id="content">Nội dung: <span>Mã đơn hàng - Tên khách hàng</span></div>
                <div id="attention">Lưu ý: <span>Vui lòng chuyển đúng số tiền và ghi chính xác nội dung chuyển khoản để chúng tôi xác nhận nhanh chóng.</span></div>
            </div>
            <div id="payment_confirm">
                <h3>Gửi xác nhận thanh toán</h3>
                <div id="up_proof_of_transfer">Tải mình chứng chuyển khoản: <input type="file" name="" id=""></div>
            </div>
            <div class="btn_box">
                <button id="back">Quay lại</button>
                <button id="btn_confirm_payment">Hoàn tất</button>
            </div>

        </div>
    </div>
</div>
<script src="/project-Web2/user/assets/js/checkout.js"></script>