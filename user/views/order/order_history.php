<link rel="stylesheet" href="/project-Web2/user/assets/css/order_histoty.css">
<body>
    <div id="container_order_history">
        <div class="menu_links">
            <div><a href="/project-Web2/user/index.php?page=account&action=updateAccount">Cập nhật tài khoản</a></div>
            <div><a href="/project-Web2/user/index.php?page=account&action=changePassword">Thay đổi mật khẩu</a></div>
            <div class="active"><a href="/project-Web2/user/index.php?page=order&action=showOrderHistory&current_page=1">Lịch sử đơn hàng</a></div>
        </div>
        <div class="order_history_box" >
            <h2>Lịch sử đơn hàng</h2>
            <div class="order_filter">
                <form>
                    <div id="order_id_box">
                        <label for="order_id">Mã đơn hàng:</label> <br>
                        <input type="text" id="order_id" name="order_id">
                    </div>
                    <div id="status_order_box">
                        <label for="status_order">Trạng thái:</label> <br>
                        <select id="status_order" name="status_order">
                            <option value="">Tất cả</option>
                            <option value="1">Chờ xác nhận</option>
                            <option value="2">Đang giao hàng</option>
                            <option value="3">Đã giao hàng</option>
                            <option value="0">Đã hủy</option>
                        </select>
                    </div>
                    <div id="order_date_begin_box">
                        <label for="order_date_begin">Từ ngày:</label> <br>
                        <input type="date" id="order_date_begin" name="order_date_begin">
                    </div>
                    <div id="order_date_end_box">
                        <label for="order_date_end">Đến:</label> <br>
                        <input type="date" id="order_date_end" name="order_date_end">
                    </div>
                    <div id="box_btn_order_filter"><button id="btn_order_filter">Tìm kiếm</button></div>
                </form>
            </div>
            <div class="order_history">
                <div id="order_history_header">
                    <span>Mã hóa đơn</span>
                    <span>Tổng tiền</span>
                    <span>Thanh toán</span>
                    <span>Vận chuyển</span>
                    <span>Tình trạng</span>
                    <span>&nbsp;</span>
                </div>
                <div id="order_history_body">
                    <?php if (!empty($result)): ?>
                        <?php foreach ($result['orders'] as $order): ?>
                            <div class="item" data-id="<?php echo htmlspecialchars($order['MaHD']); ?>">
                                <span><?php echo htmlspecialchars($order['MaHD']); ?></span>
                                <span><?php echo number_format(htmlspecialchars($order['TongTien']), 0, '.', '.'); ?> đ</span>
                                <span><?php echo (htmlspecialchars($order['PhThucTT']) == 1 ? 'COD' : 'Chuyển khoản'); ?></span>
                                <span><?php echo (htmlspecialchars($order['PhThucVC']) == 1 ? 'Thông thường' : 'Hỏa tốc'); ?></span>
                                <span>
                                    <?php echo (htmlspecialchars($order['TrangThaiDH']) == 1 ? 'Chờ duyệt' : (htmlspecialchars($order['TrangThaiDH']) == 2 ? 'Đang giao' : (htmlspecialchars($order['TrangThaiDH']) == 3 ? 'Đã giao' : 'Đã hủy'))); ?>
                                </span>
                                <span class="btn_show_detail_order">
                                    <button class="showOrderDetail">Xem</button>
                                    <?php if($order['TrangThaiDH'] == 1): ?>
                                        <button class="delOrder">Hủy</button>
                                    <?php endif; ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div style="color: red; font-size: 24px; margin-left: 10px; margin-top:20px">Không có đơn hàng nào</div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="pagination_box">
                <?php if (!empty($result) && $result['totalPages'] > 1): ?>
                    <!-- Nút lùi về trang trước -->
                    <?php if ($result['currentPage'] != 1): ?>
                        <span class="page prev">&laquo;</span>
                    <?php endif; ?>
                    
                    <!-- Các trang -->
                    <?php for ($i = 1; $i <= $result['totalPages']; $i++): ?>
                        <span class="page <?php echo ($i == $result['currentPage']) ? 'active' : ''; ?>">
                            <?php echo $i; ?>
                        </span>
                    <?php endfor; ?>

                    <!-- Nút tiến tới trang sau -->
                    <?php if ($result['currentPage'] != $result['totalPages']): ?>
                        <span class="page next">&raquo;</span>
                    <?php endif; ?>
                <?php endif ?>
            </div>
        </div>
        <div class="order_detail_box" style="display:none;">
            <h2><span>Chi tiết hóa đơn</span><span id="close_order_detail">x</span></h2>
            <div id="order_detail_form">
                <div class="row">
                    <div class="col">
                        <label for="order_detail_id">Mã hóa đơn</label> <br>
                        <input type="text" id="order_detail_id" name="order_detail_id" readonly>
                    </div>
                    <div class="col">
                        <label for="order_detail_user_name">Tên khách hàng</label> <br>
                        <input type="text" id="order_detail_user_name" name="order_detail_user_name" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="order_detail_phone">Số điện thoại</label> <br>
                        <input type="text" id="order_detail_phone" name="order_detail_phone" readonly>
                    </div>
                    <div class="col">
                        <label for="order_detail_date">Ngày mua</label> <br>
                        <input type="text" id="order_detail_date" name="order_detail_date" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="order_detail_total">Tổng tiền</label> <br>
                        <input type="text" id="order_detail_total" name="order_detail_total" readonly>
                    </div>
                    <div class="col">
                        <label for="order_detail_feeShip">Phí vận chuyển</label> <br>
                        <input type="text" id="order_detail_feeShip" name="order_detail_feeShip" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="order_detail_status">Trạng thái</label> <br>
                        <input type="text" id="order_detail_status" name="order_detail_status" readonly>
                    </div>
                    <div class="col">
                        <label for="order_detail_address">Địa chỉ</label> <br>
                        <input type="text" id="order_detail_address" name="order_detail_address" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="order_detail_ship_method">Phương thức vận chuyển</label> <br>
                        <input type="text" name="order_detail_ship_method" id="order_detail_ship_method" readonly>
                    </div>
                    <div class="col">
                        <label for="order_detail_payment_method">Phương thức thanh toán</label> <br>
                        <input type="text" name="order_detail_payment_method" id="order_detail_payment_method" readonly>
                    </div>
                </div>
                
                <div id="order_detail_book_list">
                    <div id="order_detail_book_list_header">
                        <span>STT</span>
                        <span>Tên sách</span>
                        <span>Giá</span>
                        <span>Số lượng</span>
                    </div>
                    <div id="book_list">
                        <div class="book">
                            <span>STT</span>
                            <span>Tên sách</span>
                            <span>Giá</span>
                            <span>Số lượng</span>
                        </div>
                        <div class="book">
                            <span>STT</span>
                            <span>Tên sách</span>
                            <span>Giá</span>
                            <span>Số lượng</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="/project-Web2/user/assets/js/order_history.js"></script>