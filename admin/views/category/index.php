<div class="admin-wrapper">
    <div class="admin-header" id="category-header">
        <h2>Danh mục sách</h2>
        <button onclick="location.href='?page=category&action=create'" class="btn btn-primary" id="addCategoryBtn"><i class='bx bxs-duplicate' ></i>Thêm danh mục</button>
    </div>
    <table class="admin-list-container">
        <thead class="admin-list-header">
            <tr class="admin-list-header-content">
                <th id="category-order">STT</th>
                <th id="category-name">Tên thể loại</th>
                <th id="category-features">Chức năng</th>
            </tr>
        </thead>
        <tbody class="admin-list-body">
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td class="admin-list-body-content-num" id="category-order"><?= htmlspecialchars($category['MaLoai']) ?></td>
                    <td class="admin-list-body-content-other" id="category-name"><?= htmlspecialchars($category['TenLoai']) ?></td>
                    <td class="admin-list-body-content-num" id="category-feature">
                        <button class="btn btn-primary" id="editCategoryBtn" onclick="location.href='?page=category&action=edit&id=<?= htmlspecialchars($category['MaLoai']) ?>'">
                            <i class='bx bx-edit'></i>
                            Sửa</button>
                        <button class="btn btn-danger" id="deleteCategoryBtn" onclick="if(confirm('Bạn có chắc chắn muốn xóa thể loại <?= htmlspecialchars($category['TenLoai'])?>?')) location.href='?page=category&action=delete&id=<?= htmlspecialchars($category['MaLoai']) ?>'">
                            <i class='bx bx-trash' ></i>
                            Xóa</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
