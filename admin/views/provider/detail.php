<div class="admin-wrapper" id="admin-wrapper-provider-detail">
    <div class="admin-header" id="provider-header">
        <h2>Chi tiết nhà cung cấp</h2>
        <div id="create-provider-form">
            <label class="provider-create-label" for="provider-id">ID nhà cung cấp:</label><br>
            <input class="provider-create-text" type="text" name="product_id" id="provider-id-input" value="<?= htmlspecialchars(number_format($provider['MaNCC'])) ?>" readonly>
        
            <label class="provider-create-label" for="provider-name">Tên nhà cung cấp:</label><br>
            <input class="provider-create-text" type="text" name="product_name" id="provider-name-input" value="<?= htmlspecialchars($provider['TenNCC']) ?>" readonly>

            <label class="provider-create-label" for="provider-address">Địa chỉ:</label><br>
            <input class="provider-create-text" type="text" name="product_address" id="provider-address-input" value="<?= htmlspecialchars($provider['DcNCC'] ?: 'N/A') ?>" readonly>

            <label class="provider-create-label" for="provider-email">Email:</label><br>
            <input class="provider-create-text" type="text" name="product_email" id="provider-email-input" value="<?= htmlspecialchars($provider['EmailNCC']) ?: 'N/A' ?>" readonly>

            <button type="button" class="provider-create-Btns" id="closeProviderBtn" onclick="location.href='?page=provider&action=index&current_page=<?= $currentPage ?>'">
                <i class='bx bx-check'></i>
                Xong
            </button>
        </div>
    </div>
</div>