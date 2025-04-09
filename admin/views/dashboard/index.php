<div class="admin-wrapper">
    <div class="search-header">
        <h1>Thống kê doanh thu</h1>
        <div class="search-section">
            <form method="GET" action="">
                <label for="from-date">Từ:</label>
                <input type="date" id="from-date" name="from-date" required>

                <label for="to-date">Đến:</label>
                <input type="date" id="to-date" name="to-date" required>

                <button type="sumit">Tìm kiếm</button>
            </form>
        </div>
    </div>
    <?php
        include 'thongkedoanhthu.php';
        include 'favoritecus.php';
        include 'bestseller.php';
    ?>
</div>
   