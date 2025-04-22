<script src="/project-Web2/admin/assets/js/import.js"></script>

<div class="admin-wrapper">
    <div class="admin-header" id="import-header">
        <h2>Nhập sách</h2>
    </div>
    <div class="order-container">
        <form class="order-search-form" method="GET" action="">
            <div class="order-form-group">
                <label for="import-search-import-id">Mã phiếu nhập</label>
                <input type="number" id="import-search-import-id" 
                    name="import_id" 
                    placeholder="Nhập mã phiếu nhập" 
                    value="<?= htmlspecialchars($_GET['import_id'] ?? '') ?>"
                >
            </div>
            <div class="order-form-group">
                <label for="import-search-import-status">Trạng thái</label>
                <select id="import-search-import-status" name="import_status">
                    <option value="" <?= empty($_GET['import_status']) ? 'selected' : '' ?>>Tất cả</option>
                    <option value="0" <?= (isset($_GET['import_status']) && $_GET['import_status'] == '0') ? 'selected' : '' ?>>Chưa hoàn thành</option>
                    <option value="1" <?= (isset($_GET['import_status']) && $_GET['import_status'] == '1') ? 'selected' : '' ?>>Đã hoàn thành</option>
                </select>
            </div>
            <div class="order-form-group">
                <label for="import-search-from-date">Từ ngày</label>
                <input type="date" id="import-search-from-date" name="import_from_date" value="<?= htmlspecialchars($_GET['import_from_date'] ?? '') ?>">
            </div>
            <div class="order-form-group">
                <label for="import-search-to-date">Đến ngày</label>
                <input type="date" id="import-search-to-date" name="import_to_date" value="<?= htmlspecialchars($_GET['import_to_date'] ?? '') ?>">
            </div>
            <div class="order-form-group">
                <button type="submit" class="order-search-btn" id="import-search-btn">
                    <i class='bx bx-search'></i>
                    Tìm kiếm
                </button>
            </div>
            <div class="order-form-group">
                <button type="button" class="import-add-btn" id="import-add-btn" onclick="addImport(this)">Thêm phiếu nhập</button>
            </div>
        </form>
    </div>

    <table class="admin-list-container">
        <thead class="admin-list-header">
            <tr class="admin-list-header-content">
                <th id="import-id">ID</th>
                <th id="import-provider">Tên nhà cung cấp</th>
                <th id="import-value">Tổng tiền</th>
                <th id="import-time">Thời gian</th>
                <th id="import-status">Tình trạng</th>
                <th id="import-features">Chức năng</th>
            </tr>
        </thead>
        <tbody class="admin-list-body">
            <?php if (!empty($imports)): ?>
                <?php foreach ($imports as $index => $import): 
                    $provider = $providerMap[$import['MaNCC']] ?? 'N/A';
                ?>
                    <tr>
                        <td class="admin-list-body-content-num" id="import-id"><?= htmlspecialchars(number_format($import['MaPhNhap'])) ?></td>
                        <td class="admin-list-body-content-other" id="import-provider"><?= htmlspecialchars($provider) ?></td>
                        <td class="admin-list-body-content-num" id="import-value"><?= htmlspecialchars(number_format($import['TongTien'])) ?></td>
                        <td class="admin-list-body-content-num" id="import-time"><?= date_format(new DateTime($import['NgNhap']), "d/m/Y") ?></td>
                        <td class="admin-list-body-content-num" id="import-status">
                            <select 
                                class="import-status-dropdown" 
                                onchange="handleStatusChange(this, <?= $import['MaPhNhap'] ?>, <?= $pagination['currentPage'] ?>)"
                            >
                                <?php
                                    $statusLabels = [
                                        0 => 'Chưa hoàn thành',
                                        1 => 'Đã hoàn thành'
                                    ];

                                    $currentStatus = (int)$import['TinhTrang'];
                                    foreach ($statusLabels as $value => $label) {
                                        $allow = false;

                                        if ($value === $currentStatus) {
                                            $allow = true;
                                        }
                                        
                                        if ($value != 0 && $value > $currentStatus) {
                                            $allow = true;
                                        }

                                        if ($allow) {
                                            echo "<option value='$value'" . ($value === $currentStatus ? ' selected' : '') . " class='import    -status-dropdown'>$label</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </td>
                        <td class="admin-list-body-content-num" id="import-features">
                            <button class="btn btn-primary" id="detailImportBtn" 
                                onclick="location.href='?page=import&action=detail&id=<?= number_format($import['MaPhNhap']) ?>&current_page=<?= $pagination['currentPage'] ?>'" 
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
        <a href="?page=import&current_page=<?= $pagination['currentPage'] - 1 ?>" 
            class="<?= $pagination['currentPage'] == 1 ? 'disabled' : '' ?>">
            <i class='bx bx-chevron-left'></i>
        </a>
        
        <?php for ($i = 1; $i <= $pagination['totalPages']; $i++): ?>
            <a href="?page=import&current_page=<?= $i ?>"
               class="<?= $i == $pagination['currentPage'] ? 'active' : '' ?>">
               <?= $i ?>
            </a>
        <?php endfor; ?>

        <a href="?page=import&current_page=<?= $pagination['currentPage'] + 1 ?>" 
            class="<?= $pagination['currentPage'] == $pagination['totalPages'] ? 'disabled' : '' ?>">
            <i class='bx bx-chevron-right'></i>
        </a>
    </div>
</div>

<!--------------------------- FORM ADD PHIEU NHAP ----------------------------->
<div class="import-add-modal" id="import-add-modal">
    <div class="import-add-modal-content">
        <h2 id="import-add-header">Bảng nhập sách</h2>
        <form id="import-add-form" action="?page=import&action=create" method="POST" enctype="multipart/form-data">
            <div class="import-add-form-group">
                <label for="import-add-provider">Nhà cung cấp</label>
                <select id="import-add-provider" name="import_provider" required>
                    <option value="">Chọn nhà cung cấp:</option>
                    <?php foreach ($providerMap as $id => $name): ?>
                        <option value="<?= htmlspecialchars($id) ?>"><?= htmlspecialchars($name) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="import-add-form-group">
                <label for="import-add-profit">Chiết khấu:</label>
                <input type="number" name="importprofit" id="import-add-profit" placeholder="Nhập chiết khấu" min="0" max="100" value="0">
            </div>
            <div class="import-add-form-group" id="import-add-btn">
                <button type="button" id="import-cancel-btn" onclick="closeAddImport(this)">Hủy</button>
                <button type="submit" id="import-accept-btn">Tiếp tục</button>
            </div>
        </form>
    </div>
</div>