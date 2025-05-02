<div class="admin-wrapper">
    <div class="admin-header" id="review-header">
        <h2>Đánh giá</h2>
    </div>
    <table class="admin-list-container" id="review-list-container">
        <thead class="admin-list-header" id="review-list-header">
            <tr class="admin-list-header-content" id="review-list-header-content">
                <th id="review-order">STT</th>
                <th id="review-book">Tên sách</th>
                <th id="review-name">Tên khách hàng</th>
                <th id="review-content">Nội dung</th>
                <th id="review-date">Ngày đánh giá</th>
                <th id="review-features">Chức năng</th>
            </tr>
        </thead>
        <tbody class="admin-list-body" id="review-list-body">
            <?php $stt = 1; ?>
            <?php foreach ($reviews as $review): ?>
                <tr class="admin-list-body-content">
                    <td class="admin-list-body-content-num" id="review-order" data-label="STT"><?= $stt++ ?></td>
                    <td class="admin-list-body-content-other" id="review-book" data-label="Tên sách"><?= htmlspecialchars($review['TenSach']) ?></td>
                    <td class="admin-list-body-content-other" id="review-name" data-label="Tên khách hàng"><?= htmlspecialchars($review['TenKH']) ?></td>
                    <td class="admin-list-body-content-other" id="review-content" data-label="Nội dung"><?= htmlspecialchars($review['NoiDung']) ?></td>
                    <td class="admin-list-body-content-other" id="review-date" data-label="Ngày đánh giá"><?= date('d/m/Y', strtotime($review['NgayViet'])) ?></td>
                    <td id="review-features" data-label="Chức năng">
                        <button class="btn-review" onclick="window.location.href='/project-Web2/user/index.php?page=detail&action=show_detail&id_book=<?=$review['MaSach'] ?>'" id="detailReviewBtn" title="Xem chi tiết">
                            <i class="bx bx-info-circle"></i>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="review-pagination">
        <a href="?page=review&current_page=<?= $pagination['currentPage'] - 1 ?>" 
            class="<?= $pagination['currentPage'] == 1 ? 'disabled' : '' ?>"><i class='bx bx-chevron-left'></i></a>
        
        <?php for ($i = 1; $i <= $pagination['totalPages']; $i++): ?>
            <a href="?page=review&current_page=<?= $i ?>"
               class="<?= $i == $pagination['currentPage'] ? 'active' : '' ?>">
               <?= $i ?>
            </a>
        <?php endfor; ?>

        <a href="?page=review&current_page=<?= $pagination['currentPage'] + 1 ?>" 
            class="<?= $pagination['currentPage'] == $pagination['totalPages'] ? 'disabled' : '' ?>"><i class='bx bx-chevron-right' ></i></a>
    </div>
</div>
</div>
