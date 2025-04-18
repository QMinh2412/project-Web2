<link rel="stylesheet" href="/project-Web2/user/assets/css/checkout.css">
<div class="container_checkout_box">
    <form>
        <div class="info_method">
            <div class="info">
                <div class="title">Thông tin cá nhân</div>
                <div class="pertional_info">
                    <div>
                        <label for="txtName">Họ tên: </label>
                        <input type="text" name="txtName" id="txtName">
                    </div>
                    <div>
                        <label for="txtPhone">SĐT: </label>
                        <input type="text" name="txtPhone" id="txtPhone">
                    </div>
                    <div>
                        <label for="txtAddress">Địa chỉ:</label>
                        <input type="text" name="txtAddress" id="txtAddress">
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
                        <div><input type="radio" name="shipping_method" id="regular" checked> <label for="regular">Giao hàng thông thường</label></div>
                        <div><input type="radio" name="shipping_method" id="express"> <label for="express">Giao hàng hỏa tốc</label></div>
                    </div>
                    <div class="payment_method">
                        <div>Phương thức vận chuyển</div>
                        <div><input type="radio" name="payment_method" id="cod" checked> <label for="cod">Thanh toán khi nhận hàng</label></div>
                        <div><input type="radio" name="payment_method" id="qr"> <label for="qr">Thanh toán bằng mã qr</label></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="order">
            <div class="book_list_header">
                <span class="book_name">Tên Sách</span>
                <span class="book_qty">số lượng</span>
                <span class="book_price">giá bán</span>
            </div>
            <div class="book_list">
                <div class="book">
                    <span class="book_name">Tên Sách</span>
                    <span class="book_qty">1</span>
                    <span class="book_price">100000 đ</span>
                </div>
                <div class="book">
                    <span class="book_name">Tên Sách</span>
                    <span class="book_qty">1</span>
                    <span class="book_price">100000 đ</span>
                </div>
                <div class="book">
                    <span class="book_name">Tên Sách</span>
                    <span class="book_qty">1</span>
                    <span class="book_price">100000 đ</span>
                </div>
            </div>
            <div class="price_fee">
                <div class="total_price_order">
                    <span>Tiền hàng:</span>
                    <span class="total_price">100000 đ</span>
                </div>
                <div class="fee_order">
                    <span>Phí vận chuyển:</span>
                    <span>5000 đ</span>
                </div>
            </div>
            <div class="total_bill">
                <span>Tổng:</span>
                <span>200000 đ</span>
            </div>
        </div>
        <div class="btn_box">
            <button type="submit">Đặt hàng</button>
        </div>
    </form>
</div>