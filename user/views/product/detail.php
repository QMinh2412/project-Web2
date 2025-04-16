<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/project-Web2/user/assets/css/detail.css">
</head>
<div class="container">
    <div class="box_detail">
        <div class="book_image">
            <div class="main_image">
                <img src="<?php echo $book_data['DgDanAnh'][0]['DgDanAnh'];?>" alt="<?php echo $book_data['TenSach']?>" class="main_image">
            </div>
            <div class="detail_image">
                <?php foreach($book_data['DgDanAnh'] as $img):?>
                    <div>
                        <img src="<?php echo $img['DgDanAnh']; ?>" alt="<?php echo $book_data['TenSach']?>" class="detail_image">
                    </div>
                <?php endforeach ?>
            </div>
        </div>

        <div class="main_detail">
            <div class="book_title"><?php echo $book_data['TenSach']; ?></div>
            <div class="book_author">Tác giả: <span><?php echo $book_data['TenTG']; ?></span></div>
            <div class="book_category">Thể loại: <span><?php echo $book_data['TenLoai']; ?></span></div>
            <div class="book_price">Giá: <span><?php echo $book_data['GiaBan']; ?> vnđ</span></div>
            <div class="book_status">Còn hàng: <span><?php echo $book_data['SoLgTon']; ?></span></div>
            <div class="book_quantity">Số lượng: 
                <span id="minus_icon"><i class="fa-solid fa-minus"></i></span>
                <span id="quantity">1</span>
                <span id="plus_icon"><i class="fa-solid fa-plus"></i></span>
            </div>
            <div class="box_btn">
                <button id="addToCart">Thêm vào giỏ hàng</button>
                <button id="buyNow">Mua Ngay</button>
            </div>
        </div>
        <div class="more_detail">
            <div>Thông tin chi tiết</div>
            <div class="book_infomation">
                <div class="book_provider">Nhà cung cấp: <span>tên nhà cung cấp</span></div>
                <div class="book_publisher">Nhà xuất bản: <span><?php echo $book_data['TenNXB']; ?></span></div>
                <div class="book_publication_date">Ngày xuất bản: <span><?php echo $book_data['NamXB']; ?></span></div>
                <div class="number_of_page">Số trang: <span><?php echo $book_data['SoTrang']; ?></span></div>
                <div class="book_size">Kích thước: <span><?php echo $book_data['KichThuoc']; ?></span></div>
            </div>

            <div class="general_infomation">
                <div class="call_to_buy">Gọi đặt hàng: <span>0123456789</span></div>
                <div class="consultation">Tư vấn khách hàng: <span>0123456789</span></div>
                <div class="return">
                    Đổi trả trong vòng: <span>48 giờ</span> <br>
                    Vui lòng liên hệ: <span>0123456789</span> để được đổi sản phẩm khác
                </div>
            </div>
        </div>
    </div>

    <div class="box_intro">
        <div class="title">Mô tả sản phẩm</div>
        <div class="desc"><?php echo $book_data['MoTaChiTiet']; ?></div>
    </div>

    <div class="box_orther_book">
        <div class="title">Sách cùng thể loại
            <a href="/project-Web2/user/index.php?page=product&category_id=<?php echo urlencode($orther_books[0]['MaLoai']); ?>&current_page=1"><span>Xem tất cả</span></a>
        </div>
        <div class="orther_books owl-carousel owl-theme">
            <?php foreach($orther_books as $book):?>
                <a href="/project-Web2/user/index.php?page=detail&action=show_detail&id_book=<?php echo $book["MaSach"]; ?>">
                    <div class="book_item">
                        <div class="book_image">
                            <img src="<?php echo $book['DgDanAnh'][0]['DgDanAnh']; ?>" alt="<?php echo $book['TenSach']; ?>">
                        </div>
                        <div class="book_title"><?php echo $book['TenSach']; ?></div>
                        <div class="book_price"><?php echo $book['GiaBan']; ?> vnđ</div>
                    </div>
                </a>
            <?php endforeach?>
        </div>

        <div id="prev"><i class="fa-solid fa-arrow-left"></i></div>
        <div id="next"><i class="fa-solid fa-arrow-right"></i></div>

    </div>

    <div class="box_comment">
        <div class="title">Đánh giá về sản phẩm</div>
        <div class="comments">
            <div class="old_comments">
                <?php if($book_reviews): ?>
                    <?php foreach($book_reviews as $review): ?>
                        <div class="comment" data-id="<?php echo $review['MaDG']; ?>">
                            <div class="info_account">
                                <div class="account_image">
                                    <img src="<?php echo $review['AnhKH']; ?>" alt="<?php echo $review['TenKH']; ?>">
                                </div>
                                <div class="account_name"><?php echo $review['TenKH']; ?></div>
                                <div class="date_comment"><?php echo $review['NgayViet']; ?></div>
                            </div>
                            <div class="content"><?php echo $review['NoiDung']; ?></div>
                            <?php if ($review["MaAdmin"]): ?>
                                <div class="write_reply">
                                    <div class="reply_account_info">
                                        <div class="account_image">
                                            <img src="<?php echo $review['AnhDN']; ?>" alt="<?php echo $review['TenAdmin']; ?>">
                                        </div>
                                        <div class="account_name"><?php echo $review['TenAdmin']; ?></div>
                                    </div>
                                    <div class="content reply_content"><?php echo $review['PhanHoi']; ?></div>
                                </div>
                            <?php elseif (isset($_SESSION['account_role']) && $_SESSION['account_role'] != 0): ?>
                                <div class="text_reply">Trả lời</div>
                                <div class="write_reply" style="display: none;">
                                    <textarea name="content_reply" class="content_reply" cols="50" rows="5" placeholder="Viết câu trả lời gửi đến khách hàng"></textarea><br>
                                    <div class="align_center"><button class="btn_reply">Trả lời</button></div>
                                </div>
                            <?php endif ?>
                        </div>
                    <?php endforeach ?>
                <?php else: ?>
                    <?php echo '<div class="havent_review" style="color: red; font-size: 24px; font-weight: bold; margin-top: 20px;">Sản phẩm chưa có đánh giá nào</div>'?>
                <?php endif ?>
            </div>

            <div class="my_comment">
                <div class="comment_content">Bình luận sản phẩm</div>
                <textarea name="my_comment" id="my_comment" cols="50" rows="8" placeholder="Viết bình luận của bạn ở đây"></textarea> <br>
                <div class="align_center"><button class="send">Gửi</button></div>
            </div>
        </div>
    </div>
</div>
<script src="/project-Web2/user/assets/js/detail.js"></script>
<!-- Thêm jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Thêm Owl Carousel JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script>
    function handleBuyNow() {
        // Lấy id_book từ URL
        const urlParams = new URLSearchParams(window.location.search);
        const id_book = urlParams.get('id_book');
        
        // Lấy số lượng từ giao diện
        const quantity = document.getElementById('quantity').textContent;

        // Chuyển hướng đến trang checkout.php với id_book và quantity
        window.location.href = `/project-Web2/user/index.php?page=checkout&action=showCheckout&id_book=${id_book}&quantity=${quantity}`;
    }

    // Gắn sự kiện click cho nút "Mua Ngay"
    document.getElementById('buyNow').addEventListener('click', handleBuyNow);
</script>