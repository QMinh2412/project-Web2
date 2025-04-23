
<div class="admin-wrapper">
    <div class="admin-header">
        <h1 class="title">Nhập sách</h1>
    </div>
    <form method="POST" action="?page=import&action=import" class="admin-form">
        <div class="form-group">
            <div>
                <label for="supplier">Nhà cung cấp:</label>
                <input type="text" name="supplier_id" id="supplier" class="form-input" required>
            </div>
            <div>
                <label for="import_date">Ngày nhập:</label>
                <input type="date" name="import_date" id="import_date" class="form-input" required>
            </div>
            <div>
                <label for="employee_id">Mã nhân viên:</label>
                <input type="text" name="employee_id" id="employee_id" class="form-input" required>
            </div>
            <div>
                <button type="button" id="quick-add" class="btn btn-add">Thêm nhanh</button>
            </div>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Tên sách</th>
                    <th>Tác giả</th>
                    <th>Thể loại</th>
                    <th>Nhà xuất bản</th>
                    <th>Số lượng</th>
                    <th>Giá nhập</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody id="product-list">
                <tr>
                    <td><input type="text" name="products[0][name]" class="table-input" required></td>
                    <td><input type="text" name="products[0][author]" class="table-input" required></td>
                    <td><input type="text" name="products[0][category]" class="table-input" required></td>
                    <td><input type="text" name="products[0][publisher]" class="table-input" required></td>
                    <td><input type="number" name="products[0][quantity]" class="table-input" required></td>
                    <td><input type="number" name="products[0][price]" class="table-input" required></td>
                    <td>
                        <button type="button" class="btn btn-add-row">+</button>
                        <button type="button" class="btn btn-remove-row">-</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <button type="submit" class="btn btn-save">Lưu</button>
    </form>
</div>