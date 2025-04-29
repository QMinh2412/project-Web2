<div class="dashboard-section">
    <div class="dashboard-header">
        <h1 class="h1-header">Khách hàng thân thiết</h1>
        <!-- <div class="search-section">
            <form method="GET" action="">
                <label for="customer-from-date">Từ:</label>
                <input type="date" id="customer-from-date" name="customer-from-date" required>

                <label for="customer-to-date">Đến:</label>
                <input type="date" id="customer-to-date" name="customer-to-date" required>

                <button type="submit">Tìm kiếm</button>
            </form>
        </div> -->
        </div>
        <table class="favoritecus-table">
        <thead>
            <tr>
                <th>STT</th>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Số đơn hàng</th>
                <th>Tổng tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($loyalCustomers)): ?>
                <?php foreach ($loyalCustomers as $index => $customer): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($customer['name']) ?></td>
                        <td><?= htmlspecialchars($customer['email']) ?></td>
                        <td><?= $customer['order_count'] ?></td>
                        <td><?= number_format($customer['total_amount'], 0, ',', '.') ?>đ</td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Không có khách hàng thân thiết nào</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>