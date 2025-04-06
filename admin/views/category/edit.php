<div class="admin-wrapper">
    <div class="admin-header" id="category-header">
        <h2>Sửa danh mục</h2>
        <form method="POST" action="?page=category&action=edit&id=<?= htmlspecialchars($category['MaLoai']) ?>">
            <input type="text" name="category_name" id="category-name-input" value="<?= htmlspecialchars($category['TenLoai']) ?>" required>
            <div class="category-create-Btn-div">
                <button type="submit" class="category-create-Btns" id="createCategoryBtn">Áp dụng thay đổi</button>
                <button type="button" class="category-create-Btns" id="cancelCategoryBtn" onclick="location.href='?page=category&action=index'">Hủy</button>
            </div>
        </form>
    </div>
</div>