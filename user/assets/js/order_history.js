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
          document.getElementById("order_detail_user_id").value =
            response["orderInfo"]["MaKH"];
          document.getElementById("order_detail_user_name").value =
            response["userInfo"]["TenND"];
          document.getElementById("order_detail_date").value =
            response["orderInfo"]["NgLap"];
          document.getElementById("order_detail_total").value =
            response["orderInfo"]["TongTien"];
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
              ? "Giao hàng thông thường"
              : "Giao hàng hỏa tốc";
          document.getElementById("order_detail_payment_method").value =
            response["orderInfo"]["PhThucTT"] == 1
              ? "COD"
              : "Chuyển khoản qua ngân hàng";

          let data = "";
          for (let i = 1; i <= response["orderDetails"].length; i++) {
            const html = `
                      <div class="book">
                          <span>${i}</span>
                          <span>${
                            response["orderDetails"][i - 1]["TenSach"]
                          }</span>
                          <span>${
                            response["orderDetails"][i - 1]["DonGia"]
                          }</span>
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
          // if (response.status == "success") {
          //   alert("Hủy đơn hàng thành công!");
          //   window.location.reload();
          // } else {
          //   alert("Hủy đơn hàng thất bại!");
          // }
        }
      };
      xhr.send(`orderId=${orderId}`);
    });
  });
}

document.addEventListener("DOMContentLoaded", function () {
  showOrderDetail();
  closeOrderDetail();
  updateStatusOrder();
});
