<script src="/project-Web2/admin/assets/js/product.js"></script>

<div class="admin-wrapper">
    <div class="admin-header" id="product-header">
        <h2>Sửa sản phẩm</h2>
        <form id="create-product-form" method="POST" action="?page=product&action=edit&id=<?= htmlspecialchars($product['MaSach']) ?>">
            <label class="product-create-label" for="product-name">Tên sản phẩm:</label><br>
            <input class="product-create-text" type="text" name="product_name" id="product-name-input" placeholder="Tên sản phẩm" value="<?= htmlspecialchars($product['TenSach']) ?>" required>

            <label class="product-create-label" for="product-category">Thể loại:</label><br>
            <select class="product-create-dropdown" name="product_category" id="product-category-input">
                <?php
                    foreach ($categories as $category): 
                        $selected = ($category['MaLoai'] == $product['MaLoai']) ? 'selected' : '';
                        echo "<option value='{$category['MaLoai']}' {$selected}>{$category['TenLoai']}</option>";
                    endforeach;
                ?>
            </select>

            <label class="product-create-label" for="product-author">Tác giả:</label><br>
            <select class="product-create-dropdown" name="product_author" id="product-author-input">
                <?php
                    foreach ($authors as $author):
                        $selected = ($author['MaTG'] == $product['MaTG']) ? 'selected' : '';
                        echo "<option value='{$author['MaTG']}' {$selected}>{$author['TenTG']}</option>";
                    endforeach;
                ?>
                <option value="0">+ Nhập tên tác giả</option>
            </select>
            <input type="text" class="new-author-input" name="product_author_name" id="product-author-name-input" style="display: none;" placeholder="Nhập tên tác giả mới">
            <input type="date" class="new-author-input" name="product_author_birthday" id="product-author-birthday-input" style="display: none;" placeholder="Nhập ngày sinh tác giả mới">
            <select class="new-author-input" name="product_author_gender" id="product-author-gender-input" style="display: none;">
                <option value="0">Nam</option>
                <option value="1">Nữ</option>
                <option value="2">Không rõ</option>
            </select>

            <label class="product-create-label" for="product-publisher">Nhà xuất bản:</label><br>
            <select class="product-create-dropdown" name="product_publisher" id="product-publisher-input">
                <?php
                    foreach ($publishers as $publisher):
                        $selected = ($publisher['MaNXB'] == $product['MaNXB']) ? 'selected' : '';                       
                        echo "<option value='{$publisher['MaNXB']}' {$selected}>{$publisher['TenNXB']}</option>";
                    endforeach;
                ?>
                <option value="0">+ Nhập tên nhà xuất bản</option>
            </select>
            <input class="new-publisher-input" type="text" name="product_publisher_name" id="product-publisher-name-input" style="display: none;" placeholder="Nhập tên nhà xuất bản mới">
            <input class="new-publisher-input" type="text" name="product_publisher_address" id="product-publisher-address-input" style="display: none;" placeholder="Nhập địa chỉ nhà xuất bản mới">
            <input class="new-publisher-input" type="email" name="product_publisher_email" id="product-publisher-email-input" style="display: none;" placeholder="Nhập email nhà xuất bản mới">
        
            <label class="product-create-label" for="product-provider">Nhà cung cấp:</label><br>
            <select class="product-create-dropdown" name="product_provider" id="product-provider-input">
                <?php
                    foreach ($providers as $provider):
                        $selected = ($provider['MaNCC'] == $product['MaNCC']) ? 'selected' : '';
                        echo "<option value='{$provider['MaNCC']}' {$selected}>{$provider['TenNCC']}</option>";
                    endforeach;
                ?>
                <option value="0">+ Nhập tên nhà cung cấp</option>
            </select>
            <input class="new-provider-input" type="text" name="product_provider_name" id="product-provider-name-input" style="display: none;" placeholder="Nhập tên nhà cung cấp mới">
            <input class="new-provider-input" type="text" name="product_provider_address" id="product-provider-address-input" style="display: none;" placeholder="Nhập địa chỉ nhà cung cấp mới">
            <input class="new-provider-input" type="email" name="product_provider_email" id="product-provider-email-input" style="display: none;" placeholder="Nhập email nhà cung cấp mới">

            <label class="product-create-label" for="product-quantity">Số lượng:</label><br>
            <input class="product-create-numeric" type="number" name="product_quantity" id="product-quantity-input" placeholder="Số lượng" min="0" value="<?= htmlspecialchars($product['SoLgTon']) ?>" required>

            <label class="product-create-label" for="product-price">Giá:</label><br>
            <input class="product-create-numeric" type="number" name="product_price" id="product-price-input" placeholder="Giá" min="10000" value="<?= htmlspecialchars($product['GiaBan']) ?>" required>

            <label class="product-create-label" for="product-year">Năm xuất bản:</label><br>
            <select class="product-create-dropdown" name="product_year" id="product-year-input" required>
                <?php
                    $selectedYear = date("Y", strtotime($product['NamXB']));
                    $currentYear = date("Y");
                    for ($year = $currentYear; $year >= 1900; $year--) {
                        $selected = ($year == $selectedYear) ? 'selected' : '';
                        echo "<option value='$year' {$selected}>$year</option>";
                    }
                ?>
            </select>
            
            <label class="product-create-label" for="product-page">Số trang:</label><br>
            <input class="product-create-numeric" type="number" name="product_page" id="product-page-input" placeholder="Số trang" value="<?= htmlspecialchars($product['SoTrang']) ?>" min="5">

            <label class="product-create-label" for="product-size">Kích thước:</label><br>
            <input class="product-create-text" type="text" name="product_size" id="product-size-input" value="<?= htmlspecialchars($product['KichThuoc']) ?>" placeholder="Kích thước">

            <label class="product-create-label" for="product-description">Mô tả:</label><br>
            <textarea name="product_description" id="product-description-input" placeholder="Mô tả sản phẩm"><?= htmlspecialchars($product['MoTaChiTiet']) ?></textarea>

            <label class="product-create-label" for="product-image">Hình ảnh:</label><br>
            <input class="product-create-text" type="file" name="product_image" id="product-image-input" accept="image/*">
        
            <button type="submit" class="product-create-Btns" id="acceptEditProductBtn">Áp dụng thay đổi</button>
            <button type="button" class="product-create-Btns" id="cancelProductBtn" onclick="location.href='?page=product&action=index&current_page=<?= $currentPage ?>'">Hủy</button>

        </form>
    </div>
</div>