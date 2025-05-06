// Hàm định dạng giá tiền
function formatCurrency(amount) {
  const formatter = new Intl.NumberFormat("vi-VN", {
    style: "decimal",
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
    useGrouping: true,
  });
  return formatter.format(amount) + " đ";
}

// Hàm ẩn hiện subbox
function hideShowSubbox() {
  const main_item = document.querySelectorAll(".main_item");
  for (let i = 0; i < main_item.length; i++) {
    main_item[i].addEventListener("click", function () {
      const sub_box_item = this.nextElementSibling;
      const icon = this.querySelector("i");

      sub_box_item.classList.toggle("active");
      icon.classList.toggle("active");
    });
  }
}

// Hàm thay đổi màu cho page_item khi nó được chọn
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

// Hàm xử lý dữ liệu lấy được chuyển thành html
function handleData(data) {
  let html = "";
  for (let i = 0; i < data.length; i++) {
    html += `
      <div class="book_item">
        <a href="/project-Web2/user/index.php?page=detail&action=show_detail&id_book=${
          data[i]["MaSach"]
        }">
          <div class="img_book">
            <img src="${data[i]["DgDanAnh"]["DgDanAnh"]}" alt="${
      data[i]["TenSach"]
    }">
          </div>
          <div class="info_book">
            <div class="title_book">${data[i]["TenSach"]}</div>
            <div class="price_book">${formatCurrency(data[i]["GiaBan"])}</div>
          </div>
        </a>
      </div>
    `;
  }
  return html;
}

// Hàm xử lý số trang lấy được chuyển thành html
function handlePagination(current_page, totalPage) {
  let html = "";
  if (current_page > 1) {
    html += `<span class="page prev">«</span>`;
  }
  for (let j = 1; j <= totalPage; j++) {
    if (j == current_page) {
      html += `<span class="page active">${j}</span>`;
    } else {
      html += `<span class="page">${j}</span>`;
    }
  }
  if (current_page < totalPage) {
    html += `<span class="page next">»</span>`;
  }
  return html;
}

// Hàm gắn sự kiện click cho các nút phân trang
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
        const totalPages = document.querySelectorAll(
          ".page:not(.prev):not(.next)"
        ).length;
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

// Ajax cho phân trang
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

      let data = handleData(response["products"]);
      let pagination =
        response["totalPage"] > 1
          ? handlePagination(page, response["totalPage"])
          : "";

      document.querySelector(".book_list").innerHTML = data;
      document.querySelector(".pagination").innerHTML = pagination;

      // Chuẩn hóa trạng thái
      const state = {
        type: "page",
        page: page,
        category_id: null,
        author_id: null,
        price_range: null,
      };
      const newUrl = `/project-Web2/user/index.php?page=product&current_page=${page}`;

      if (
        window.history.state?.page !== page ||
        window.history.state?.type !== "page"
      ) {
        history.pushState(state, "", newUrl);
      }

      if (response["totalPage"] > 1) {
        attachPaginationEvents(function (page) {
          loadPageData(page);
        });
      }
      window.scrollTo({ top: 0, behavior: "smooth" });
    }
  };

  xhr.send();
}

// Ajax cho thể loại sách
let currentCategoryId = null;
function loadBookByCategory(current_page, category_id = null) {
  const xhr = new XMLHttpRequest();
  xhr.open(
    "GET",
    `/project-Web2/user/index.php?page=product&action=render_by_category&category_id=${category_id}&current_page=${current_page}`,
    true
  );
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      const response = JSON.parse(xhr.responseText);

      let data = handleData(response["products"]);
      let pagination =
        response["totalPage"] > 1
          ? handlePagination(current_page, response["totalPage"])
          : "";

      document.querySelector(".pagination").innerHTML = pagination;
      document.querySelector(".book_list").innerHTML = data;

      // Chuẩn hóa trạng thái
      const state = {
        type: "category",
        page: current_page,
        category_id: category_id,
        author_id: null,
        price_range: null,
      };
      const newUrl = `/project-Web2/user/index.php?page=product&category_id=${category_id}&current_page=${current_page}`;

      if (
        window.history.state?.category_id !== category_id ||
        window.history.state?.page !== current_page ||
        window.history.state?.type !== "category"
      ) {
        history.pushState(state, "", newUrl);
      }

      if (response["totalPage"] > 1) {
        attachPaginationEvents(function (current_page) {
          loadBookByCategory(current_page, category_id);
        });
      }
      window.scrollTo({ top: 0, behavior: "smooth" });
    }
  };
  xhr.send();
}

function attachCategoryEvents() {
  const categories = document.querySelectorAll(".category-item");
  categories.forEach((category) => {
    category.addEventListener("click", function () {
      currentCategoryId = this.getAttribute("data-id");
      console.log(`Thể loại ${currentCategoryId} vừa được click`);
      loadBookByCategory(1, currentCategoryId);
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
  });
}

// Ajax cho tác giả
let currentAuthorId = null;
function loadBookByAuthor(current_page, author_id = null) {
  const xhr = new XMLHttpRequest();
  xhr.open(
    "GET",
    `/project-Web2/user/index.php?page=product&action=render_by_author&author_id=${author_id}&current_page=${current_page}`,
    true
  );
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      const response = JSON.parse(xhr.responseText);

      let data = handleData(response["products"]);
      let pagination =
        response["totalPage"] > 1
          ? handlePagination(current_page, response["totalPage"])
          : "";

      document.querySelector(".pagination").innerHTML = pagination;
      document.querySelector(".book_list").innerHTML = data;

      // Chuẩn hóa trạng thái
      const state = {
        type: "author",
        page: current_page,
        category_id: null,
        author_id: author_id,
        price_range: null,
      };
      const newUrl = `/project-Web2/user/index.php?page=product&author_id=${author_id}&current_page=${current_page}`;

      if (
        window.history.state?.author_id !== author_id ||
        window.history.state?.page !== current_page ||
        window.history.state?.type !== "author"
      ) {
        history.pushState(state, "", newUrl);
      }

      if (response["totalPage"] > 1) {
        attachPaginationEvents(function (current_page) {
          loadBookByAuthor(current_page, author_id);
        });
      }
      window.scrollTo({ top: 0, behavior: "smooth" });
    }
  };
  xhr.send();
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

// Ajax cho khoảng giá
let currSelectChecked = null;
function loadBookPriceRange(selectChecked, current_page) {
  // Nếu không có khoảng giá nào được chọn, chuyển về danh sách mặc định
  if (!selectChecked || selectChecked.length === 0) {
    loadPageData(1);
    return;
  }

  const xhr = new XMLHttpRequest();
  const priceRangeQuery = Array.isArray(selectChecked)
    ? selectChecked.join(",")
    : selectChecked;
  xhr.open(
    "GET",
    `/project-Web2/user/index.php?page=product&action=filter&price_range=${priceRangeQuery}&current_page=${current_page}`,
    true
  );
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      const response = JSON.parse(xhr.responseText);

      let data = handleData(response["products"]);
      let pagination =
        response["totalPage"] > 1
          ? handlePagination(current_page, response["totalPage"])
          : "";

      document.querySelector(".pagination").innerHTML = pagination;
      document.querySelector(".book_list").innerHTML = data;

      // Chuẩn hóa trạng thái
      const state = {
        type: "price",
        page: current_page,
        category_id: null,
        author_id: null,
        price_range: selectChecked,
      };
      // Chỉ hiển thị page và current_page trên URL
      const newUrl = `/project-Web2/user/index.php?page=product&current_page=${current_page}`;

      // Kiểm tra trạng thái hiện tại
      if (
        window.history.state?.price_range?.join(",") !== priceRangeQuery ||
        window.history.state?.page !== current_page ||
        window.history.state?.type !== "price"
      ) {
        history.pushState(state, "", newUrl);
      }

      if (response["totalPage"] > 1) {
        attachPaginationEvents(function (current_page) {
          loadBookPriceRange(selectChecked, current_page);
        });
      }
      window.scrollTo({ top: 0, behavior: "smooth" });
    }
  };
  xhr.send();
}

function attachFilterEvents() {
  const filters = document.querySelectorAll(".checkbox_price");
  filters.forEach((filter) => {
    filter.addEventListener("change", function () {
      var selectChecked = [];
      filters.forEach((filter) => {
        if (filter.checked) {
          selectChecked.push(filter.value);
        }
      });
      currSelectChecked = selectChecked;
      if (selectChecked.length === 0) {
        // Nếu không có checkbox nào được chọn, tải danh sách mặc định
        loadPageData(1);
      } else {
        // Nếu có checkbox được chọn, tải theo khoảng giá
        loadBookPriceRange(selectChecked, 1);
      }
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
  });
}

// Hàm tải kết quả tìm kiếm
function loadSearchResults(
  page,
  searchTerm,
  bookName,
  authorName,
  categoryName,
  priceRange
) {
  const bookList = document.querySelector(".book_list");
  const pagination = document.querySelector(".pagination");

  if (!bookList || !pagination) return;

  const queryParams = new URLSearchParams();
  if (searchTerm) queryParams.set("search", searchTerm);
  if (bookName) queryParams.set("book_name", bookName);
  if (authorName) queryParams.set("author_name", authorName);
  if (categoryName) queryParams.set("category_name", categoryName);
  if (priceRange) queryParams.set("price_range", priceRange);
  queryParams.set("current_page", page);

  const xhr = new XMLHttpRequest();
  xhr.open(
    "GET",
    `/project-Web2/user/index.php?page=product&action=search&search=${encodeURIComponent(
      searchTerm
    )}&current_page=${page}`,
    true
  );
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      try {
        const response = JSON.parse(xhr.responseText);
        console.log(response);
        window.displaySearchResults(response);
        const state = {
          type: "search",
          page: page,
          searchTerm: searchTerm,
          bookName: bookName,
          authorName: authorName,
          categoryName: categoryName,
          priceRange: priceRange,
        };
        const newUrl = `/project-Web2/user/index.php?page=product&search=${encodeURIComponent(
          searchTerm
        )}&current_page=${page}`;
        history.pushState(state, "", newUrl);
      } catch (e) {
        console.error(`Lỗi phân tích JSON: ${e}`);
      }
    }
  };
  xhr.send();
}
// Hàm hiển thị kết quả tìm kiếm
window.displaySearchResults = function (response) {
  const bookList = document.querySelector(".book_list");
  const pagination = document.querySelector(".pagination");

  bookList.innerHTML = response.products.length
    ? handleData(response.products)
    : `<p style="color: red; font-size: 24px; font-weight: bold; padding: 20px;">Không tìm thấy sản phẩm nào.</p>`;

  let paginationHtml =
    response.totalPage > 1
      ? handlePagination(response.currentPage, response.totalPage)
      : "";
  pagination.innerHTML = paginationHtml;

  if (response.totalPage > 1) {
    attachPaginationEvents(function (page) {
      loadSearchResults(page, response.searchTerm, "", "", "", "");
    });
  }

  window.scrollTo({ top: 0, behavior: "smooth" });
};

function toggleFilterBox() {
  const filterBox = document.querySelector(".box_filter");
  const toggleButton = document.querySelector(".box_cheatseat");

  if (toggleButton && filterBox) {
    toggleButton.addEventListener("click", function () {
      filterBox.classList.toggle("active");
    });
  }
}

function getParam(param) {
  const urlParams = new URLSearchParams(window.location.search);
  return urlParams.get(param);
}

document.addEventListener("DOMContentLoaded", function () {
  if (!window.location.href.includes("page=product")) return;

  hideShowSubbox();
  changeColorForPageItem();
  toggleFilterBox();
  attachCategoryEvents();
  attachAuthorEvents();
  attachFilterEvents();

  const category_id = getParam("category_id");
  const author_id = getParam("author_id");
  const search = getParam("search");
  const bookName = getParam("book_name");
  const authorName = getParam("author_name");
  const categoryName = getParam("category_name");
  const priceRange = getParam("price_range");
  const current_page = parseInt(getParam("current_page")) || 1;

  let state;
  let url;

  if (search || bookName || authorName || categoryName || priceRange) {
    state = {
      type: "search",
      page: current_page,
      searchTerm: search || "",
      bookName: bookName || "",
      authorName: authorName || "",
      categoryName: categoryName || "",
      priceRange: priceRange || "",
    };
    const queryParams = new URLSearchParams();
    if (search) queryParams.set("search", search);
    if (bookName) queryParams.set("book_name", bookName);
    if (authorName) queryParams.set("author_name", authorName);
    if (categoryName) queryParams.set("category_name", categoryName);
    if (priceRange) queryParams.set("price_range", priceRange);
    queryParams.set("current_page", current_page);
    url = `/project-Web2/user/index.php?page=product&${queryParams.toString()}`;
    loadSearchResults(
      current_page,
      search || "",
      bookName || "",
      authorName || "",
      categoryName || "",
      priceRange || ""
    );
  } else if (category_id) {
    state = {
      type: "category",
      page: current_page,
      category_id: category_id,
      author_id: null,
      price_range: null,
    };
    url = `/project-Web2/user/index.php?page=product&category_id=${category_id}&current_page=${current_page}`;
    loadBookByCategory(current_page, category_id);
  } else if (author_id) {
    state = {
      type: "author",
      page: current_page,
      category_id: null,
      author_id: author_id,
      price_range: null,
    };
    url = `/project-Web2/user/index.php?page=product&author_id=${author_id}&current_page=${current_page}`;
    loadBookByAuthor(current_page, author_id);
  } else {
    state = {
      type: "page",
      page: current_page,
      category_id: null,
      author_id: null,
      price_range: null,
    };
    url = `/project-Web2/user/index.php?page=product&current_page=${current_page}`;
    loadPageData(current_page);
  }

  history.replaceState(state, "", url);
});

// Xử lý sự kiện popstate
window.addEventListener("popstate", function (event) {
  const state = event.state;

  if (!state) {
    loadPageData(1);
    return;
  }

  const {
    type,
    page,
    category_id,
    author_id,
    price_range,
    searchTerm,
    bookName,
    authorName,
    categoryName,
  } = state;

  if (type === "search" && searchTerm) {
    loadSearchResults(
      page,
      searchTerm,
      bookName || "",
      authorName || "",
      categoryName || "",
      price_range || ""
    );
  } else if (type === "category" && category_id) {
    loadBookByCategory(page, category_id);
  } else if (type === "author" && author_id) {
    loadBookByAuthor(page, author_id);
  } else if (type === "price" && price_range) {
    loadBookPriceRange(price_range, page);
  } else {
    loadPageData(page);
  }
});
