<script src="/project-Web2/admin/assets/js/dashboard.js"></script>
<link rel="stylesheet" href="../../assets/css/dashboard.css">
<div class="admin-wrapper">
    <div class="dashboard-header">
        <h1 class="h1-header">Thống kê doanh thu</h1>
        <div class="search-section">
            <form method="GET" action="">
                <label for="customer-from-date">Từ:</label>
                <input type="date" id="customer-from-date" name="customer-from-date" value="<?= htmlspecialchars($_GET['customer-from-date'] ?? '') ?>" required>

                <label for="customer-to-date">Đến:</label>
                <input type="date" id="customer-to-date" name="customer-to-date" value="<?= htmlspecialchars($_GET['customer-to-date'] ?? '') ?>" required>

                <button type="submit">Tìm kiếm</button>
            </form>
        </div>
    </div>
    <div class="dashboard-statistics">
        <div class="statistic-box">
            <h3>Tổng doanh thu bán hàng</h3>
            <div class="statistic-content">
                <p><?= number_format($totalRev, 0, ',', '.') ?> đ</p>
                <img src="./assets/images/income.png" alt="Tổng doanh thu bán hàng">
            </div>
        </div>
        <div class="statistic-box">
            <h3>Chi phí nhập hàng</h3>
            <div class="statistic-content">
                <p><?= number_format($totalCost, 0, ',', '.') ?> đ</p>
                <img src="./assets/images/revenue.png" alt="Chi phí nhập hàng">
            </div>
        </div>
        <div class="statistic-box">
            <h3>Lợi nhuận</h3>
            <div class="statistic-content">
                <p><?= number_format($totalRev - $totalCost, 0, ',', '.') ?> đ</p>
                <img src="./assets/images/loses.png" alt="Doanh thu đã trừ chi phí">
            </div>
        </div>
    </div>
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
    <div class="dashboard-section">
        <div class="dashboard-header">
            <h1 class="h1-header">Sách bán chạy</h1>
        </div>
        <table class="bestseller-table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên sách</th>
                    <th>Số lượng bán được</th>
                    <th>Tổng tiền</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($bestSellers)) : ?>
                <?php $index = 1; ?>
                <?php foreach ($bestSellers as $bestSeller) : ?>
                    <tr>
                        <td><?= $index++ ?></td>
                        <td><?= htmlspecialchars($bestSeller['TenSach']) ?></td>
                        <td><?= htmlspecialchars($bestSeller['total_sold']) ?></td>
                        <td><?= number_format($bestSeller['total_revenue'], 0, ',', '.') ?>₫</td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="5">Không có dữ liệu</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    
</div>