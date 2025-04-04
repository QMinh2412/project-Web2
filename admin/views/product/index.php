<div class="admin-wrapper">
    <div class="admin-header" id="product-header">
        <h2>Sản phẩm</h2>
        <!-- <a href="?page=category&action=create" class="btn btn-primary" id="addCategoryBtn">Thêm danh mục</a> -->
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
            <?php foreach ($products as $product):
                    switch ($product['MaLoai']) {
                        case 1: 
                            $category = "Tiểu thuyết";
                            break;
                        case 2:
                            $category = "Kinh dị";
                            break;
                        case 3:
                            $category = "Giáo dục";
                            break;
                        case 4:
                            $category = "Manga";
                            break;
                        case 5:
                            $category = "Truyện tranh";
                            break;
                        case 6:
                            $category = "Lãng mạn";
                            break;
                        default:
                            $category = "Thiếu nhi";
                            break;
                    }
                    switch ($product['TinhTrang']) {
                        case 0:
                            $status = "Ngừng bán";
                            break;
                        case 1:
                            $status = "Đang bán";
                            break;
                        default:
                            $status = "N/A";
                            break;
                    }
                ?>
                <tr>
                    <td class="admin-list-body-content-num" id="product-order"><?= htmlspecialchars($product['MaSach']) ?></td>
                    <td class="admin-list-body-content-other" id="product-name"><?= htmlspecialchars($product['TenSach']) ?></td>
                    <td class="admin-list-body-content-num" id="product-category"><?= htmlspecialchars($category) ?></td>
                    <td class="admin-list-body-content-num" id="product-quantity"><?= htmlspecialchars($product['SoLgTon']) ?></td>
                    <td class="admin-list-body-content-num" id="product-price"><?= htmlspecialchars($product['GiaBan']) ?></td>
                    <td class="admin-list-body-content-num" id="product-status"><?= htmlspecialchars($status)?></td>
                    <td class="admin-list-body-content-num" id="product-features">
                        <button class="btn btn-primary" id="editCategoryBtn" onclick="location.href='?page=category&action=edit&id=<?= htmlspecialchars($category['MaLoai']) ?>'">
                            <i class='bx bx-edit'></i>
                            Sửa</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
