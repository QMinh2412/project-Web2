<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="/project-Web2/user/assets/css/product.css">
<!-- <?php 
    echo $category_id; 
    echo $current_page;
    echo "\n";
    print_r($products);
    echo "\n";
    print_r($totalPage);
?> -->

<div class="outer_container">
    <div class="box_cheatseat"><i class="fa-solid fa-bars"></i></div>
    <div class="box_filter">
        <div class="box_item">
            <div class="main_item">
                <strong>Thể loại</strong>
                <b><i class="fa-solid fa-caret-down active"></i></b>
            </div>
            <div class="sub_box_item active" >
                <?php foreach ($categories as $category): ?>
                    <div class="item category-item" data-id="<?php echo $category['MaLoai']; ?>">
                        <?php echo $category['TenLoai']; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="box_item">
            <div class="main_item">
                <strong>Tác giả</strong>
                <b><i class="fa-solid fa-caret-down"></i></b>
            </div>
            <div class="sub_box_item">
                <?php foreach ($authors as $author): ?>
                    <div class="item author-item" data-id="<?php echo $author['MaTG']; ?>">
                        <?php echo $author['TenTG']; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="box_item">
            <div class="main_item">
                <strong>Giá</strong>
                <b><i class="fa-solid fa-caret-down"></i></b>
            </div>
            <div class="sub_box_item">
                <div>
                    <input type="checkbox" name="checkbox_price" class="checkbox_price" id="price_1" value="under_50000">
                    <label for="price_1">
                        <div class="item">Dưới 50000 vnđ</div>
                    </label>
                </div>
                <div>
                    <input type="checkbox" name="checkbox_price" class="checkbox_price" id="price_2" value="50000_100000">
                    <label for="price_2">
                        <div class="item">50000 - 100000 vnđ</div>
                    </label>
                </div>
                <div>
                    <input type="checkbox" name="checkbox_price" class="checkbox_price" id="price_3" value="100000_200000">
                    <label for="price_3">
                        <div class="item">100000 - 200000 vnđ</div>
                    </label>
                </div>
                <div>
                    <input type="checkbox" name="checkbox_price" class="checkbox_price" id="price_4" value="200000_300000">
                    <label for="price_4">
                        <div class="item">200000 - 300000 vnđ</div>
                    </label>
                </div>
                <div>
                    <input type="checkbox" name="checkbox_price" class="checkbox_price" id="price_5" value="300000_400000">
                    <label for="price_5">
                        <div class="item">300000 - 400000 vnđ</div>
                    </label>
                </div>
                <div>
                    <input type="checkbox" name="checkbox_price" class="checkbox_price" id="price_6" value="400000_500000">
                    <label for="price_6">
                        <div class="item">400000 - 500000 vnđ</div>
                    </label>
                </div>
                <div>
                    <input type="checkbox" name="checkbox_price" class="checkbox_price" id="price_7" value="500000_over">
                    <label for="price_7">
                        <div class="item">Trên 500000 vnđ</div>
                    </label>
                </div>
            </div>
        </div>
    </div>
    
    <div class ="box_product">
        <div class="book_list container">
            <!-- <?php foreach ($products as $product): ?>
                <div class="book_item">
                    <a href="/project-Web2/user/index.php?page=product&action=detail&id_book=<?php echo $product['MaSach']?>">
                        <div class="img_book">
                            <img src="<?php echo $product['DgDanAnh']['DgDanAnh']?>" alt="<?php echo $product['TenSach']?>">
                        </div>
                        <div class="info_book">
                            <div class="title_book"><?php echo $product['TenSach']?></div>
                            <div class="price_book"><?php echo $product['GiaBan'];?> vnđ</div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?> -->
        </div>

        <div class="pagination">
            <?php if ($totalPage['totalPages'] > 1): ?>
                <!-- Nút lùi về trang trước -->
                <?php if ($totalPage['currentPage'] != 1): ?>
                    <span class="page prev">&laquo;</span>
                <?php endif; ?>
                
                <!-- Các trang -->
                <?php for ($i = 1; $i <= $totalPage['totalPages']; $i++): ?>
                    <span class="page <?php echo ($i == $totalPage['currentPage']) ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </span>
                <?php endfor; ?>

                <!-- Nút tiến tới trang sau -->
                <?php if ($totalPage['currentPage'] != $totalPage['totalPages']): ?>
                    <span class="page next">&raquo;</span>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<script src="/project-Web2/user/assets/js/product.js"></script>

<!-- C:\xampp\htdocs\project-Web2\user\assets\js\product.js -->