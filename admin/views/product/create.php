<div class="admin-wrapper">
    <div class="admin-header" id="product-header">
        <h2>Thêm sản phẩm</h2>
        <form method="POST" action="?page=product&action=create">
            <label for="product-name">Tên sản phẩm:</label><br>
            <input type="text" name="product_name" id="product-name-input" placeholder="Tên sản phẩm" required>
            <label for="product-category">Thể loại:</label><br>
            <select name="product_category" id="product-categorbr>y-input">
                <option value="1">Tiểu thuyết</option> 
                <option value="2">Kinh dị</option>
                <option value="3">Giáo dục</option>
                <option value="4">Manga</option>
                <option value="5">Truyện tranh</option>
                <option value="6">Lãng mạn</option>
                <option value="7">Thiếu nhi</option>
            </select>
            <label for="product-quantity">Số lượng:</label><br>
            <input type="number" name="product_quantity" id="product-quantity-input" placeholder="Số lượng" required>
            <label for="product-price">Giá:</label><br>
            <input type="number" name="product_price" id="product-price-input" placeholder="Giá" required>
            <label for="product-year">Năm xuất bản:</label><br>
            <input type="number" name="product_year" id="product-year-input" placeholder="Năm xuất bản" required>
            <label for="product-page">Số trang:</label><br>
            <input type="number" name="product_page" id="product-page-input" placeholder="Số trang" required>
            <label for="product-size">Kích thước:</label><br>
            <input type="text" name="product_size" id="product-size-input" placeholder="Kích thước" required>
            <label for="product-description">Mô tả:</label><br>
            <textarea name="product_description" id="product-description-input" placeholder="Mô tả sản phẩm" required></textarea>
        </form>
    </div>
</div>