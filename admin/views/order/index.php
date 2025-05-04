<script src="/project-Web2/admin/assets/js/order.js"></script>

<div class="admin-wrapper">
    <div class="admin-header" id="order-header">
        <h2>Đơn hàng</h2>
    </div>
    <div class="order-container">
        <form class="order-search-form" method="GET" action="">
            <div class="order-form-group">
                <label for="order-search-order-id">Mã hóa đơn</label>
                <input type="number" id="order-search-order-id" 
                    name="order_id" 
                    placeholder="Nhập mã hóa đơn" 
                    value="<?= htmlspecialchars($_GET['order_id'] ?? '') ?>"
                >
            </div>
            <div class="order-form-group">
                <label for="order-search-order-status">Trạng thái</label>
                <select id="order-search-order-status" name="order_status">
                    <option value="" <?= empty($_GET['order_status']) ? 'selected' : '' ?>>Tất cả</option>
                    <option value="1" <?= (isset($_GET['order_status']) && $_GET['order_status'] == '1') ? 'selected' : '' ?>>Chờ duyệt</option>
                    <option value="2" <?= (isset($_GET['order_status']) && $_GET['order_status'] == '2') ? 'selected' : '' ?>>Đang giao</option>
                    <option value="3" <?= (isset($_GET['order_status']) && $_GET['order_status'] == '3') ? 'selected' : '' ?>>Đã giao</option>
                    <option value="0" <?= (isset($_GET['order_status']) && $_GET['order_status'] == '0') ? 'selected' : '' ?>>Đã hủy</option>
                </select>
            </div>
            <div class="order-form-group">
                <label for="order-search-from-date">Từ ngày</label>
                <input type="date" id="order-search-from-date" name="order_from_date" value="<?= htmlspecialchars($_GET['order_from_date'] ?? '') ?>">
            </div>
            <div class="order-form-group">
                <label for="order-search-to-date">Đến ngày</label>
                <input type="date" id="order-search-to-date" name="order_to_date" value="<?= htmlspecialchars($_GET['order_to_date'] ?? '') ?>">
            </div>
            <div class="order-form-group">
                <button type="submit" class="order-search-btn" id="order-search-btn">
                    <i class='bx bx-search'></i> 
                    Tìm kiếm
                </button>
            </div>
        </form>
    </div>

    <table class="admin-list-container" id="order-list-container">
        <thead class="admin-list-header" id="order-list-header">
            <tr class="admin-list-header-content" id="order-list-header-content">
                <th id="order-order">STT</th>
                <th id="order-id">ID</th>
                <th id="order-customer">Khách hàng</th>
                <th id="order-value">Tổng tiền</th>
                <th id="order-time">Thời gian</th>
                <th id="order-status">Tình trạng</th>
                <th id="order-features">Chức năng</th>
            </tr>
        </thead>
        <tbody class="admin-list-body" id="order-list-body">
            <?php if (!empty($orders)): ?>
                <?php foreach ($orders as $index => $order): 
                    $customer = $userMap[$order['MaKH']] ?? 'N/A';
                ?>
                    <tr>
                        <td class="admin-list-body-content-num" id="order-order" data-label="STT"><?= $firstOrder++ ?></td>
                        <td class="admin-list-body-content-num" id="order-id" data-label="ID"><?= htmlspecialchars(number_format($order['MaHD'])) ?></td>
                        <td class="admin-list-body-content-other" id="order-customer" data-label="Khách hàng"><?= htmlspecialchars($customer) ?></td>
                        <td class="admin-list-body-content-num" id="order-value" data-label="Tổng tiền"><?= htmlspecialchars(number_format($order['TongTien'])) ?></td>
                        <td class="admin-list-body-content-num" id="order-time order-list-body-status" data-label="Ngày tạo"><?= date_format(new DateTime($order['NgLap']), "d/m/Y") ?></td>
                        <td class="admin-list-body-content-num" id="order-status" data-label="Tình trạng">
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

                                    $currentStatus = (int)$order['TrangThaiDH'];
                                    foreach ($statusLabels as $value => $label) {
                                        $allow = false;

                                        if ($value === $currentStatus) {
                                            $allow = true;
                                        }

                                        if ($currentStatus !== 0) {
                                            if (($value > $currentStatus && $value != 0 && $currentStatus <= 3) || ($value === 0 && $currentStatus < 2)) {
                                                $allow = true;
                                            }
                                        }   

                                        if ($allow) {
                                            echo "<option value='$value'" . ($value === $currentStatus ? ' selected' : '') . " class='order-status-dropdown'>$label</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </td>
                        <td class="admin-list-body-content-num" id="order-features" data-label="Chức năng">
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