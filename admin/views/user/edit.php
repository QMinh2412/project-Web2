<div class="admin-wrapper">
    <div class="user-form">
        <form id="usereditform" method="POST" action="?page=user&action=edit&id=<?= $user['MaND'] ?>" enctype="multipart/form-data">
            <div class="admin-header">
                <h2>Chỉnh sửa tài khoản</h2>
            </div>
            <div class="form-group-user" id="user-edit-form">
                <div class="form-user-name" id="user-edit-name">
                    <label for="name">Họ tên</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['TenND']) ?>" required>
                </div>

                <div class="form-user-username" id="user-edit-username">
                    <label for="username">Tên tài khoản</label>
                    <input type="text" id="username" name="username" value="<?= htmlspecialchars($account['TenTK']) ?>" required>
                </div>

                <div class="form-user-email" id="user-edit-email">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['EmailND']) ?>" required>
                </div>

                <div class="form-user-password" id="user-edit-password">
                    <label for="password">Thay đổi mật khẩu</label>
                    <input type="password" name="password" id="password" placeholder="Nhập mật khẩu mới">
                </div>

                <div class="form-user-address" id="user-edit-address">
                    <label for="address">Địa chỉ</label>
                    <input type="text" id="address" name="address" value="<?= htmlspecialchars($user['DcND']) ?>" required>
                </div>

                <div class="form-user-phone" id="user-edit-phone">
                    <label for="phone">Số điện thoại</label>
                    <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($user['SDT']) ?>" pattern="0[0-9]{9}" required>
                </div>

                <div class="form-user-birthdate" id="user-edit-birthdate">
                    <label for="birthdate">Ngày sinh</label>
                    <input type="date" id="birthdate" name="birthdate" value="<?= htmlspecialchars($user['NgSinhND']) ?>" max="<?= date('Y-m-d') ?>" required>
                </div>
                
                <?php
                    $genderText = ($user['GioiTinhND'] == 1) ? 'Nam' : 'Nữ';
                ?>
                <div class="form-user-gender" id="user-edit-gender">
                    <label>Giới tính</label>
                    <input type="text" name="gender" id="gender" value="<?= $genderText ?>" readonly>
                    <label>Thay đổi giới tính</label>
                    <div class="gender-options">
                        <label>
                            <input type="radio" name="gender" value="1" checked> Nam
                        </label>
                        <label>
                            <input type="radio" name="gender" value="0"> Nữ
                        </label>
                    </div>
                </div>

                <div class="form-user-image" id="user-edit-image">
                    <label>Hình ảnh hiện tại</label>
                    <?php if (!empty($imagePath)): ?>
                        <img src="<?= htmlspecialchars($imagePath) ?>" alt="User Image" style="max-width: 200px; height: auto;">
                    <?php else: ?>
                        <p>Không có hình ảnh</p>
                    <?php endif; ?>

                    <label for="image">Chọn hình ảnh mới</label>
                    <input type="file" id="image" name="image" accept="image/*">
                </div>      

                <?php
                    $roleText = 
                    ($account['LoaiTK'] == 1) ? 'Quản lý' :
                    (($account['LoaiTK'] == 2) ? 'Nhân viên' :
                    (($account['LoaiTK'] == 3) ? 'Admin' : 'Người dùng'));
                ?>

                <div class="form-user-role" id="user-edit-role">
                    <label for="role">Thay đổi loại tài khoản</label>
                    <span>Hiện tại: <?= $roleText ?></span>
                    <select id="role" name="role">
                        <option value="0">Người dùng</option>
                        <option value="1">Quản lý</option>
                        <option value="2">Nhân viên</option>
                        <option value="3">Admin</option>
                    </select>
                </div>

                <span class="form-user-confirm">
                    <button type="submit" id="btnuseredit">Lưu</button>
                    <button type="button" onclick="location.href='?page=user&action=index'" id="btnusercancel">Đóng</button>
                </span>
            </div>
        </form>
    </div>
</div>