document.addEventListener("DOMContentLoaded", function () {
  // Ẩn hiện sub_box_item khi click vào main_item
  const main_item = document.querySelectorAll(".main_item");
  console.log(main_item);
  for (let i = 0; i < main_item.length; i++) {
    main_item[i].addEventListener("click", function (e) {
      e.stopPropagation();
      const sub_box_item = this.nextElementSibling;
      const icon = this.querySelector("i");

      sub_box_item.classList.toggle("active");
      icon.classList.toggle("active");
    });
  }

  // Thay đổi màu page_item khi nó được chọn
  const page_item = document.querySelectorAll(".page");
  for (let i = 0; i < page_item.length; i++) {
    page_item[i].addEventListener("click", function (e) {
      e.preventDefault();
      for (let j = 0; j < page_item.length; j++) {
        page_item[j].classList.remove("active");
      }
      this.classList.toggle("active");
      console.log(`trang ${i + 1} được chọn`);
    });
  }

  // Xử lý sự kiện click các nút next, prev
  const prevBtn = document.querySelector(".prev");
  const nextBtn = document.querySelector(".next");
  const pageItems = document.querySelectorAll(".page");
  let currentPage = 1;
  const totalPages = pageItems.length;
  prevBtn.addEventListener("click", function (e) {
    e.preventDefault();
    console.log(`currentPage: ${currentPage}`);
    if (currentPage > 1) {
      pageItems[currentPage].classList.remove("active");
      currentPage--;
      pageItems[currentPage].classList.add("active");
    }
  });
  nextBtn.addEventListener("click", function (e) {
    e.preventDefault();
    console.log(`currentPage: ${currentPage}`);
    if (currentPage < totalPages - 1) {
      pageItems[currentPage].classList.remove("active");
      currentPage++;
      pageItems[currentPage].classList.add("active");
    }
  });
});
