<script src="/project-Web2/admin/assets/js/order.js"></script>

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
                <th id="order-order">STT</th>
                <th id="order-id">ID</th>
                <th id="order-customer">Khách hàng</th>
                <th id="order-value">Tổng tiền</th>
                <th id="order-time">Thời gian</th>
                <th id="order-status">Tình trạng</th>
                <th id="order-features">Chức năng</th>
            </tr>
        </thead>
        <tbody class="admin-list-body">
            <?php if (!empty($orders)): ?>
                <?php foreach ($orders as $index => $order): 
                    $customer = $userMap[$order['MaKH']] ?? 'N/A';
                ?>
                    <tr>
                        <td class="admin-list-body-content-num" id="order-order"><?= $firstOrder++ ?></td>
                        <td class="admin-list-body-content-num" id="order-id"><?= htmlspecialchars(number_format($order['MaHD'])) ?></td>
                        <td class="admin-list-body-content-other" id="order-customer"><?= htmlspecialchars($customer) ?></td>
                        <td class="admin-list-body-content-num" id="order-value"><?= htmlspecialchars(number_format($order['TongTien'])) ?></td>
                        <td class="admin-list-body-content-num" id="order-time"><?= date_format(new DateTime($order['NgLap']), "d/m/Y") ?></td>
                        <td class="admin-list-body-content-num" id="order-status">
                            <select 
                                class="order-status-dropdown" 
                                onchange="handleStatusChange(this, <?= $order['MaHD'] ?>, <?= $pagination['currentPage'] ?>)"
                            >
                                <?php
                                    $statusLabels = [
                                        1 => 'Chờ duyệt',
                                        2 => 'Đang giao',
                                        3 => 'Đã giao',
                                        0 => 'Đã hủy'
                                    ];

                                    $currentStatus = $order['TrangThaiDH'];
                                    foreach ($statusLabels as $value => $label) {
                                        $allow = false;

                                        if ($value === $currentStatus) {
                                            $allow = true;
                                        }

                                        if (($value > $currentStatus && $value != 0 && $currentStatus <= 3) || ($value === 0 && $currentStatus < 2)) {
                                            $allow = true;
                                        }   

                                        if ($allow) {
                                            echo "<option value='$value'" . ($value === $currentStatus ? ' selected' : '') . " class='order-status-dropdown'>$label</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </td>
                        <td class="admin-list-body-content-num" id="order-features">
                            <button class="btn btn-primary" id="detailOrderBtn" 
                                onclick="location.href='?page=order&action=detail&id=<?= number_format($order['MaHD']) ?>&current_page=<?= $pagination['currentPage'] ?>'" 
                                title="Xem chi tiết"
                            >
                                <i class='bx bx-info-circle'></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">Không có đơn hàng nào</td>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Phân trang -->
    <div class="order-pagination">
        <a href="?page=order&current_page=<?= $pagination['currentPage'] - 1 ?>" 
            class="<?= $pagination['currentPage'] == 1 ? 'disabled' : '' ?>">
            <i class='bx bx-chevron-left'></i>
        </a>
        
        <?php for ($i = 1; $i <= $pagination['totalPages']; $i++): ?>
            <a href="?page=order&current_page=<?= $i ?>"
               class="<?= $i == $pagination['currentPage'] ? 'active' : '' ?>">
               <?= $i ?>
            </a>
        <?php endfor; ?>

        <a href="?page=order&current_page=<?= $pagination['currentPage'] + 1 ?>" 
            class="<?= $pagination['currentPage'] == $pagination['totalPages'] ? 'disabled' : '' ?>">
            <i class='bx bx-chevron-right'></i>
        </a>
    </div>
</div>