<?php
    switch ($import['TinhTrang']) {
        case 0: 
            $importStatus = 'Chưa hoàn thành';
            break;
        case 1:
            $importStatus = 'Đã hoàn thành';
            break;
        default:
            $importStatus = 'N/A';
            break;
    }
?>

<script src="/project-Web2/admin/assets/js/import.js"></script>
<div class="admin-wrapper" id="import-detail-wrapper">
    <div class="admin-header" id="import-header">
        <h2>Chi tiết phiếu nhập</h2>
    </div>

    <div id="import-detail-form">
        <div class="general-import-info" id="import-id-div">
            <label class="import-create-label" for="import-id">ID phiếu nhập:</label><br>
            <input class="import-create-text" type="text" name="import_id" id="import-id-input" value="<?= htmlspecialchars(number_format($import['MaPhNhap'])) ?>" readonly>
        </div>

        <div class="general-import-info" id="import-status-div">
            <label class="import-create-label" for="import-status">Trạng thái:</label><br>
            <input class="import-create-text" type="text" name="import_status" id="import-status-input" value="<?= htmlspecialchars($importStatus) ?>" readonly>
        </div>

        <div class="general-import-info-full" id="import-date-div">
            <label class="import-create-label" for="import-date">Ngày lập phiếu:</label><br>
            <input class="import-create-text" type="text" name="import_date" id="import-date-input" value="<?= date_format(new DateTime($import['NgNhap']), "d/m/Y") ?>" readonly>
        </div>

        <div class="general-import-info" id="import-provider-div">
            <label class="import-create-label" for="provider-name">Tên nhà cung cấp:</label><br>
            <input class="import-create-text" type="text" name="provider_name" id="provider-name-input" value="<?= htmlspecialchars($provider['TenNCC']) ?>" readonly>
        </div>

        <div class="general-import-info" id="import-provider-div">
            <label class="import-create-label" for="provider-email">Email nhà cung cấp:</label><br>
            <input class="import-create-text" type="text" name="provider_email" id="provider-email-input" value="<?= htmlspecialchars($provider['EmailNCC']) ?>" readonly>
        </div>

        <div class="general-import-info-full" id="import-provider-div">
            <label class="import-create-label" for="provider-address">Địa chỉ nhà cung cấp:</label><br>
            <input class="import-create-text" type="text" name="provider_address" id="provider-address-input" value="<?= htmlspecialchars($provider['DcNCC']) ?>" readonly>
        </div>
    </div>

    <p class="import-create-label" id="importDetailHeader">Danh sách sản phẩm</p>
    <table class="admin-list-container">
        <thead class="admin-list-header">
            <tr class="admin-list-header-content">
                <th id="import-detail-product-order">STT</th>
                <th id="import-detail-product-name">Tên sản phẩm</th>
                <th id="import-detail-product-category">Thể loại</th>
                <th id="import-detail-product-number">Số lượng</th>
                <th id="import-detail-product-iPrice">Giá nhập</th>
            </tr>
        </thead>
        <tbody class="admin-list-body">
            <?php
                $importDetail_order = 1;
                $totalValue = 0;
                foreach ($details as $index => $detail):
                    $totalOfProduct = $detail['GiaNhap'] * $detail['SoLgNhap'];
                    $totalValue += $totalOfProduct;
            ?>
            <tr>
                <td class="admin-list-body-content-num" id="import-detail-product-order"><?= $importDetail_order++ ?></td>
                <td class="admin-list-body-content-other" id="import-detail-product-name"><?= htmlspecialchars($detail['TenSach']) ?></td>
                <td class="admin-list-body-content-num" id="import-detail-product-category"><?= htmlspecialchars($detail['TenLoai']) ?></td>
                <td class="admin-list-body-content-num" id="import-detail-product-number"><?= htmlspecialchars(number_format($detail['SoLgNhap'])) ?></td>
                <td class="admin-list-body-content-num" id="import-detail-product-iPrice"><?= htmlspecialchars(number_format($detail['GiaNhap'])) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div id="importDetailTotalValueDiv">
        <div id="importDetailTotalValue">
            <label for="import-total-value" id="import-total-value-label">Tổng chi phí:</label>
            <input type="text" name="import_total_value" id="import-total-value-input" value="<?= htmlspecialchars(number_format($totalValue)) ?>" readonly>
        </div>
    </div>

    <div>
        <button type="button" class="import-detail-close-Btns" id="closeImportDetailBtn" onclick="location.href='?page=import&action=index&current_page=<?= $currentPage ?>'">
            <i class='bx bx-check'></i>
            Xong
        </button>
        <button type="button" class="import-detail-export-Btns" id="exportDetailBtn" onclick="exportDetail()">
            <i class='bx bx-download'></i>
            In
        </button>
    </div>
</div>