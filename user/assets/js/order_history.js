function formatCurrency(amount) {
  const formatter = new Intl.NumberFormat("vi-VN", {
    style: "decimal", // Dùng decimal để kiểm soát ký hiệu
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
    useGrouping: true,
  });
  return formatter.format(amount) + " đ";
}

// Hàm xử lý dữ liệu lấy được chuyển thành html
function handleData(data) {
  let html = "";
  for (let i = 0; i < data.length; i++) {
    html += `
      <div class="item" data-id="${data[i]["MaHD"]}">
        <span>${data[i]["MaHD"]}</span>
        <span>${formatCurrency(data[i]["TongTien"])}</span>
        <span>${data[i]["PhThucTT"] == 1 ? "COD" : "Chuyển khoản"}</span>
        <span>${data[i]["PhThucVC"] == 1 ? "Thông thường" : "Hỏa tốc"}</span>
        <span>
          ${
            data[i]["TrangThaiDH"] == 1
              ? "Chờ duyệt"
              : data[i]["TrangThaiDH"] == 2
              ? "Đang giao"
              : data[i]["TrangThaiDH"] == 3
              ? "Đã giao"
              : "Đã hủy"
          }
        </span>
        <span class="btn_show_detail_order">
          <button class="showOrderDetail">Xem</button>
          ${
            data[i]["TrangThaiDH"] == 1
              ? '<button class="delOrder">Hủy</button>'
              : ""
          }
        </span>
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
  paginationLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
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
  });
}

// Hàm tải dữ liệu trang
function loadPageData(page) {
  const xhr = new XMLHttpRequest();
  xhr.open(
    "GET",
    `/project-Web2/user/index.php?page=order&action=showOrderHistoryAjax&current_page=${page}`,
    true
  );

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);

      // Xử lý dữ liệu hóa đơn
      let data = handleData(response["orders"]);
      let pagination =
        response["totalPages"] > 1
          ? handlePagination(page, response["totalPages"])
          : "";

      // Cập nhật giao diện
      document.querySelector("#order_history_body").innerHTML =
        data ||
        '<div style="color: red; font-size: 24px; margin-left: 10px; margin-top:20px">Không có đơn hàng nào</div>';
      document.querySelector(".pagination_box").innerHTML = pagination;

      // Chuẩn hóa trạng thái
      const state = {
        type: "page",
        page: page,
      };
      const newUrl = `/project-Web2/user/index.php?page=order&action=showOrderHistory&current_page=${page}`;

      if (
        window.history.state?.page !== page ||
        window.history.state?.type !== "page"
      ) {
        history.pushState(state, "", newUrl);
      }

      // Gắn sự kiện phân trang
      if (response["totalPages"] > 1) {
        attachPaginationEvents(function (newPage) {
          loadPageData(newPage);
        });
      }

      // Gắn sự kiện xem chi tiết và hủy đơn
      showOrderDetail();
      updateStatusOrder();
      closeOrderDetail();

      // Cuộn lên đầu trang
      window.scrollTo({ top: 0, behavior: "smooth" });
    }
  };

  xhr.send();
}

// Hàm tải dữ liệu hóa đơn đã lọc
let lastFilterParams = null; // Lưu tham số lọc gần nhất
function loadFilteredOrders(page, filterParams) {
  const xhr = new XMLHttpRequest();
  xhr.open(
    "POST",
    `/project-Web2/user/index.php?page=order&action=filterOrders`,
    true
  );
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        try {
          console.log(`phản hồi từ server: ${xhr.responseText}`);
          const response = JSON.parse(xhr.responseText);
          if (response.status === "error") {
            alert(response.message);
            return;
          }

          // Xử lý dữ liệu hóa đơn
          let data = handleData(response["orders"] || []);
          let pagination =
            response["totalPages"] > 1
              ? handlePagination(page, response["totalPages"] || 1)
              : "";

          // Cập nhật giao diện
          document.querySelector("#order_history_body").innerHTML =
            data ||
            '<div style="color: red; font-size: 24px; margin-left: 10px; margin-top:20px">Không có đơn hàng nào</div>';
          document.querySelector(".pagination_box").innerHTML = pagination;

          // Cập nhật lịch sử trình duyệt
          const state = {
            type: "filter",
            page: page,
            filterParams: filterParams,
          };
          const newUrl = `/project-Web2/user/index.php?page=order&action=filterOrders&current_page=${page}`;
          if (
            window.history.state?.page !== page ||
            window.history.state?.type !== "filter"
          ) {
            history.pushState(state, "", newUrl);
          }

          // Gắn sự kiện phân trang
          if (response["totalPages"] > 1) {
            attachPaginationEvents(function (newPage) {
              loadFilteredOrders(newPage, filterParams);
            });
          }

          // Gắn sự kiện xem chi tiết, hủy đơn, và đóng chi tiết
          showOrderDetail();
          updateStatusOrder();
          closeOrderDetail();

          // Cuộn lên đầu trang
          window.scrollTo({ top: 0, behavior: "smooth" });
        } catch (e) {
          console.error("Lỗi khi phân tích JSON:", e);
          alert("Đã xảy ra lỗi khi tải dữ liệu lọc.");
        }
      } else {
        alert("Lỗi server: Không thể tải dữ liệu lọc.");
      }
    }
  };

  const params = `orderId=${encodeURIComponent(
    filterParams.orderId
  )}&status=${encodeURIComponent(
    filterParams.status
  )}&fromDate=${encodeURIComponent(
    filterParams.dateBegin
  )}&toDate=${encodeURIComponent(filterParams.dateEnd)}&current_page=${page}`;
  xhr.send(params);
}

function showOrderDetail() {
  const btnShowOrderDetail = document.querySelectorAll(".showOrderDetail");

  btnShowOrderDetail.forEach((btn) => {
    btn.addEventListener("click", function () {
      // lấy mã hóa đơn từ class item chứa nó
      const orderId = this.closest(".item").getAttribute("data-id");
      console.log(`hóa đơn vừa chọn xem thêm là ${orderId}`);

      // gửi dữ liệu đi bằng ajax
      const xhr = new XMLHttpRequest();
      xhr.open(
        "POST",
        `/project-Web2/user/index.php?page=order&action=showOrderDetail`,
        true
      );
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
          const response = JSON.parse(xhr.responseText);
          console.log(response);

          //   hiện thị chi tiết hóa đơn ra màn hình
          document.getElementById("order_detail_id").value =
            response["orderInfo"]["MaHD"];
          document.getElementById("order_detail_feeShip").value =
            formatCurrency(response["orderInfo"]["PhiVC"]);
          document.getElementById("order_detail_user_name").value =
            response["userInfo"]["TenND"];
          document.getElementById("order_detail_date").value =
            response["orderInfo"]["NgLap"];
          document.getElementById("order_detail_total").value = formatCurrency(
            response["orderInfo"]["TongTien"]
          );
          document.getElementById("order_detail_phone").value =
            response["orderInfo"]["SDT"];
          document.getElementById("order_detail_status").value =
            response["orderInfo"]["TrangThaiDH"] == 1
              ? "Chờ duyệt"
              : response["orderInfo"]["TrangThaiDH"] == 2
              ? "Đang giao"
              : response["orderInfo"]["TrangThaiDH"] == 3
              ? "Đã giao"
              : "Đã hủy";
          document.getElementById("order_detail_address").value =
            response["orderInfo"]["DiaChiGiaoHang"];
          document.getElementById("order_detail_ship_method").value =
            response["orderInfo"]["PhThucVC"] == 1
              ? "Giao hàng tiêu chuẩn"
              : "Giao hàng hỏa tốc";
          document.getElementById("order_detail_payment_method").value =
            response["orderInfo"]["PhThucTT"] == 1
              ? "Thanh toán khi nhận hàng"
              : "Thanh toán bằng chuyển khoản ngân hàng";

          let data = "";
          for (let i = 1; i <= response["orderDetails"].length; i++) {
            const html = `
                      <div class="book">
                          <span>${i}</span>
                          <span>${
                            response["orderDetails"][i - 1]["TenSach"]
                          }</span>
                          <span>${formatCurrency(
                            response["orderDetails"][i - 1]["DonGia"]
                          )}</span>
                          <span>${
                            response["orderDetails"][i - 1]["SoLg"]
                          }</span>
                      </div>`;
            data += html;
          }
          console.log(`data: ${data}`);
          document.getElementById("book_list").innerHTML = data;

          document.querySelector(".order_detail_box").style.display = "block";
          document.querySelector(".order_history_box").style.display = "none";
        }
      };
      xhr.send(`orderId=${orderId}`);
    });
  });
}

function closeOrderDetail() {
  const btnCloseOrderDetail = document.getElementById("close_order_detail");
  console.log(btnCloseOrderDetail);
  btnCloseOrderDetail.addEventListener("click", function () {
    document.querySelector(".order_detail_box").style.display = "none";
    document.querySelector(".order_history_box").style.display = "block";
  });
}

function updateStatusOrder() {
  const btnCancelOrder = document.querySelectorAll(".delOrder");

  // gắn sự kiện click cho từng nút hủy
  btnCancelOrder.forEach((btn) => {
    btn.addEventListener("click", function (e) {
      e.preventDefault();
      const orderId = this.closest(".item").getAttribute("data-id");
      console.log(`huy hoa don co ma: ${orderId}`);

      const xhr = new XMLHttpRequest();
      xhr.open(
        "POST",
        "/project-Web2/user/index.php?page=order&action=cancelOrder",
        true
      );
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
          const response = JSON.parse(xhr.responseText);
          console.log(response);
          if (response.status == "success") {
            alert(response.message);
            window.location.reload();
          } else {
            alert(response.message);
          }
        }
      };
      xhr.send(`orderId=${orderId}`);
    });
  });
}

function searchOrder() {
  document
    .getElementById("btn_order_filter")
    .addEventListener("click", function (e) {
      e.preventDefault();

      // Lấy thông tin cần lọc
      const orderId = document.getElementById("order_id").value;
      const status = document.getElementById("status_order").value;
      const dateBegin = document.getElementById("order_date_begin").value;
      const dateEnd = document.getElementById("order_date_end").value;

      console.log(
        `Mã: ${orderId} - Trạng thái: ${status} - Từ: ${dateBegin} đến ${dateEnd}`
      );

      // Lưu tham số lọc
      lastFilterParams = {
        orderId: orderId,
        status: status,
        dateBegin: dateBegin,
        dateEnd: dateEnd,
      };

      // Tải dữ liệu lọc cho trang 1
      loadFilteredOrders(1, lastFilterParams);
    });
}

function getParam(param) {
  const urlParams = new URLSearchParams(window.location.search);
  return urlParams.get(param);
}

function toggleFilterBox() {
  const filterBox = document.querySelector(".order_filter form");
  const toggleButton = document.querySelector(".filter_icon");

  if (toggleButton && filterBox) {
    toggleButton.addEventListener("click", function () {
      filterBox.classList.toggle("active");
    });
  }
}

// Khi trang tải xong
document.addEventListener("DOMContentLoaded", function () {
  searchOrder();
  toggleFilterBox();

  const currentPage = parseInt(getParam("current_page")) || 1;
  const action = getParam("action");

  console.log(`Trang hiện tại: ${currentPage}, Action: ${action}`);

  let state;
  let url;

  if (action === "filterOrders" && lastFilterParams) {
    state = {
      type: "filter",
      page: currentPage,
      filterParams: lastFilterParams,
    };
    url = `/project-Web2/user/index.php?page=order&action=filterOrders&current_page=${currentPage}`;
    loadFilteredOrders(currentPage, lastFilterParams);
  } else {
    state = {
      type: "page",
      page: currentPage,
    };
    url = `/project-Web2/user/index.php?page=order&action=showOrderHistory&current_page=${currentPage}`;
    loadPageData(currentPage);
  }

  // Đẩy trạng thái ban đầu vào lịch sử
  history.replaceState(state, "", url);
});

// Xử lý sự kiện popstate
window.addEventListener("popstate", function (event) {
  const state = event.state;
  const currentPage = parseInt(getParam("current_page")) || 1;

  // Chỉ xử lý nếu trang hiện tại là page=order
  if (getParam("page") === "order") {
    if (state && state.type === "filter" && state.filterParams) {
      lastFilterParams = state.filterParams;
      loadFilteredOrders(state.page, state.filterParams);
    } else {
      loadPageData(currentPage);
    }
  }
});
