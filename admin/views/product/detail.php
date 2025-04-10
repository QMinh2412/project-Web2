<script src="/project-Web2/admin/assets/js/product.js"></script>

<?php 
$category = $categoryMap[$product['MaLoai']] ?? 'N/A';

$status = $product['TinhTrang'] == 1 ? 'Đang bán' : 'Ngừng bán';

$author = $authorMap[$product['MaTG']] ?? 'N/A';

$publisher = $publisherMap[$product['MaNXB']] ?? 'N/A';
?>
<div class="admin-wrapper">
    <div class="admin-header" id="product-header">
        <h2>Chi tiết sản phẩm</h2>
        <div id="create-product-form">
        <label class="product-create-label" for="product-id">ID sản phẩm:</label><br>
            <input class="product-create-text" type="text" name="product_id" id="product-id-input" value="<?= htmlspecialchars(number_format($product['MaSach'])) ?>" readonly>
        
            <label class="product-create-label" for="product-name">Tên sản phẩm:</label><br>
            <input class="product-create-text" type="text" name="product_name" id="product-name-input" value="<?= htmlspecialchars($product['TenSach']) ?>" readonly>

            <label class="product-create-label" for="product-category">Thể loại:</label><br>
            <input class="product-create-text" type="text" name="product_category" id="product-category-input" value="<?= htmlspecialchars($category) ?>" readonly>

            <label class="product-create-label" for="product-author">Tác giả:</label><br>
            <input class="product-create-text" type="text" name="product_author" id="product-author-input" value="<?= htmlspecialchars($author) ?>" readonly>

            <label class="product-create-label" for="product-publisher">Nhà xuất bản:</label><br>
            <input class="product-create-text" type="text" name="product_publisher" id="product-publisher-input" value="<?= htmlspecialchars($publisher) ?>" readonly>

            <label class="product-create-label" for="product-quantity">Số lượng:</label><br>
            <input class="product-create-numeric" type="number" name="product_quantity" id="product-quantity-input" value="<?= htmlspecialchars(number_format($product['SoLgTon'])) ?>" readonly>

            <label class="product-create-label" for="product-price">Giá:</label><br>
            <div class="product-create-numeric" type="number" name="product_price" id="product-price-input"><?= htmlspecialchars(number_format($product['GiaBan'])) ?></div>

            <label class="product-create-label" for="product-year">Năm xuất bản:</label><br>
            <input class="product-create-numeric" type="number" name="product_year" id="product-year-input" value="<?= htmlspecialchars($product['NamXB']) ?>" readonly>

            <label class="product-create-label" for="product-page">Số trang:</label><br>
            <input class="product-create-numeric" type="number" name="product_page" id="product-page-input" value="<?= htmlspecialchars(number_format($product['SoTrang'])) ?>" readonly>

            <label class="product-create-label" for="product-size">Kích thước:</label><br>
            <input class="product-create-text" type="text" name="product_size" id="product-size-input" value="<?= htmlspecialchars($product['KichThuoc']) ?>" readonly>

            <label class="product-create-label" for="product-description">Mô tả:</label><br>
            <textarea name="product_description" id="product-description-input" readonly><?= htmlspecialchars($product['MoTaChiTiet']) ?></textarea>

            <label class="product-create-label" for="product-status">Trạng thái:</label><br>
            <input class="product-create-text" type="text" name="product_status" id="product-status-input" value="<?= htmlspecialchars($status) ?>" readonly>

            <label class="product-create-label" for="product-image">Hình ảnh:</label><br>
            <div id="product-image-preview">
                <?php foreach ($images as $src): ?>
                    <img src="<?= htmlspecialchars($src['DgDanAnh'], ENT_QUOTES, 'UTF-8') ?>" class="product-image-img">
                <?php endforeach; ?>
            </div>


            <button type="button" class="product-create-Btns" id="closeProductBtn" onclick="location.href='?page=product&action=index&current_page=<?= $currentPage ?>'">Xong</button>
        </div>
    </div>
</div>