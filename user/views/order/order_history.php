<!-- app/User/Views/order_history.php -->
<link rel="stylesheet" href="/project-Web2/user/assets/css/order_history.css">
<body>
    <div class="order-history-container">
        <h2>Lịch sử giao dịch</h2>
        <div class="filter-box">
            <button onclick="window.location.href='/project-Web2/user/index.php?page=user&action=updateAccount'">Cập nhật tài khoản</button>
            <button onclick="window.location.href='/project-Web2/user/index.php?page=user&action=changePassword'">Thay đổi mật khẩu</button>
            <button class="active">Lịch sử giao dịch</button>
            <input type="text" name="invoice_id" placeholder="Mã hóa đơn" value="<?php echo htmlspecialchars($filters['invoice_id'] ?? ''); ?>">
            <select name="status">
                <option value="">Trạng thái</option>
                <option value="0" <?php echo ($filters['status'] ?? '') == '0' ? 'selected' : ''; ?>>Chưa xử lý</option>
                <option value="1" <?php echo ($filters['status'] ?? '') == '1' ? 'selected' : ''; ?>>Đang xử lý</option>
                <option value="2" <?php echo ($filters['status'] ?? '') == '2' ? 'selected' : ''; ?>>Đã giao</option>
                <option value="3" <?php echo ($filters['status'] ?? '') == '3' ? 'selected' : ''; ?>>Hủy</option>
            </select>
            <input type="date" name="from_date" placeholder="Từ ngày" value="<?php echo htmlspecialchars($filters['from_date'] ?? ''); ?>">
            <input type="date" name="to_date" placeholder="Đến ngày" value="<?php echo htmlspecialchars($filters['to_date'] ?? ''); ?>">
            <button onclick="applyFilters()">   Tìm kiếm</button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Mã hóa đơn</th>
                    <th>Tổng tiền</th>
                    <th>Thanh toán</th>
                    <th>Vận chuyển</th>
                    <th>Ngày tạo</th>
                    <th>Xem</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($orders)): ?>
                    <tr>
                        <td colspan="6">Không có giao dịch nào.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['MaHD']); ?></td>
                            <td><?php echo htmlspecialchars($order['TongTien']); ?> VND</td>
                            <td><?php echo $order['PhThucTT'] == 0 ? 'COD' : 'Chuyển khoản'; ?></td>
                            <td><?php echo $order['PhThucVC'] == 0 ? 'Hỏa tốc' : 'Bình thường'; ?></td>
                            <td><?php echo htmlspecialchars($order['NgLap']); ?></td>
                            <td><a href="/project-Web2/user/index.php?page=user&action=viewOrder&order_id=<?php echo $order['MaHD']; ?>">Xem</a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script>
        function applyFilters() {
            const invoiceId = document.querySelector('input[name="invoice_id"]').value;
            const status = document.querySelector('select[name="status"]').value;
            const fromDate = document.querySelector('input[name="from_date"]').value;
            const toDate = document.querySelector('input[name="to_date"]').value;

            let url = '/project-Web2/user/index.php?page=user&action=orderHistory';
            const params = [];
            if (invoiceId) params.push('invoice_id=' + encodeURIComponent(invoiceId));
            if (status) params.push('status=' + encodeURIComponent(status));
            if (fromDate) params.push('from_date=' + encodeURIComponent(fromDate));
            if (toDate) params.push('to_date=' + encodeURIComponent(toDate));

            if (params.length > 0) {
                url += '&' + params.join('&');
            }
            window.location.href = url;
        }
    </script>
</body>
</html>