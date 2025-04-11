<div class="admin-wrapper">
    <div class="user-add-form">
        <form id="useraddform" method="POST" action="?page=user&action=create">
            <div class="admin-header">
                <h2>Thêm tài khoản</h2>
            </div>
            <div class="form-group-user-add">
                <div class="form-user-name" id="user-add-name">
                    <label for="name">Họ tên</label>
                    <input type="text" id="name" name="name" placeholder="Nhập họ tên">
                </div>

                <div class="form-user-username" id="user-add-username">
                    <label for="username">Tên tài khoản</label>
                    <input type="text" id="username" name="username" placeholder="Nhập tên tài khoản">
                </div>

                <div class="form-user-email" id="user-add-email">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Nhập email">
                </div>

                <div class="form-user-password" id="user-add-password">
                    <label for="password">Mật khẩu</label>
                    <input type="password" id="password" name="password" placeholder="Nhập mật khẩu">
                </div>

                <div class="form-user-image">
                    <label for="image">Hình ảnh</label>
                    <button type="button">Chọn hình ảnh</button>
                </div>

                <div class="form-user-type">
                    <label for="type">Loại tài khoản</label>
                    <select id="type" name="type">
                        <option value="0">Người dùng</option>
                        <option value="1">Admin</option>
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