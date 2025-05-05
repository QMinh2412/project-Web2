const checkoutForm = document.querySelector("#formInfo");
const confirmContainer = document.getElementById("container_confirm");
const confirmForm = document.querySelector(
  `#confirmInfo button[type="submit"]`
);
const closeButton = document.getElementById("close");
const transferForm = document.getElementById("container_transfer_payment");
const closeTransferPayment = document.getElementById("back");
const btnFinal = document.getElementById("btn_confirm_payment");

function formatCurrency(amount) {
  const formatter = new Intl.NumberFormat("vi-VN", {
    style: "decimal", // Dùng decimal để kiểm soát ký hiệu
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
    useGrouping: true,
  });
  return formatter.format(amount) + " đ";
}

function checkInfoEmpty() {
  const name = document.getElementById("txtName");
  const phone = document.getElementById("txtPhone");
  const address = document.getElementById("txtAddress");
  const note = document.getElementById("txtNote");

  if (!name.value) {
    alert("Vui lòng nhập tên người nhận");
    name.select();
    name.focus();
    return false;
  }

  if (!phone.value) {
    alert("Vui lòng nhập số điện thoại nhận hàng");
    phone.select();
    phone.focus();
    return false;
  }

  if (!address.value) {
    alert("Vui lòng nhập địa chỉ nhận hàng");
    address.select();
    address.focus();
    return false;
  }

  return true;
}

function hiddenConfirmForm() {
  confirmContainer.addEventListener("click", (e) => {
    if (e.target === confirmContainer) {
      e.preventDefault();
      confirmContainer.style.display = "none";
      document.body.style.overflow = "auto";
    }
  });

  closeButton.addEventListener("click", () => {
    alert("vừa nhấn nút hủy");
    console.log("Đã nhấn nút Hủy");
    confirmContainer.style.display = "none";
    document.body.style.overflow = "auto";
  });
}

function showConfirmForm() {
  checkoutForm.addEventListener("submit", (e) => {
    e.preventDefault();

    if (!checkInfoEmpty()) {
      return;
    }

    const name = document.getElementById("txtName").value;
    const phone = document.getElementById("txtPhone").value;
    const address = document.getElementById("txtAddress").value;
    const note = document.getElementById("txtNote").value;
    const shippingMethod = document.querySelector(
      'input[name="shipping_method"]:checked'
    ).value;
    const paymentMethod = document.querySelector(
      'input[name="payment_method"]:checked'
    ).value;
    const feeShip = document.querySelector(
      ".fee_order span:last-child"
    ).textContent;
    const totalBill = document.querySelector(
      ".total_bill span:last-child"
    ).textContent;
    document.getElementById("fee").innerHTML = feeShip;
    document.getElementById("total_bill").innerHTML = totalBill;

    try {
      document.querySelector(".name_confirm i").textContent = name;
      document.querySelector(".phone_confirm i").textContent = phone;
      document.querySelector(".address_confirm i").textContent = address;
      document.querySelector(".note_confirm i").textContent = note || "";
      document.querySelector(".shipping_method_confirm i").textContent =
        shippingMethod === "1" ? "Giao hàng tiêu chuẩn" : "Giao hàng hỏa tốc";
      document.querySelector(".payment_method_confirm i").textContent =
        paymentMethod === "1"
          ? "Thanh toán khi nhận hàng"
          : "Thanh toán bằng chuyển khoản ngân hàng";

      // console.log("Trước khi hiển thị form xác nhận");
      confirmContainer.style.display = "flex";
      document.body.style.overflow = "hidden"; // Ngăn cuộn khi form xác nhận hiển thị
      // console.log("Đã hiển thị form xác nhận");
    } catch (error) {
      console.error("Lỗi khi cập nhật form xác nhận:", error);
    }
  });
}

function handleFeeShipAjax() {
  const totalPrice = document.querySelector(".total_price_order .total_price");
  const shipMethod = document.getElementsByName("shipping_method");

  shipMethod.forEach((inputRadio) => {
    inputRadio.addEventListener("click", function () {
      console.log("Đang chọn phương thức vận chuyển");
      console.log(`Phương thức vận chuyển: ${inputRadio.value}`);

      let priceText = totalPrice.textContent.replace(/[^\d]/g, "");
      let priceValue = parseInt(priceText);

      console.log(`Tổng giá trị: ${priceValue}`);

      const xhr = new XMLHttpRequest();
      xhr.open(
        "GET",
        `/project-Web2/user/index.php?page=checkout&action=calculateFeeShip&shipMethod=${this.value}&totalPrice=${priceValue}`, // Gửi giá trị dạng nguyên
        true
      );

      xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
          try {
            const response = JSON.parse(xhr.responseText);
            console.log(response);

            // Cập nhật phí vận chuyển
            document.querySelector(".fee_order span:last-child").textContent =
              formatCurrency(response);
            // Cập nhật tổng hóa đơn
            document.querySelector(".total_bill span:last-child").textContent =
              formatCurrency(priceValue + response);
            // Cập nhật phí vận chuyển ở phần khác (nếu có)
            document.querySelector(
              ".fee_order:last-child span:last-child"
            ).textContent = formatCurrency(response);
          } catch (e) {
            console.error(`Lỗi phân tích JSON: ${e}`);
          }
        }
      };

      xhr.send();
    });
  });
}

function getDataFromForm() {
  const url = new URLSearchParams(window.location.search);
  const source = url.get("source");

  const name = document.getElementById("txtName").value;
  const phone = document.getElementById("txtPhone").value;
  const address = document.getElementById("txtAddress").value;
  const note = document.getElementById("txtNote").value;
  const shippingMethod = document.querySelector(
    'input[name="shipping_method"]:checked'
  ).value;
  const paymentMethod = document.querySelector(
    'input[name="payment_method"]:checked'
  ).value;
  const feeShipText = document.querySelector(
    ".fee_order span:last-child"
  ).textContent;
  const totalBillText = document.querySelector(
    ".total_bill span:last-child"
  ).textContent;
  const feeShip = parseInt(feeShipText.replace(/[^0-9]/g, "")) || 0;
  const total_bill = parseInt(totalBillText.replace(/[^0-9]/g, "")) || 0;

  const data = new URLSearchParams({
    name: name,
    phone: phone,
    address: address,
    note: note,
    shippingMethod: shippingMethod,
    paymentMethod: paymentMethod,
    total_bill: total_bill,
    feeShip: feeShip,
    source: source,
  }).toString();

  return [data, paymentMethod];
}

function sendDataByAjax(data) {
  const xhr = new XMLHttpRequest();
  xhr.open(
    "POST",
    `/project-Web2/user/index.php?page=checkout&action=placeOrder`,
    true
  );
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      console.log(`Đã nhận phản hồi từ máy chủ: ${xhr.responseText}`);
      try {
        const response = JSON.parse(xhr.responseText);
        console.log(response);
        if (response.status === "success") {
          alert(response.message);
          window.location.href =
            "/project-Web2/user/index.php?page=order&action=showOrderHistory";
        } else {
          alert("Lỗi: " + response.message);
        }
      } catch (error) {
        console.error("Lỗi phân tích JSON:", error);
        alert("Đã xảy ra lỗi khi xử lý đơn hàng.");
      }
    }
  };

  xhr.send(data);
}

function handleCheckoutFromTransferPayment() {
  btnFinal.addEventListener("click", (e) => {
    e.preventDefault();

    const data = getDataFromForm();
    console.log(`du lieu gui di: ${data}`);

    sendDataByAjax(data[0]);
  });
}

function handleConfirmOrderAjax() {
  confirmForm.addEventListener("click", (e) => {
    e.preventDefault();

    const data = getDataFromForm();
    console.log("Dữ liệu gửi đi:", data);

    if (data[1] === "1") {
      sendDataByAjax(data[0]);
    } else {
      document.querySelector("#name span").innerHTML =
        document.getElementById("txtName").value;
      document.querySelector("#phone span").innerHTML =
        document.getElementById("txtPhone").value;
      document.querySelector("#address span").innerHTML =
        document.getElementById("txtAddress").value;
      document.querySelector("#total_order span").innerHTML =
        document.querySelector(".total_bill span:last-child").textContent;

      transferForm.style.display = "flex";
      document.body.style.overflow = "hidden";

      handleCheckoutFromTransferPayment();
    }
  });
}

function closePaymentForm() {
  closeTransferPayment.addEventListener("click", (e) => {
    e.preventDefault();
    console.log("Đã nhấn nút Hủy");
    transferForm.style.display = "none";
    document.body.style.overflow = "hidden"; // Khôi phục cuộn
  });
}

document.addEventListener("DOMContentLoaded", () => {
  showConfirmForm();
  hiddenConfirmForm();
  handleFeeShipAjax();
  handleConfirmOrderAjax();
  closePaymentForm();
});
