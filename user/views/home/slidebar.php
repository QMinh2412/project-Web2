<link rel="stylesheet" href="../../assets/css/slidebar.css">
<body>
    <div class="sidebar">
      <div class="menu-btn">
        <span>&#9776;</span>
        <strong>Danh sách thể loại</strong>
      </div>
      <div class="menu-list">
        <a href="">Giáo dục</a>
        <a href="">Khoa học</a>
        <a href="">Xã hội</a>
        <a href="">Tiểu thuyết</a>
        <a href="">Truyện tranh</a>
        <a class="menu-more" href="">Xem thêm</a>
      </div>
    </div>

    <div class="swiper-container">
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <img
            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTvo5vwFx7e53OvzGc0Jt4-m0krCkxGf2sUFw&s"
            alt="Slide 1"
          />
        </div>
        <div class="swiper-slide">
          <img
            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTvo5vwFx7e53OvzGc0Jt4-m0krCkxGf2sUFw&s"
            alt="Slide 2"
          />
        </div>
        <div class="swiper-slide">
          <img
            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTvo5vwFx7e53OvzGc0Jt4-m0krCkxGf2sUFw&s"
            alt="Slide 3"
          />
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script>
      var swiper = new Swiper(".swiper-container", {
        loop: true,
        autoplay: {
          delay: 3000,
        },
      });
    </script>
  </body>