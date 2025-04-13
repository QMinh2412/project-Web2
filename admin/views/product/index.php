<script src="/project-Web2/admin/assets/js/product.js"></script>

<div class="admin-wrapper">
    <div class="admin-header" id="product-header">
        <h2>Sản phẩm</h2>
        <a href="?page=product&action=create" class="btn btn-primary" id="addProductBtn">Thêm sách</a>
    </div>
    <table class="admin-list-container">
        <thead class="admin-list-header">
            <tr class="admin-list-header-content">
                <th id="product-order">STT</th>
                <th id="product-name">Tên sách</th>
                <th id="product-category">Thể loại</th>
                <th id="product-quantity">Số lượng</th>
                <th id="product-price">Giá</th>
                <th id="product-status">Trạng thái</th>
                <th id="product-features">Chức năng</th>
            </tr>
        </thead>
        <tbody class="admin-list-body">
            <?php foreach ($products as $idx => $product): 
            $category = $categoryMap[$product['MaLoai']] ?? 'N/A';
            $status = $product['TinhTrang'] == 1 ? 'Đang bán' : 'Ngừng bán';
        ?>
                <tr>
                    <td class="admin-list-body-content-num" id="product-order"><?= htmlspecialchars(number_format($product['MaSach'])) ?></td>
                    <td class="admin-list-body-content-other" id="product-name"><?= htmlspecialchars($product['TenSach']) ?></td>
                    <td class="admin-list-body-content-num" id="product-category"><?= htmlspecialchars($category) ?></td>
                    <td class="admin-list-body-content-num" id="product-quantity"><?= htmlspecialchars(number_format($product['SoLgTon'])) ?></td>
                    <td class="admin-list-body-content-num" id="product-price"><?= htmlspecialchars(number_format($product['GiaBan'])) ?></td>
                    <td class="admin-list-body-content-num" id="product-status">
                        <label class="switch">
                            <input type="checkbox" class="status-toggle" data-id="<?= $product['MaSach'] ?>" <?= $product['TinhTrang'] == 1 ? 'checked' : '' ?> onchange="location.href='?page=product&action=allow&id=<?= $product['MaSach'] ?>&current_page=<?= $pagination['currentPage'] ?>'">
                            <span class="slider"></span>
                        </label>
                    </td>
                    <td class="admin-list-body-content-num" id="product-features">
                        <button class="btn btn-primary" id="detailProductBtn" onclick="location.href='?page=product&action=detail&id=<?= number_format($product['MaSach']) ?>&current_page=<?= $pagination['currentPage'] ?>'">
                            <i class='bx bx-info-circle'></i>
                            Chi tiết
                        </button>
                        <button class="btn btn-primary" id="editProductBtn" onclick="location.href='?page=product&action=edit&id=<?= $product['MaSach'] ?>&current_page=<?= $pagination['currentPage'] ?>'">
                            <i class='bx bx-edit'></i>
                            Sửa
                        </button>
                        
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Phân trang -->
    <div class="product-pagination">
        <a href="?page=product&current_page=<?= $pagination['currentPage'] - 1 ?>" 
            class="<?= $pagination['currentPage'] == 1 ? 'disabled' : '' ?>">&lt;</a>
        
        <?php for ($i = 1; $i <= $pagination['totalPages']; $i++): ?>
            <a href="?page=product&current_page=<?= $i ?>"
               class="<?= $i == $pagination['currentPage'] ? 'active' : '' ?>">
               <?= $i ?>
            </a>
        <?php endfor; ?>

        <a href="?page=product&current_page=<?= $pagination['currentPage'] + 1 ?>" 
            class="<?= $pagination['currentPage'] == $pagination['totalPages'] ? 'disabled' : '' ?>">&gt;</a>
    </div>
</div>
