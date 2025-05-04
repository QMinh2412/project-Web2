// Hàm định dạng số với dấu phẩy
function formatNumber(number) {
  return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

// Hàm xử lý thanh range
function handleRangeInput() {
  const rangeInput = document.querySelector("#price_range");
  const rangeValue = document.querySelector(".range-value");

  // Hàm cập nhật giá trị và vị trí
  function updateRange() {
    const value = rangeInput.value;
    const min = rangeInput.min || 0;
    const max = rangeInput.max || 1000000;

    // Cập nhật giá trị hiển thị
    rangeValue.textContent = formatNumber(value);

    // Tính toán vị trí của span
    const rangeWidth = rangeInput.offsetWidth;
    const thumbWidth = 16;
    const percent = (value - min) / (max - min);
    const leftPosition = percent * (rangeWidth - thumbWidth) + thumbWidth / 2;
    console.log(`percent: ${percent}`);

    // Đặt vị trí của span
    rangeValue.style.left = `${leftPosition}px`;

    // Cập nhật màu track bằng linear-gradient
    rangeInput.style.background = `linear-gradient(to right, #a75026 ${
      percent * 100
    }%, #fff ${percent * 100}%)`;
  }

  // Cập nhật ngay khi tải trang
  updateRange();

  // Xử lý khi kéo thanh range
  rangeInput.addEventListener("input", updateRange);
}

// Hàm xử lý ẩn/hiện form tìm kiếm nâng cao với hiệu ứng
function toggleAdvancedSearch() {
  const advancedButton = document.querySelector("#advanced");
  const advancedSearchBox = document.querySelector("#advanced_search_box");
  const closeButton = document.querySelector("#close");

  // Xử lý khi click vào nút "Nâng cao"
  advancedButton.addEventListener("click", () => {
    advancedSearchBox.classList.toggle("active");
  });

  // Xử lý khi click vào nút "Hủy" để đóng form
  closeButton.addEventListener("click", () => {
    advancedSearchBox.classList.remove("active");
  });
}

// Hàm xử lý ẩn/hiện menu tài khoản
function hiddenShowBoxAccount() {
  document.querySelector(".account_box").addEventListener("click", () => {
    const subMenu = document.querySelector(".sub_menu");
    if (subMenu.style.display === "none") {
      subMenu.style.display = "block";
    } else {
      subMenu.style.display = "none";
    }
  });
}

// Hàm xử lý tìm kiếm AJAX
function searchAjax() {
  const basicSearchForm = document.getElementById("basic_search");
  const advancedSearchForm = document.getElementById("advanced_search");

  // Tìm kiếm cơ bản
  if (basicSearchForm) {
    basicSearchForm.addEventListener("submit", (e) => {
      e.preventDefault();
      const keySearch = document.getElementById("search_box").value.trim();

      if (!keySearch) {
        alert("Vui lòng nhập từ khóa tìm kiếm!");
        document.getElementById("search_box").focus();
        return;
      }

      const isProductPage = window.location.href.includes("page=product");

      if (isProductPage && typeof window.displaySearchResults === "function") {
        // Thực hiện AJAX nếu ở trang sản phẩm
        const xhr = new XMLHttpRequest();
        xhr.open(
          "GET",
          `/project-Web2/user/index.php?page=product&action=search&search=${encodeURIComponent(
            keySearch
          )}`,
          true
        );
        xhr.onreadystatechange = function () {
          if (xhr.readyState === 4 && xhr.status === 200) {
            try {
              const response = JSON.parse(xhr.responseText);
              window.displaySearchResults(response);
              const state = {
                type: "search",
                searchTerm: keySearch,
                page: 1,
              };
              const newUrl = `/project-Web2/user/index.php?page=product&search=${encodeURIComponent(
                keySearch
              )}`;
              history.pushState(state, "", newUrl);
            } catch (e) {
              console.error(`Lỗi phân tích JSON: ${e}`);
            }
          }
        };
        xhr.send();
      } else {
        // Chuyển hướng đến trang sản phẩm nếu không ở trang sản phẩm
        window.location.href = `/project-Web2/user/index.php?page=product&search=${encodeURIComponent(
          keySearch
        )}`;
      }
    });
  }

  // Tìm kiếm nâng cao
  if (advancedSearchForm) {
    advancedSearchForm.addEventListener("submit", (e) => {
      e.preventDefault();
      const bookName = document.getElementById("book_name").value.trim();
      const authorName = document.getElementById("author_name").value.trim();
      const categoryName = document
        .getElementById("category_name")
        .value.trim();
      const priceRange = document.getElementById("price_range").value;

      if (!bookName && !authorName && !categoryName && !priceRange) {
        alert("Vui lòng nhập ít nhất một tiêu chí tìm kiếm!");
        return;
      }

      const isProductPage = window.location.href.includes("page=product");

      const queryParams = new URLSearchParams();
      if (bookName) queryParams.set("search", bookName);
      if (authorName) queryParams.set("author_name", authorName);
      if (categoryName) queryParams.set("category_name", categoryName);
      if (priceRange) queryParams.set("price_range", priceRange);

      if (isProductPage && typeof window.displaySearchResults === "function") {
        // Thực hiện AJAX nếu ở trang sản phẩm
        const xhr = new XMLHttpRequest();
        xhr.open(
          "GET",
          `/project-Web2/user/index.php?page=product&action=search&${queryParams.toString()}`,
          true
        );
        xhr.onreadystatechange = function () {
          if (xhr.readyState === 4 && xhr.status === 200) {
            try {
              const response = JSON.parse(xhr.responseText);
              window.displaySearchResults(response);
              const state = {
                type: "search",
                searchTerm: bookName,
                bookName,
                authorName,
                categoryName,
                priceRange,
                page: 1,
              };
              const newUrl = `/project-Web2/user/index.php?page=product&${queryParams.toString()}`;
              history.pushState(state, "", newUrl);
            } catch (e) {
              console.error(`Lỗi phân tích JSON: ${e}`);
            }
          }
        };
        xhr.send();
      } else {
        // Chuyển hướng đến trang sản phẩm nếu không ở trang sản phẩm
        window.location.href = `/project-Web2/user/index.php?page=product&${queryParams.toString()}`;
      }
    });
  }
}

// Gọi các hàm khi trang được tải
document.addEventListener("DOMContentLoaded", function () {
  toggleAdvancedSearch();
  hiddenShowBoxAccount();
  searchAjax();
  handleRangeInput();
});
