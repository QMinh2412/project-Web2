<!-- filepath: d:\xampp\htdocs\project-Web2\admin\views\order\index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách đơn hàng</title>
    <link rel="stylesheet" href="../../assets/css/order.css">
</head>
<body>
    <div class="order-container">
        <h2>Đơn hàng</h2>
        <form method="GET" action="">
            <input type="text" name="order_id" placeholder="Mã hóa đơn">
            <select name="status">
                <option value="">Trạng thái</option>
                <option value="pending">Chờ xác nhận</option>
                <option value="confirmed">Xác nhận</option>
                <option value="shipping">Vận chuyển</option>
                <option value="completed">Hoàn thành</option>
                <option value="cancelled">Đã hủy</option>
            </select>
            <input type="date" name="start_date" placeholder="Từ ngày">
            <input type="date" name="end_date" placeholder="Đến ngày">
            <button type="submit">Tìm kiếm</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>ID đơn hàng</th>
                    <th>Tên khách hàng</th>
                    <th>Tổng tiền</th>
                    <th>Thời gian</th>
                    <th>Tình trạng</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
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
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>