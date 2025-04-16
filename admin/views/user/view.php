<script src="/project-Web2/admin/assets/js/user.js"></script>

<div class="admin-wrapper" id="admin-wrapper-user-view">
    <div class="user-form">
        <form id="userviewform">
            <div class="admin-header">
                <h2>Chi tiết tài khoản</h2>
            </div>
            <div class="form-group-user" id="user-view-form">
                <div class="form-user-name" id="user-view-name">
                    <label for="name">Họ tên</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['TenND']) ?>" readonly>
                </div>

                <div class="form-user-username" id="user-view-username">
                    <label for="username">Tên tài khoản</label>
                    <input type="text" id="username" name="username" value="<?= htmlspecialchars($account['TenTK']) ?>" readonly>
                </div>

                <div class="form-user-email" id="user-view-email">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['EmailND']) ?>" readonly>
                </div>

                <div class="form-user-address" id="user-view-address">
                    <label for="address">Địa chỉ</label>
                    <input type="text" id="address" name="address" value="<?= htmlspecialchars($user['DcND']) ?>" readonly>
                </div>

                <div class="form-user-phone" id="user-view-phone">
                    <label for="phone">Số điện thoại</label>
                    <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($user['SDT']) ?>" pattern="0[0-9]{9}" readonly>
                </div>

                <div class="form-user-birthdate" id="user-view-birthdate">
                    <label for="birthdate">Ngày sinh</label>
                    <input type="date" id="birthdate" name="birthdate" value="<?= htmlspecialchars($user['NgSinhND']) ?>" readonly>
                </div>
                
                <?php
                    $genderText = ($user['GioiTinhND'] == 1) ? 'Nam' : 'Nữ';
                ?>
                <div class="form-user-gender" id="user-view-gender">
                    <label>Giới tính</label>
                    <input type="text" name="gender" id="gender" value="<?= $genderText ?>" readonly>
                </div>

                <div class="form-user-image" id="user-view-image">
                    <label>Hình ảnh</label>
                    <?php if (!empty($imagePath)): ?>
                        <img src="<?= htmlspecialchars($imagePath) ?>" alt="User Image" style="max-width: 200px; height: auto;">
                    <?php else: ?>
                        <p>Không có hình ảnh</p>
                    <?php endif; ?>
                </div>

                <?php
                    $roleText = 
                    ($account['LoaiTK'] == 1) ? 'Quản lý' :
                    (($account['LoaiTK'] == 2) ? 'Nhân viên' :
                    (($account['LoaiTK'] == 3) ? 'Admin' : 'Người dùng'));
                ?>
                <div class="form-user-role" id="user-view-role">
                    <label for="role">Loại tài khoản</label>
                    <input type="text" name="role" id="role" value="<?= $roleText ?>" readonly>
                </div>

                <span class="form-user-confirm">
                    <button type="button" onclick="location.href='?page=user&action=index'" id="btnusercancel">Đóng</button>
                </span>
            </div>
        </form>
    </div>
</div>