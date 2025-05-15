<div class="admin-wrapper" id="admin-wrapper-provider-create">
    <div class="admin-header" id="provider-header">
        <h2 id="provider-header-title">Thêm nhà cung cấp</h2>
        <form id="create-provider-form" method="POST" action="?page=provider&action=create">
            <label class="provider-create-label" for="provider-name">Tên:</label><br>
            <input class="provider-create-text" type="text" name="provider_name" id="provider-name-input" placeholder="Tên" required>
            <label class="provider-create-label" for="provider-address">Địa chỉ:</label><br>
            <input class="provider-create-text" type="text" name="provider_address" id="provider-address-input" placeholder="Địa chỉ">
            <label class="provider-create-label" for="provider-email">Email:</label><br>
            <input class="provider-create-text" type="email" name="provider_email" id="provider-email-input" placeholder="Email">
            <button type="submit" class="provider-create-Btns" id="createProviderBtn">
                <i class='bx bx-check'></i>
                Áp dụng thay đổi
            </button>
            <button type="button" class="provider-create-Btns" id="cancelProviderBtn" onclick="location.href='?page=provider&action=index&current_page=<?= $currentPage ?>'">
                <i class='bx bx-x'></i> 
                Hủy
            </button>
        </form>
    </div>
</div>