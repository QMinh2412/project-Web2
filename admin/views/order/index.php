<div class="admin-wrapper">
    <div class="admin-header" id="order-header">
        <h2>Đơn hàng</h2>
    </div>
    <div class="order-container">
        <form class="order-search-form" method="GET" action="">
            <div class="order-form-group">
                <label for="order-id">Mã hóa đơn</label>
                <input type="text" id="order-id" name="order_id" placeholder="Nhập mã hóa đơn">
            </div>
            <div class="order-form-group">
                <label for="status">Trạng thái</label>
                <select id="status" name="status">
                    <option value="">Tất cả</option>
                    <option value="pending">Chờ xác nhận</option>
                    <option value="confirmed">Xác nhận</option>
                    <option value="shipping">Vận chuyển</option>
                    <option value="completed">Hoàn thành</option>
                    <option value="cancelled">Đã hủy</option>
                </select>
            </div>
            <div class="order-form-group">
                <label for="from-date">Từ ngày</label>
                <input type="date" id="from-date" name="from_date">
            </div>
            <div class="order-form-group">
                <label for="to-date">Đến ngày</label>
                <input type="date" id="to-date" name="to_date">
            </div>
            <div class="order-form-group">
                <button type="submit" class="order-search-btn">Tìm kiếm</button>
            </div>
        </form>
    </div>
    <table class="admin-list-container">
        <thead class="admin-list-header">
            <tr class="admin-list-header-content">
                <th>STT</th>
                <th>ID đơn hàng</th>
                <th>Tên khách hàng</th>
                <th>Tổng tiền</th>
                <th>Thời gian</th>
                <th>Tình trạng</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody class="admin-list-body">
            <?php if (!empty($orders)): ?>
                <?php foreach ($orders as $index => $order): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($order['id']) ?></td>
                        <td><?= htmlspecialchars($order['customer_name']) ?></td>
                        <td><?= number_format($order['total'], 0, ',', '.') ?>đ</td>
                        <td><?= htmlspecialchars($order['created_at']) ?></td>
                        <td><?= htmlspecialchars($order['status']) ?></td>
                        <td>
                            <button class="detail-btn">Chi tiết</button>
                            <button class="confirm-btn">Xác nhận</button>
                            <button class="cancel-btn">Hủy</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">Không có đơn hàng nào</td>
            <?php endif; ?>
        </tbody>
    </table>
</div>