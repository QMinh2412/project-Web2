<div class="admin-wrapper">
    <div class="admin-header">
        <h2>Đánh giá</h2>
    </div>
    <div>
        Chèn chức năng tìm kiếm 
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
            <tr>
                <td class="admin-list-body-content-num" id="product-order"></td>
                <td class="admin-list-body-content-other" id="product-name"></td>
                <td class="admin-list-body-content-num" id="product-category"></td>
                <td class="admin-list-body-content-num" id="product-quantity"></td>
                <td class="admin-list-body-content-num" id="product-price"><</td>
                <td class="admin-list-body-content-num" id="product-status"></td>
            </tr>
        </tbody>
    </table>

    <!-- Phân trang -->
    <div class="review-pagination">
        <a href="?page=review&current_page=<?= $pagination['currentPage'] - 1 ?>" 
            class="<?= $pagination['currentPage'] == 1 ? 'disabled' : '' ?>">
            <i class='bx bx-chevron-left'></i>
        </a>
        
        <?php for ($i = 1; $i <= $pagination['totalPages']; $i++): ?>
            <a href="?page=review&current_page=<?= $i ?>"
               class="<?= $i == $pagination['currentPage'] ? 'active' : '' ?>">
               <?= $i ?>
            </a>
        <?php endfor; ?>

        <a href="?page=review&current_page=<?= $pagination['currentPage'] + 1 ?>" 
            class="<?= $pagination['currentPage'] == $pagination['totalPages'] ? 'disabled' : '' ?>">
            <i class='bx bx-chevron-right'></i>
        </a>
    </div>
</div>
