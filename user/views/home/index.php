<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="/project-Web2/user/assets/css/slidebar.css">
<div>
    <div class="top-section">
        <div class="sidebar">
            <div class="menu-btn">
                <span><i class="fa-solid fa-list"></i></span>
                <h3>Danh sách thể loại</h3>
            </div>
            <div class="menu-list">
                <?php foreach ($categories as $category): ?>
                    <a href="/project-Web2/user/index.php?page=product&category_id=<?php echo urlencode($category['MaLoai']); ?>&current_page=1">
                        <?php echo $category['TenLoai']; ?>
                    </a>
                <?php endforeach; ?>
                <a class="menu-more" href="/project-Web2/user/index.php?page=product">Xem thêm</a>
            </div>
        </div>

        <div class="swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="https://bookbuy.vn/Res/Images/Album/d964cd17-e283-4d7f-8b10-562b454bbcb1.jpg?w=880&scale=both&h=320&mode=crop" alt="Slide 1" />
                </div>
                <div class="swiper-slide">
                    <img src="https://bookbuy.vn/Res/Images/Album/7ef94c08-7976-4957-8561-c53de0c04108.jpg?w=880&scale=both&h=320&mode=crop" alt="Slide 2" />
                </div>
                <div class="swiper-slide">
                    <img src="https://bookbuy.vn/Res/Images/Album/bc5995b5-64a3-4bc7-8413-718664549f82.jpg?w=880&scale=both&h=320&mode=crop" alt="Slide 3" />
                </div>
            </div>
        </div>
    </div>
</div>

<div class="books-container">
    <div class="category-section" id="category-<?php echo $category1['MaLoai']; ?>">
        <!-- Tiêu đề thể loại -->
        <div class="category-header">
            <span><?php echo htmlspecialchars($category1['TenLoai']); ?></span>
            <a href="/project-Web2/user/index.php?page=product&category_id=<?php echo urlencode($category1['MaLoai']); ?>&current_page=1">Xem thêm</a>
        </div>
        <!-- Danh sách sách -->
        <div class="books-list">
            <?php foreach ($products1 as $product): ?>
                <a href="/project-Web2/user/index.php?page=detail&action=show_detail&id_book=<?php echo htmlspecialchars($product['MaSach']); ?>">
                    <div class="book-item">
                        <!-- Hình ảnh sách -->
                        <img src="<?php echo htmlspecialchars($product['DgDanAnh']['DgDanAnh']); ?>" alt="<?php echo htmlspecialchars($product['TenSach']); ?>" />
                        <!-- Tên sách -->
                        <div class="book-title"><?php echo htmlspecialchars($product['TenSach']); ?></div>
                        <!-- Giá sách -->
                        <div class="book-price"><?php echo number_format($product['GiaBan'], 0, ',', '.') . 'đ'; ?></div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="category-section" id="category-<?php echo $category2['MaLoai']; ?>">
        <!-- Tiêu đề thể loại -->
        <div class="category-header">
            <span><?php echo htmlspecialchars($category2['TenLoai']); ?></span>
            <a href="/project-Web2/user/index.php?page=product&category_id=<?php echo urlencode($category2['MaLoai']); ?>&current_page=1">Xem thêm</a>
        </div>
        <!-- Danh sách sách -->
        <div class="books-list">
            <?php foreach ($products2 as $product): ?>
                <a href="/project-Web2/user/index.php?page=detail&action=show_detail&id_book=<?php echo htmlspecialchars($product['MaSach']); ?>">
                    <div class="book-item">
                        <!-- Hình ảnh sách -->
                        <img src="<?php echo htmlspecialchars($product['DgDanAnh']['DgDanAnh']); ?>" alt="<?php echo htmlspecialchars($product['TenSach']); ?>" />
                        <!-- Tên sách -->
                        <div class="book-title"><?php echo htmlspecialchars($product['TenSach']); ?></div>
                        <!-- Giá sách -->
                        <div class="book-price"><?php echo number_format($product['GiaBan'], 0, ',', '.') . 'đ'; ?></div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>            
</div>

<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<script>
    // Khởi tạo Swiper cho slider ảnh
    var swiper = new Swiper(".swiper-container", {
        loop: true,
        autoplay: {
            delay: 3000,
        },
    });
</script>
