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
  document.getElementById("basic_search").addEventListener("submit", (e) => {
    e.preventDefault();
    const keySearch = document.getElementById("search_box").value.trim();
    console.log(`từ khóa vừa tìm: ${keySearch}`);

    const xhr = new XMLHttpRequest();
    xhr.open(
      "GET",
      `/project-Web2/user/index.php?page=product&action=search&key=${keySearch}`,
      true
    );
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
        try {
          const response = JSON.parse(xhr.responseText);
          // Gọi hàm trong product.js để hiển thị kết quả
          window.displaySearchResults(response);
          // Cập nhật URL và lịch sử trình duyệt
          const state = {
            type: "search",
            searchTerm: searchTerm,
            bookName: bookName,
            authorName: authorName,
            categoryName: categoryName,
            priceRange: priceRange,
            page: 1,
          };
          const newUrl = `/project-Web2/user/index.php?page=product&key=${encodeURIComponent(
            keySearch
          )}`;
          history.pushState(state, "", newUrl);
        } catch (e) {
          console.error(`Lỗi phân tích json: ${e}`);
        }
      }
    };
    xhr.send();
  });
}

// Gọi các hàm khi trang được tải
document.addEventListener("DOMContentLoaded", function () {
  toggleAdvancedSearch();
  hiddenShowBoxAccount();
  searchAjax();
  handleRangeInput();
});
