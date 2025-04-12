<script src="/project-Web2/admin/assets/js/user.js"></script>

<div class="admin-wrapper">
    <div class="user-form">
        <form id="useraddform" method="POST" action="?page=user&action=create" enctype="multipart/form-data">
            <div class="admin-header">
                <h2>Thêm tài khoản</h2>
            </div>
            <div class="form-group-user">
                <div class="form-user-name" id="user-add-name">
                    <label for="name">Họ tên</label>
                    <input type="text" id="name" name="name" placeholder="Nhập họ tên" required>
                </div>

                <div class="form-user-username" id="user-add-username">
                    <label for="username">Tên tài khoản</label>
                    <input type="text" id="username" name="username" placeholder="Nhập tên tài khoản" required>
                </div>

                <div class="form-user-email" id="user-add-email">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Nhập email" required>
                </div>

                <div class="form-user-password" id="user-add-password">
                    <label for="password">Mật khẩu</label>
                    <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" required>
                </div>

                <div class="form-user-address" id="user-add-address">
                    <label for="address">Địa chỉ</label>
                    <input type="text" id="address" name="address" placeholder="Nhập địa chỉ" required>
                </div>

                <div class="form-user-phone" id="user-add-phone">
                    <label for="phone">Số điện thoại</label>
                    <input type="tel" id="phone" name="phone" placeholder="Nhập số điện thoại" pattern="0[0-9]{9}" required>
                </div>

                <div class="form-user-birthdate" id="user-add-birthdate">
                    <label for="birthdate">Ngày sinh</label>
                    <input type="date" id="birthdate" name="birthdate" placeholder="Nhập ngày sinh" max="<?= date('Y-m-d') ?>" required>
                </div>

                <div class="form-user-gender" id="user-add-gender">
                    <label>Giới tính</label>
                    <div class="gender-options">
                        <label>
                            <input type="radio" name="gender" value="1" checked> Nam
                        </label>
                        <label>
                            <input type="radio" name="gender" value="0"> Nữ
                        </label>
                    </div>
                </div>

                <div class="form-user-image" id="user-add-image">
                    <label for="image">Hình ảnh</label>
                    <input type="file" id="user-preview-input" name="image" accept="image/*" onchange="previewImage(event)">
                </div>
                <div class="form-user-image-preview" id="user-add-image-preview">
                    <div id="user-image-preview"></div>
                </div>

                <div class="form-user-role" id="user-add-role">
                    <label for="role">Loại tài khoản</label>
                    <select id="role" name="role">
                        <option value="0">Người dùng</option>
                        <option value="1">Quản lý</option>
                        <option value="2">Nhân viên</option>
                        <option value="3">Admin</option>
                    </select>
                </div>

                <span class="form-user-confirm">
                    <button type="submit" id="btnuserconfirm">Tạo tài khoản</button>
                    <button type="button" onclick="location.href='?page=user&action=index'" id="btnusercancel">Hủy</button>
                </span>
            </div>
        </form>
    </div>
</div>