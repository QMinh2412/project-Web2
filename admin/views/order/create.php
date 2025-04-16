<!-- filepath: d:\xampp\htdocs\project-Web2\admin\views\order\create.php -->
<link rel="stylesheet" href="../../assets/css/order.css">
<div class="admin-wrapper">
    <div class="order-container">
        <h2 class="order-header">Tạo đơn hàng mới</h2>
        <form method="POST" action="">
            <div class="order-form-group">
                <label for="customer-id">Khách hàng</label>
                <select id="customer-id" name="customer_id" required>
                    <option value="">Chọn khách hàng</option>
                    <?php foreach ($customers as $customer): ?>
                        <option value="<?= $customer['id'] ?>"><?= htmlspecialchars($customer['name']) ?> (<?= htmlspecialchars($customer['email']) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="order-search-btn">Tạo đơn hàng</button>
        </form>
    </div>
</div>