<script src="/project-Web2/admin/assets/js/dashboard.js"></script>
<link rel="stylesheet" href="../../assets/css/dashboard.css">
<div class="admin-wrapper">
    <div class="search-header">
        <h1 class="h1-header">Thống kê doanh thu</h1>
        <div class="search-section">
            <form method="GET" action="">
                <label for="customer-from-date">Từ:</label>
                <input type="date" id="customer-from-date" name="customer-from-date" value="<?= htmlspecialchars($_GET['customer-from-date'] ?? '') ?>" required>


                <label for="customer-to-date">Đến:</label>
                <input type="date" id="customer-to-date" name="customer-to-date" value="<?= htmlspecialchars($_GET['customer-to-date'] ?? '') ?>" required>

                <button type="submit">Tìm kiếm</button>
            </form>
        </div>
    </div>
    <?php
        include 'thongkedoanhthu.php';
        include 'favoritecus.php';
        include 'bestseller.php';
    ?>
</div>

   