<div class="admin-wrapper">
    <div class="admin-header">
        <h2>Tài khoản</h2>
        
    </div>
    <table class="admin-list-container">
        <thead class="admin-list-header">
            <tr class="admin-list-header-content">
                <th id="user-stt">STT</th>
                <th id="user-name">Họ tên</th>
                <th id="user-email">Email</th>
                <th id="user-role">Loại tài khoản</th>
                <th id="user-status">Tình trạng</th>
                <th id="user-action"><button class="btn-user btn-add" onclick="location.href='?page=user&action=create'"><i class='bx bxs-user-plus' ></i>Thêm tài khoản</button></th>
            </tr>
        </thead>
        <tbody class="admin-list-body">
            <?php foreach ($users as $user): ?>
                <tr class="admin-list-body-content">
                    <td class="admin-list-body-content-num" id="user-stt"><?= htmlspecialchars($user['MaND']) ?></td>
                    <td class="admin-list-body-content-other" id="user-name"><?= htmlspecialchars($user['TenND']) ?></td>
                    <td class="admin-list-body-content-other" id="user-role"><?= htmlspecialchars($user['EmailND']) ?></td>
                    <td class="admin-list-body-content-other" id="user-status">
                        <?= ($user['LoaiTK'] == 1) ? 'Admin' : (($user['LoaiTK'] == 2) ? 'Editor' : 'User') ?>
                    </td>
                    <td class="admin-list-body-content-other" id="user-status">
                        <?= ($user['TinhTrang'] == 1) ? 'Active' : 'Disabled' ?>
                    </td>
                    <td class="admin-list-body-content-other" id="user-action">
                        <button class="btn-user btn-detail" onclick="location.href='?page=user&action=view&id=<?= $user['MaND'] ?>'"><i class='bx bxs-detail'></i>Detail</button>
                        <button class="btn-user btn-edit" onclick="location.href='?page=user&action=edit&id=<?= $user['MaND'] ?>'"><i class='bx bx-edit'></i>Edit</button>
                        <button class="btn-user btn-ban" onclick="location.href='?page=user&action=delete&id=<?= $user['MaND'] ?>'"><i class='bx bxs-lock-alt' ></i>Ban</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>