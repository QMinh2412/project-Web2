<div class="admin-wrapper">
    <div class="admin-header" id="category-header">
        <h2>Danh mục sách</h2>
        <a href="?page=category&action=create" class="btn btn-primary" id="addCategoryBtn">Thêm danh mục</a>
    </div>
    <table class="admin-list-container">
        <thead class="admin-list-header">
            <tr class="admin-list-header-content">
                <th id="category-order">STT</th>
                <th id="category-name">Tên thể loại</th>
                <!-- <th id="category-quantity">Số lượng</th> -->
                <th id="category-features">Chức năng</th>
            </tr>
        </thead>
        <tbody class="admin-list-body">
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td class="admin-list-body-content-num" id="category-order"><?= htmlspecialchars($category['MaLoai']) ?></td>
                    <td class="admin-list-body-content-other" id="category-name"><?= htmlspecialchars($category['TenLoai']) ?></td>
                    <!-- <td class="admin-list-body-content-num">N/A</td> -->
                    <td class="admin-list-body-content-num">N/A</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
