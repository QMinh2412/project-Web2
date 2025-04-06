<script src="/WebProject/admin/assets/js/product.js"></script>

<div class="admin-wrapper">
    <div class="admin-header" id="product-header">
        <h2 id="product-header-title">Thêm sản phẩm</h2>
        <form id="create-product-form" method="POST" action="?page=product&action=create">
            <label class="product-create-label" for="product-name">Tên sản phẩm:</label><br>
            <input class="product-create-text" type="text" name="product_name" id="product-name-input" placeholder="Tên sản phẩm" required>

            <label class="product-create-label" for="product-category">Thể loại:</label><br>
            <select class="product-create-dropdown" name="product_category" id="product-categorbr>y-input">
                <option value="1">Tiểu thuyết</option> 
                <option value="2">Kinh dị</option>
                <option value="3">Giáo dục</option>
                <option value="4">Manga</option>
                <option value="5">Truyện tranh</option>
                <option value="6">Lãng mạn</option>
                <option value="7">Thiếu nhi</option>
            </select>
            
            <div class="product-suggestion-container" id="product-author-container">
                <label class="product-create-label" for="product-author">Tác giả:</label><br>
                <input class="product-create-text" type="text" name="product_author" id="product-author-input" placeholder="Tác giả" autocomplete="off" required>
                <!-- <div class="product-suggestion-wrapper" id="product-author-suggestion-wrapper">
                    <ul class="product-suggestion-list" id="product-author-suggestion-list">
                        
                    </ul>
                </div> -->
            </div>

            <div class="product-suggestion-container" id="product-publisher-container">
                <label class="product-create-label" for="product-publisher">Nhà xuất bản:</label><br>
                <input class="product-create-text" type="text" name="product_publisher" id="product-publisher-input" placeholder="Nhà xuất bản" autocomplete="off" required>
                <!-- <div class="product-suggestion-wrapper" id="product-publisher-suggestion-wrapper">
                    //
                </div> -->
            </div>

            <div class="product-suggestion-container" id="product-provider-container">
                <label class="product-create-label" for="product-provider">Nhà cung cấp:</label><br>
                <input class="product-create-text" type="text" name="product_provider" id="product-provider-input" placeholder="Nhà cung cấp" autocomplete="off" required>
                <!-- <div class="product-suggestion-wrapper" id="product-provider-suggestion-wrapper">
                    //
                </div> -->
            </div>

            <label class="product-create-label" for="product-quantity">Số lượng:</label><br>
            <input class="product-create-numeric" type="number" name="product_quantity" id="product-quantity-input" placeholder="Số lượng" min="0" required>

            <label class="product-create-label" for="product-price">Giá:</label><br>
            <input class="product-create-numeric" type="number" name="product_price" id="product-price-input" placeholder="Giá" min="10000" required>

            <label class="product-create-label" for="product-year">Năm xuất bản:</label><br>
            <select class="product-create-dropdown" name="product_year" id="product-year-input" required>
                <?php
                    $currentYear = date("Y");
                    for ($year = $currentYear; $year >= 1900; $year--) {
                        echo "<option value='$year'>$year</option>";
                    }
                ?>
            </select>
 
            <label class="product-create-label" for="product-page">Số trang:</label><br>
            <input class="product-create-numeric" type="number" name="product_page" id="product-page-input" placeholder="Số trang" min="5">

            <label class="product-create-label" for="product-size">Kích thước:</label><br>
            <input class="product-create-text" type="text" name="product_size" id="product-size-input" placeholder="Kích thước">

            <label class="product-create-label" for="product-description">Mô tả:</label><br>
            <textarea name="product_description" id="product-description-input" placeholder="Mô tả sản phẩm"></textarea>

            <label class="product-create-label" for="product-image">Hình ảnh:</label><br>
            <input class="product-create-text" type="file" name="product_image" id="product-image-input" accept="image/*" required>
        
            <button type="submit" class="product-create-Btns" id="createProductBtn">Áp dụng thay đổi</button>
            <button type="button" class="product-create-Btns" id="cancelProductBtn" onclick="location.href='?page=product&action=index'">Hủy</button>
        </form>
    </div>
</div>