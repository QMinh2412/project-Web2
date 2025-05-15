<script src="/project-Web2/admin/assets/js/product.js"></script>

<div class="admin-wrapper">
    <div class="admin-header" id="product-header">
        <h2>Sản phẩm</h2>
        <button onclick="location.href='?page=product&action=create'" href="?page=product&action=create" class="btn btn-primary" id="addProductBtn"><i class='bx bxs-book-add'></i>Thêm sách</button>
    </div>
    <table class="admin-list-container">
        <thead class="admin-list-header">
            <tr class="admin-list-header-content">
                <th id="product-order">ID</th>
                <th id="product-name">Tên sách</th>
                <th id="product-category">Thể loại</th>
                <th id="product-quantity">Số lượng</th>
                <th id="product-price">Giá</th>
                <th id="product-status">Trạng thái</th>
                <th id="product-features">Chức năng</th>
            </tr>
        </thead>
        <tbody class="admin-list-body">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $idx => $product): 
                    $category = $categoryMap[$product['MaLoai']] ?? 'N/A';
                    $status = $product['TinhTrang'] == 1 ? 'Đang bán' : 'Ngừng bán';
                    $canDelete = $product['TinhTrang'] == 0;
                    $productName = htmlspecialchars($product['TenSach'], ENT_QUOTES);
                    $deleteUrl = "?page=product&action=delete&id=" . $product['MaSach'] . "&current_page=" . $pagination['currentPage'];
                ?>
                    <tr>
                        <td class="admin-list-body-content-num" id="product-order"><?= htmlspecialchars(number_format($product['MaSach'])) ?></td>
                        <td class="admin-list-body-content-other" id="product-name"><?= htmlspecialchars($product['TenSach']) ?></td>
                        <td class="admin-list-body-content-num" id="product-category"><?= htmlspecialchars($category) ?></td>
                        <td class="admin-list-body-content-num" id="product-quantity"><?= htmlspecialchars(number_format($product['SoLgTon'])) ?></td>
                        <td class="admin-list-body-content-num" id="product-price"><?= htmlspecialchars(number_format($product['GiaBan'])) ?></td>
                        <td class="admin-list-body-content-num" id="product-status">
                            <label class="switch">
                                <input type="checkbox" 
                                    class="status-toggle" 
                                    <?= $product['TinhTrang'] == 1 ? 'checked' : '' ?> onchange="location.href='?page=product&action=allow&id=<?= $product['MaSach'] ?>&current_page=<?= $pagination['currentPage'] ?>'"
                                >
                                <span class="slider" title="<?= $product['TinhTrang'] ? 'Ngừng bán sản phẩm' : 'Tiến hành mở bán' ?>"></span>
                            </label>
                        </td>
                        <td class="admin-list-body-content-num" id="product-features">
                            <button class="btn btn-primary" id="deleteProductBtn" 
                                    onclick="<?= $canDelete ? "confirmDeleteProduct('$productName', '$deleteUrl')" : 'return false;' ?>"
                                    <?= $canDelete ? '' : 'disabled' ?>
                                    title="<?= $canDelete ? 'Xóa sản phẩm' : 'Không thể xóa sản phẩm đã mở bán hoặc đã có lượt bán' ?>"
                            >
                                <i class='bx bx-trash'></i>
                            </button>
                            <button class="btn btn-primary" id="detailProductBtn" onclick="location.href='?page=product&action=detail&id=<?= number_format($product['MaSach']) ?>&current_page=<?= $pagination['currentPage'] ?>'" title="Xem chi tiết">
                                <i class='bx bx-info-circle'></i>
                            </button>
                            <button class="btn btn-primary" id="editProductBtn" onclick="location.href='?page=product&action=edit&id=<?= $product['MaSach'] ?>&current_page=<?= $pagination['currentPage'] ?>'" title="Sửa sản phẩm">
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
    <div class="product-pagination">
        <a href="?page=product&current_page=<?= $pagination['currentPage'] - 1 ?>" 
            class="<?= $pagination['currentPage'] == 1 ? 'disabled' : '' ?>">
            <i class='bx bx-chevron-left'></i>
        </a>
        
        <?php for ($i = 1; $i <= $pagination['totalPages']; $i++): ?>
            <a href="?page=product&current_page=<?= $i ?>"
               class="<?= $i == $pagination['currentPage'] ? 'active' : '' ?>">
               <?= $i ?>
            </a>
        <?php endfor; ?>

        <a href="?page=product&current_page=<?= $pagination['currentPage'] + 1 ?>" 
            class="<?= $pagination['currentPage'] == $pagination['totalPages'] ? 'disabled' : '' ?>">
            <i class='bx bx-chevron-right'></i>
        </a>
    </div>
</div>
