<link rel="stylesheet" href="../../assets/css/dashboard.css">
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
                <th>Giá tiền</th>
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
                    <td>—</td> <!-- Giá (nếu cần lấy thì join thêm) -->
                    <td>—</td> <!-- Tổng tiền (nếu cần lấy thì tự tính) -->
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