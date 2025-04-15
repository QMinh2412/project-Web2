<?php
// Kết nối các file mô hình cần thiết
require_once __DIR__ . '/../common/models/Category.php';
require_once __DIR__ . '/../common/models/Product.php';
require_once __DIR__ . '/../common/models/Author.php';

class BookController {
    public function index() {
        // Khởi tạo các đối tượng để lấy dữ liệu
        $categoryModel = new Category(); // Đối tượng để lấy danh sách thể loại
        $authorModel = new Author();     // Đối tượng để lấy danh sách tác giả
        $productModel = new Product();   // Đối tượng để lấy danh sách sách

        // Lấy tất cả thể loại, tác giả, sách và thông tin phân trang
        $categories = $categoryModel->getAllCategories(); // Lấy tất cả thể loại
        $authors = $authorModel->getAllAuthors();         // Lấy tất cả tác giả
        $products = $productModel->getAllProducts(1);     // Lấy tất cả sách (trang 1)
        $totalPage = $productModel->getPagination(2);     // Lấy thông tin phân trang

        // Bắt đầu bộ đệm đầu ra để lưu nội dung giao diện
        ob_start();
        include __DIR__ . '/../views/book/book.php'; // Gọi file giao diện book.php
        $main_content = ob_get_clean();

        // Gọi file bố cục chính để hiển thị nội dung
        include __DIR__ . '/../views/layouts/main_layout.php';
    }
}
?>