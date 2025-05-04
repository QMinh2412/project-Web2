<table class="admin-list-container">
        <thead class="admin-list-header">
            <tr class="admin-list-header-content">
                <th id="user-stt">STT</th>
                <th id="user-name">Họ tên</th>
                <th id="user-email">Email</th>
                <th id="user-role">Loại tài khoản</th>
                <th id="user-status">Tình trạng</th>
                <th id="user-action">Chức năng</th>
            </tr>
        </thead>
        <tbody class="admin-list-body">
            <?php $stt = ($pagination['currentPage'] - 1) * $pagination['limit'] + 1; ; ?>
            <?php foreach ($users as $user): ?>
                <tr class="admin-list-body-content">
                    <td class="admin-list-body-content-num" id="user-stt"><?= $stt++?></td>
                    <td class="admin-list-body-content-other" id="user-name"><?= htmlspecialchars($user['TenND']) ?></td>
                    <td class="admin-list-body-content-other" id="user-email"><?= htmlspecialchars($user['EmailND']) ?></td>
                    <td class="admin-list-body-content-other" id="user-role">
                    <?= ($user['LoaiTK'] == 1) ? 'Quản lý' : 
                        (($user['LoaiTK'] == 2) ? 'Nhân viên' : 
                        (($user['LoaiTK'] == 3) ? 'Admin' : 'Người dùng')) ?>
                    </td>
                    <td class="admin-list-body-content-other" id="user-status">
                        <label class="switch">
                            <input type="checkbox" data-id="<?= $user['MaND'] ?>" <?= $user['TinhTrang'] == 1 ? 'checked' : '' ?> onchange="location.href='?page=user&action=lock&id=<?= $user['MaND'] ?>'"/>
                            <span class="slider"  title="<?= $user['TinhTrang'] == 1 ? 'Khóa tài khoản' : 'Mở khóa tài khoản' ?>"></span>
                        </label>
                    </td>
                    <td class="admin-list-body-content-other" id="user-action">
                        <button class="btn-user btn-delete" onclick="return confirmDelete(<?= $user['MaND'] ?>)" title="Xóa"><i class='bx bx-trash'></i></button>
                        <button class="btn-user btn-detail" onclick="location.href='?page=user&action=view&id=<?= $user['MaND'] ?>'" title="Xem chi tiết"><i class='bx bx-info-circle'></i></button>
                        <button class="btn-user btn-edit" onclick="location.href='?page=user&action=edit&id=<?= $user['MaND'] ?>'" title="Chỉnh sửa"><i class='bx bx-edit'></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>