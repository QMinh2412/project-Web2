<link rel="stylesheet" href="../../assets/css/dashboard.css">
<div class="dashboard-section">
    <div class="dashboard-header">
        <h1>Sản phẩm bán chạy</h1>
        <div class="search-section">
            <form method="GET" action="">
                <label for="product-from-date">Từ:</label>
                <input type="date" id="product-from-date" name="product-from-date" required>

                <label for="product-to-date">Đến:</label>
                <input type="date" id="product-to-date" name="product-to-date" required>

                <button type="submit">Tìm kiếm</button>
            </form>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên sản phẩm</th>
                <th>Số lượng bán được</th>
                <th>Giá tiền</th>
                <th>Tổng tiền</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Tên sách</td>
                <td>10</td>
                <td>100.000đ</td>
                <td>1.000.000đ</td>
            </tr>
        </tbody>
    </table>
</div>