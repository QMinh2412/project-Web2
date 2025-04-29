<script src="/project-Web2/admin/assets/js/import.js"></script>

<form method="POST">
    <div class="admin-wrapper">
        <div class="admin-header" id="import-header">
            <h2>Thông tin nhập sách</h2>
        </div>
        <div class="order-container">
            <div class="order-form-group">
                <label for="import-create-provider">Nhà cung cấp</label>
                <input type="text" id="import-create-provider" value="<?= htmlspecialchars($provider['TenNCC']) ?>" readonly>
                <input type="hidden" name="import_provider" value="<?= htmlspecialchars($provider['MaNCC']) ?>">
            </div>
            <div class="order-form-group">
                <label for="import-create-profit">Chiến khấu</label>
                <input type="text" id="import-create-profit" name="import_profit" value="<?= htmlspecialchars($profit) ?>" readonly>
            </div>
        </div>

        <button type="button" class="import-create-product-Btns" id="createProductImportBtn">
            <i class='bx bx-plus'></i>
            Thêm
        </button>

        <table class="admin-list-container">
            <thead class="admin-list-header">
                <tr class="admin-list-header-content">
                    <th></th>
                    <th id="import-create-product-order">STT</th>
                    <th id="import-create-product-name">Tên sách</th>
                    <th id="import-create-product-category">Thể loại</th>
                    <th id="import-create-product-quanity">Số lượng</th>
                    <th id="import-create-product-iPrice">Giá nhập</th>
                </tr>
            </thead>
            <tbody class="admin-list-body">

            </tbody>
        </table>
        <!-- HIDDEN input chứa dữ liệu danh sách -->
        <input type="hidden" name="products_list" id="productsList">

        <button type="submit" id="import-add-confirm-btn">Xác nhận</button>
    </div>
</form>

<div id="addBookModal" class="addBookmodal">
    <div class="import-add-book-modal-content">
        <span class="import-close-btn" onclick="closeAddBookModal()">&times;</span>
        <h3>Thêm sách vào phiếu nhập</h3>
        <label>Tên sách:</label>
        <select id="importAddBookSelect">
            <option value="0">Chọn tên sách</option>
            <?php foreach ($products as $product): ?>
                <option value="<?= $product['MaSach'] ?>" data-name="<?= htmlspecialchars($product['TenSach']) ?>" data-category="<?= $categoryMap[$product['MaLoai']] ?>" data-id="<?= $product['MaSach'] ?>">
                    <?= htmlspecialchars($product['TenSach']) ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <label>Số lượng:</label>
        <input type="number" id="importAddBookQuantity" min="1"><br>

        <label>Giá nhập:</label>
        <input type="number" id="importAddBookPrice" min="0"><br>

        <button onclick="addBookToTable()">Xác nhận</button>
    </div>
</div>