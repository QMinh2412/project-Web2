// Hàm ẩn hiện subbox ===========================================================================================
function hideShowSubbox() {
  const main_item = document.querySelectorAll(".main_item");
  console.log(main_item);
  for (let i = 0; i < main_item.length; i++) {
    main_item[i].addEventListener("click", function () {
      const sub_box_item = this.nextElementSibling;
      const icon = this.querySelector("i");

      sub_box_item.classList.toggle("active");
      icon.classList.toggle("active");
    });
  }
}

// Hàm thay đổi màu cho page_item khi nó được chọn ==================================================================
function changeColorForPageItem() {
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
}

// Hàm xử lý dữ liệu lấy được chuyển thành html =====================================================================
function handleData(data) {
  let html = "";
  for (let i = 0; i < data.length; i++) {
    html += `
      <div class="book_item">
        <a href="/project-Web2/user/index.php?page=detail&action=show_detail&id_book=${data[i]["MaSach"]}">
          <div class="img_book">
            <img src="${data[i]["DgDanAnh"]["DgDanAnh"]}" alt="${data[i]["TenSach"]}">
          </div>
          <div class="info_book">
            <div class="title_book">${data[i]["TenSach"]}</div>
            <div class="price_book">${data[i]["GiaBan"]} vnđ</div>
          </div>
        </a>
      </div>
    `;
  }
  return html;
}

// Hàm xử lý số trang lấy được chuyển thành html ==================================================================
function handlePagination(current_page, totalPage) {
  let html = "";
  if (current_page > 1) {
    html += `<span class="page prev">&laquo;</span>`;
  }
  for (let j = 1; j <= totalPage; j++) {
    if (j == current_page) {
      html += `<span class="page active">${j}</span>`;
    } else {
      html += `<span class="page">${j}</span>`;
    }
  }
  if (current_page < totalPage) {
    html += `<span class="page next">&raquo;</span>`;
  }
  return html;
}

// Hàm gắn sự kiện click cho các nút phân trang ===================================================================
function attachPaginationEvents(callback) {
  const paginationLinks = document.querySelectorAll(".page");

  for (let i = 0; i < paginationLinks.length; i++) {
    paginationLinks[i].addEventListener("click", function (e) {
      e.preventDefault();

      if (this.classList.contains("prev")) {
        const currentPage = parseInt(
          document.querySelector(".page.active").textContent.trim()
        );
        if (currentPage > 1) {
          callback(currentPage - 1);
        }
      } else if (this.classList.contains("next")) {
        const currentPage = parseInt(
          document.querySelector(".page.active").textContent.trim()
        );
        const totalPages = parseInt(
          document.querySelectorAll(".page").length - 1
        );
        if (currentPage < totalPages) {
          callback(currentPage + 1);
        }
      } else {
        const page = parseInt(this.textContent.trim());
        callback(page);
      }
    });
  }
}

// Ajax cho phân trang =============================================================================================
function loadPageData(page) {
  const xhr = new XMLHttpRequest();
  xhr.open(
    "GET",
    `/project-Web2/user/index.php?page=product&action=show_page&current_page=${page}`,
    true
  );

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      // console.log(response);
      // console.log(`dang nhay qua trang pagination.js`);

      let data = handleData(response["products"]);
      let pagination = handlePagination(page, response["totalPage"]);

      document.querySelector(".book_list").innerHTML = data;
      document.querySelector(".pagination").innerHTML = pagination;

      attachPaginationEvents(function (page) {
        loadPageData(page);
      });
      window.scrollTo({ top: 0, behavior: "smooth" });
    }
  };

  xhr.send();
}

// Ajax cho thể loại sách ===================================================================================================
let currentCategoryId = null;
function loadBookByCategory(current_page, category_id = null) {
  const xhr = new XMLHttpRequest();
  //   const category_id = this.getAttribute("data-id");
  xhr.open(
    "GET",
    `/project-Web2/user/index.php?page=product&action=render_by_category&category_id=${category_id}&current_page=${current_page}`,
    true
  );
  xhr.onreadystatechange = function () {
    // console.log(`readystate: ${xhr.readyState}`);
    // console.log(`status: ${xhr.status}`);
    if (xhr.readyState == 4 && xhr.status == 200) {
      const response = JSON.parse(xhr.responseText);
      console.log(response);

      let data = handleData(response["products"]);
      let pagination = handlePagination(current_page, response["totalPage"]);

      document.querySelector(".pagination").innerHTML = pagination;
      document.querySelector(".book_list").innerHTML = data;
      attachPaginationEvents(function (current_page) {
        loadBookByCategory(current_page, currentCategoryId);
      });
      window.scrollTo({ top: 0, behavior: "smooth" });
    }
  };
  xhr.send();
}

function attachCategoryEvents() {
  const categories = document.querySelectorAll(".category-item");
  categories.forEach((category) => {
    category.addEventListener("click", function () {
      currentCategoryId = this.getAttribute("data-id"); // Lưu ID thể loại hiện tại
      console.log(`Thể loại ${currentCategoryId} vừa được click`);
      loadBookByCategory(1, currentCategoryId); // Tải trang đầu tiên của thể loại
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
  });
}

// Ajax cho tác giả =======================================================================================================
let currentAuthorId = null;
function loadBookByAuthor(current_page, author_id = null) {
  const xhr = new XMLHttpRequest();
  //   const author_id = this.getAttribute("data-id");
  xhr.open(
    "GET",
    `/project-Web2/user/index.php?page=product&action=render_by_author&author_id=${author_id}&current_page=${current_page}`,
    true
  );
  xhr.onreadystatechange = function () {
    // console.log(`readystate: ${xhr.readyState}`);
    // console.log(`status: ${xhr.status}`);
    if (xhr.readyState == 4 && xhr.status == 200) {
      const response = JSON.parse(xhr.responseText);
      console.log(response);

      //   xử lý dữ liệu hiện ra màn hình
      let data = handleData(response["products"]);

      let pagination = handlePagination(current_page, response["totalPage"]);

      document.querySelector(".pagination").innerHTML = pagination;
      document.querySelector(".book_list").innerHTML = data;
      attachPaginationEvents(function (current_page) {
        loadBookByAuthor(current_page, currentAuthorId);
      });
      window.scrollTo({ top: 0, behavior: "smooth" });
    }
  };
  xhr.send();
  console.log(
    `Gửi yêu cầu Ajax đến server với ID tác giả: ${author_id} thành công`
  );
}

function attachAuthorEvents() {
  const authors = document.querySelectorAll(".author-item");
  authors.forEach((author) => {
    author.addEventListener("click", function () {
      currentAuthorId = this.getAttribute("data-id");
      console.log(`Tác giả ${currentAuthorId} vừa được click`);
      loadBookByAuthor(1, currentAuthorId);
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
  });
}

// Ajax cho khoảng giá ===================================================================================================
let currSelectChecked = null;
function loadBookPriceRange(selectChecked, current_page) {
  // console.log(`current_page: ${current_page}`);
  const xhr = new XMLHttpRequest();
  xhr.open(
    "GET",
    `/project-Web2/user/index.php?page=product&action=filter&price_range=${selectChecked}&current_page=${current_page}`,
    true
  );
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      const response = JSON.parse(xhr.responseText);
      console.log(response);

      let data = handleData(response["products"]);
      let pagination = handlePagination(current_page, response["totalPage"]);

      document.querySelector(".pagination").innerHTML = pagination;
      document.querySelector(".book_list").innerHTML = data;
      attachPaginationEvents(function (current_page) {
        loadBookPriceRange(selectChecked, current_page);
      });
      window.scrollTo({ top: 0, behavior: "smooth" });
    }
  };
  xhr.send();
}

function attachFilterEvents() {
  const filters = document.querySelectorAll(".checkbox_price");
  filters.forEach((filter) => {
    filter.addEventListener("change", function () {
      // const priceRange = this.getAttribute("value");
      // console.log(`Khoảng giá ${priceRange} vừa được chọn`);
      var selectChecked = [];
      filters.forEach((filter) => {
        if (filter.checked) {
          selectChecked.push(filter.value);
        }
      });
      currSelectChecked = selectChecked;
      // console.log(`selectChecked: ${selectChecked}`);
      // console.log(typeof selectChecked);
      loadBookPriceRange(selectChecked, 1);
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
  });
}

function getParam(param) {
  const urlParams = new URLSearchParams(window.location.search);
  return urlParams.get(param);
}

document.addEventListener("DOMContentLoaded", function () {
  console.log("product.js đã được tải");
  hideShowSubbox();
  changeColorForPageItem();

  attachCategoryEvents();
  attachAuthorEvents();
  attachFilterEvents();

  const urlParams = new URLSearchParams(window.location.search);
  console.log(`url: ${urlParams}`);
  const caterogy_id = urlParams.get("category_id");
  const current_page = urlParams.get("current_page");

  console.log(`ma the loai: ${caterogy_id}`);
  console.log(`trang hien tai: ${current_page}`);

  loadPageData(1);
});
