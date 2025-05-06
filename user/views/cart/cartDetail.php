<?php
    require_once __DIR__ . '/../../../common/models/Product.php';
    $productModel = new Product();
    // $totalBook = 0;
    // $totalPrice = 0;
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="/project-Web2/user/assets/css/cartDetail.css">
<div class="container_cart_detail_box">
    <div class="cart_detail">
        <h2>Giỏ hàng</h2>
        <div class="books_in_cart">
            <?php if(!empty($bookInMyCart)): ?>
                <?php foreach ($bookInMyCart as $book): ?>
                    <?php $book_data = $productModel->getProductById($book['MaSach']); ?>
                    <div class="book_in_cart" data-id="<?php echo $book_data['MaSach']; ?>">
                        <div class="book_image">
                            <a href="/project-Web2/user/index.php?page=detail&action=show_detail&id_book=<?php echo $book_data['MaSach']; ?>">
                                <img src="<?php echo $book_data['DgDanAnh'][0]['DgDanAnh']; ?>" alt="<?php echo $book_data['TenSach']; ?>">
                            </a>
                        </div>
                        <div class="name_box">
                            <div class="book_name"><?php echo $book_data['TenSach']; ?></div>
                            <div class="author_name">Tác giả: <span><?php echo $book_data['TenTG']; ?></span></div>
                            <div class="category_name">Thể loại: <span><?php echo $book_data['TenLoai']; ?></span></div>
                            <div class="button_box">
                                <input type="checkbox" name="selected" id="" class="selected" <?php echo ($book['TinhTrang'] == 1) ? "checked" : ""; ?>> <span>Chọn</span>
                                <button>Xóa</button>
                            </div>
                        </div>
                        <div class="book_price"><?php echo number_format($book_data['GiaBan'], 0, '.', '.'); ?> đ</div>
                        <div class="quantity_box">
                            <span class="minus_icon"><i class="fa-solid fa-minus"></i></span>
                            <span class="quantity"><?php echo $book['SoLg']; ?></span>
                            <span class="plus_icon"><i class="fa-solid fa-plus"></i></span>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php else: ?>
                <div style="color: red; font-size: 24px; font-weight: bold; padding: 20px;">Giỏ hàng của bạn đang trống</div>
            <?php endif ?>
        </div>
    </div>
    <div class="total_box">
        <form>
            <div class="total_book">0 <span>sản phẩm</span></div>
            <div class="total_price">0 đ</div>
            <button class="btn_submit <?php if(empty($booksInCart)) echo 'disabled';?>">Thanh toán</button>
        </form>
    </div>
</div>
<script src="/project-Web2/user/assets/js/cartDetail.js"></script>