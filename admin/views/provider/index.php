<script src="/project-Web2/admin/assets/js/provider.js"></script>

<div class="admin-wrapper">
    <div class="admin-header" id="provider-header">
        <h2>Nhà cung cấp</h2>
        <button onclick="location.href='?page=provider&action=create'" href="?page=provider&action=create" class="btn btn-primary" id="addProviderBtn"><i class='bx bxs-book-add'></i>Thêm nhà cung cấp</button>
    </div>
    <table class="admin-list-container">
        <thead class="admin-list-header">
            <tr class="admin-list-header-content">
                <th id="provider-order">ID</th>
                <th id="provider-name">Tên</th>
                <th id="provider-address">Địa chỉ</th>
                <th id="provider-email">Email</th>
                <th id="provider-features">Chức năng</th>
            </tr>
        </thead>
        <tbody class="admin-list-body">
            <?php if (!empty($providers)): ?>
                <?php foreach ($providers as $provider): 
                    $providerName = htmlspecialchars($provider['TenNCC'], ENT_QUOTES);    
                    $deleteUrl = "?page=provider&action=delete&id=" . $provider['MaNCC'] . "&current_page=" . $pagination['currentPage'];
                ?>
                    <tr>
                        <td class="admin-list-body-content-num" id="provider-order"><?= htmlspecialchars(number_format($provider['MaNCC'])) ?></td>
                        <td class="admin-list-body-content-other" id="provider-name"><?= htmlspecialchars($provider['TenNCC']) ?></td>
                        <td class="admin-list-body-content-other" id="provider-address"><?= htmlspecialchars($provider['DcNCC']) ?></td>
                        <td class="admin-list-body-content-num" id="provider-email"><?= htmlspecialchars($provider['EmailNCC']) ?></td>
                        <td class="admin-list-body-content-num" id="provider-features">
                            <button class="btn btn-primary" id="deleteProviderBtn" 
                                    onclick="confirmDeleteProvider('<?= $providerName ?>', '<?= $deleteUrl ?>')"
                                    title="Xóa nhà cung cấp"
                            >
                                <i class='bx bx-trash'></i>
                            </button>
                            <button class="btn btn-primary" id="detailProviderBtn" onclick="location.href='?page=provider&action=detail&id=<?= number_format($provider['MaNCC']) ?>&current_page=<?= $pagination['currentPage'] ?>'" title="Xem chi tiết">
                                <i class='bx bx-info-circle'></i>
                            </button>
                            <button class="btn btn-primary" id="editProviderBtn" onclick="location.href='?page=provider&action=edit&id=<?= $provider['MaNCC'] ?>&current_page=<?= $pagination['currentPage'] ?>'" title="Sửa nhà cung cấp">
                                <i class='bx bx-edit'></i>
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
    <div class="provider-pagination">
        <a href="?page=provider&current_page=<?= $pagination['currentPage'] - 1 ?>" 
            class="<?= $pagination['currentPage'] == 1 ? 'disabled' : '' ?>">
            <i class='bx bx-chevron-left'></i>
        </a>
        
        <?php for ($i = 1; $i <= $pagination['totalPages']; $i++): ?>
            <a href="?page=provider&current_page=<?= $i ?>"
               class="<?= $i == $pagination['currentPage'] ? 'active' : '' ?>">
               <?= $i ?>
            </a>
        <?php endfor; ?>

        <a href="?page=provider&current_page=<?= $pagination['currentPage'] + 1 ?>" 
            class="<?= $pagination['currentPage'] == $pagination['totalPages'] ? 'disabled' : '' ?>">
            <i class='bx bx-chevron-right'></i>
        </a>
    </div>
</div>
