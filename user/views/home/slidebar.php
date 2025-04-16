<?php
// Kết nối các mô hình để lấy dữ liệu
require_once __DIR__ . '/../../../common/models/Product.php';
require_once __DIR__ . '/../../../common/models/Category.php';

// Khởi tạo đối tượng để lấy dữ liệu
$categoryModel = new Category();
$productModel = new Product();

// Lấy danh sách tất cả thể loại
$categories = $categoryModel->getAllCategories();

// Kiểm tra dữ liệu thể loại
if (empty($categories)) {
    echo "<p>Không có thể loại nào để hiển thị.</p>";
    exit;
}
?>

<!-- Kết nối file CSS để định dạng -->
<link rel="stylesheet" href="../../assets/css/slidebar.css?v=<?php echo time(); ?>">

<!-- Thanh bên (sidebar) chứa danh sách thể loại, đặt ở trên cùng -->
<div class="top-section">
    <div class="sidebar">
        <div class="menu-btn">
            <span>☰</span>
            <h3>Danh sách thể loại</h3>
        </div>
        <div class="menu-list">
            <?php foreach ($categories as $category): ?>
                <a href="#category-<?php echo $category['MaLoai']; ?>"><?php echo htmlspecialchars($category['TenLoai']); ?></a>
            <?php endforeach; ?>
            <a class="menu-more" href="#">Xem thêm</a>
        </div>
    </div>

    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTvo5vwFx7e53OvzGc0Jt4-m0krCkxGf2sUFw&s" alt="Slide 1" />
            </div>
            <div class="swiper-slide">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTvo5vwFx7e53OvzGc0Jt4-m0krCkxGf2sUFw&s" alt="Slide 2" />
            </div>
            <div class="swiper-slide">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTvo5vwFx7e53OvzGc0Jt4-m0krCkxGf2sUFw&s" alt="Slide 3" />
            </div>
        </div>
    </div>
</div>


<!-- Phần hiển thị sách theo thể loại, đặt dưới slider -->
<div class="books-container">
    <?php foreach ($categories as $category): ?>
        <?php
        // Lấy danh sách sách theo thể loại, giới hạn tối đa 5 cuốn
        $products = $productModel->getProductsByCategory($category['MaLoai']);
        if (!empty($products)):
            // Giới hạn số sách hiển thị là 5
            $products = array_slice($products, 0, 5);
        ?>
            <div class="category-section" id="category-<?php echo $category['MaLoai']; ?>">
                <!-- Tiêu đề thể loại -->
                <div class="category-header">
                    <span><?php echo htmlspecialchars($category['TenLoai']); ?></span>
                    <a href="#">Xem thêm</a>
                </div>
                <!-- Danh sách sách -->
                <div class="books-list">
                    <?php foreach ($products as $product): ?>
                        <div class="book-item">
                            <!-- Hình ảnh sách -->
                            <img src="<?php echo htmlspecialchars($product['DgDanAnh']); ?>" alt="<?php echo htmlspecialchars($product['TenSach']); ?>" />
                            <!-- Tên sách -->
                            <div class="book-title"><?php echo htmlspecialchars($product['TenSach']); ?></div>
                            <!-- Giá sách -->
                            <div class="book-price"><?php echo number_format($product['GiaBan'], 0, ',', '.') . 'đ'; ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            <p>Không có sách nào trong thể loại "<?php echo htmlspecialchars($category['TenLoai']); ?>".</p>
        <?php endif; ?>
    <?php endforeach; ?>
</div>

<!-- Kết nối các file JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<script src="../../assets/js/slidebar.js?v=<?php echo time(); ?>"></script>
<script>
    // Khởi tạo Swiper cho slider ảnh
    var swiper = new Swiper(".swiper-container", {
        loop: true,
        autoplay: {
            delay: 3000,
        },
    });
</script>