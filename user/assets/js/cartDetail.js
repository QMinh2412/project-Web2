function formatCurrency(amount) {
  const formatter = new Intl.NumberFormat("vi-VN", {
    style: "decimal",
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
    useGrouping: true,
  });
  return formatter.format(amount) + " đ";
}

// Hàm gửi yêu cầu AJAX chung
function sendAjaxRequest(method, url, data, callback) {
  const xhr = new XMLHttpRequest();
  xhr.open(method, url, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  const body = new URLSearchParams(data).toString();

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        try {
          const response = JSON.parse(xhr.responseText);
          callback(response, null);
        } catch (e) {
          callback(
            null,
            new Error("Invalid JSON response: " + xhr.responseText)
          );
        }
      } else {
        callback(null, new Error("Request failed with status: " + xhr.status));
      }
    }
  };
  xhr.send(body);
}

// Cập nhật tổng số lượng và giá
function updateTotal() {
  let totalBook = 0;
  let totalPrice = 0;

  document.querySelectorAll(".book_in_cart").forEach((item) => {
    const quantity = parseInt(item.querySelector(".quantity").textContent);
    const price = parseInt(
      item.querySelector(".book_price").textContent.replace(/[^\d]/g, "")
    );
    console.log(`gia ban: ${price}`);
    const isChecked = item.querySelector(".selected").checked;

    if (isChecked) {
      totalBook += quantity;
      totalPrice += quantity * price;
    }
  });

  document.querySelector(
    ".total_book"
  ).innerHTML = `${totalBook} <span>sản phẩm</span>`;
  document.querySelector(".total_price").textContent = `${formatCurrency(
    totalPrice
  )}`;
}

// Xử lý sự kiện checkbox chọn sản phẩm
function handleCheckboxChange(checkbox) {
  const bookItem = checkbox.closest(".book_in_cart");
  const bookId = bookItem.dataset.id;
  const status = checkbox.checked ? 1 : 0;

  sendAjaxRequest(
    "POST",
    "/project-Web2/user/index.php?page=cart&action=updateStatus",
    { bookId, status },
    (response, error) => {
      if (error) {
        alert("Lỗi khi cập nhật trạng thái sản phẩm: " + error.message);
        console.error(error);
        return;
      }
      if (response.status) {
        updateTotal();
      } else {
        alert(response.message || "Lỗi không xác định từ server");
      }
    }
  );
}

// Xử lý sự kiện nút xóa sản phẩm
function handleDeleteClick(button) {
  const bookItem = button.closest(".book_in_cart");
  const bookId = bookItem.dataset.id;

  sendAjaxRequest(
    "POST",
    "/project-Web2/user/index.php?page=cart&action=remove",
    { bookId },
    (response, error) => {
      if (error) {
        alert("Lỗi khi xóa sản phẩm ra khỏi giỏ hàng.");
        console.error(error);
        return;
      }
      if (response.success) {
        bookItem.remove();
        updateTotal();
        if (!document.querySelector(".book_in_cart")) {
          document.querySelector(".books_in_cart").innerHTML = `
                      <div style="color: red; font-size: 24px; font-weight: bold; padding: 20px;">
                          Giỏ hàng của bạn đang trống
                      </div>`;
        }
      } else {
        alert(response.message);
      }
    }
  );
}

// Xử lý sự kiện thay đổi số lượng
function handleQuantityChange(button, isIncrement) {
  const bookItem = button.closest(".book_in_cart");
  const quantitySpan = bookItem.querySelector(".quantity");
  let quantity = parseInt(quantitySpan.textContent);
  const bookId = bookItem.dataset.id;

  if (!isIncrement && quantity <= 1) return;
  quantity = isIncrement ? quantity + 1 : quantity - 1;

  sendAjaxRequest(
    "POST",
    "/project-Web2/user/index.php?page=cart&action=updateQuantity",
    { bookId, quantity },
    (response, error) => {
      if (error) {
        alert("Lỗi khi cập nhật số lượng.");
        console.error(error);
        return;
      }
      if (response.success) {
        quantitySpan.textContent = quantity;
        updateTotal();
      } else {
        alert(response.message);
      }
    }
  );
}

function handleCheckoutClick() {
  document.querySelector(".btn_submit").addEventListener("click", (e) => {
    e.preventDefault();
    const xhr = new XMLHttpRequest();
    xhr.open(
      "POST",
      "/project-Web2/user/index.php?page=product&action=checkout"
    );
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
        const response = JSON.parse(xhr.responseText);
        console.log(response);

        if (response.status) {
          alert(response.message);
          window.location.href =
            "/project-Web2/user/index.php?page=checkout&action=showCheckout&source=cart";
        } else {
          alert(response.message);
        }
      }
    };

    xhr.send();
  });
}

// Gán sự kiện cho các phần tử
function initializeEventListeners() {
  document.querySelectorAll(".selected").forEach((checkbox) => {
    checkbox.addEventListener("change", () => handleCheckboxChange(checkbox));
  });

  document.querySelectorAll(".book_in_cart button").forEach((button) => {
    button.addEventListener("click", () => handleDeleteClick(button));
  });

  document.querySelectorAll(".minus_icon").forEach((button) => {
    button.addEventListener("click", () => handleQuantityChange(button, false));
  });

  document.querySelectorAll(".plus_icon").forEach((button) => {
    button.addEventListener("click", () => handleQuantityChange(button, true));
  });
}

document.addEventListener("DOMContentLoaded", function () {
  handleCheckoutClick();
  initializeEventListeners();
  updateTotal();
});
