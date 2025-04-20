document.addEventListener("DOMContentLoaded", () => {
  const checkoutForm = document.querySelector('form[action*="placeOrder"]');
  const confirmContainer = document.getElementById("container_confirm");
  const confirmForm = document.getElementById("confirmInfo");
  const closeButton = document.getElementById("close");

  if (!checkoutForm) {
    console.error("Checkout form not found");
    return;
  }

  confirmContainer.addEventListener("click", (e) => {
    if (e.target === confirmContainer) {
      e.preventDefault(); // Ngăn sự kiện click truyền xuống
      confirmContainer.style.display = "none"; // Đóng form khi click vào nền
      document.body.style.overflow = "auto"; // Khôi phục cuộn
    }
  });

  checkoutForm.addEventListener("submit", (e) => {
    e.preventDefault();
    console.log("Đã click vào đặt hàng");

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
    console.log("Dữ liệu:", {
      name,
      phone,
      address,
      note,
      shippingMethod,
      paymentMethod,
    });

    try {
      document.querySelector(".name_confirm").textContent = name;
      document.querySelector(".phone_confirm").textContent = phone;
      document.querySelector(".address_confirm").textContent = address;
      document.querySelector(".note_confirm").textContent = note || "Không có";
      document.querySelector(".shipping_method_confirm").textContent =
        shippingMethod === "1" ? "Giao hàng thông thường" : "Giao hàng hỏa tốc";
      document.querySelector(".payment_method_confirm").textContent =
        paymentMethod === "1"
          ? "Thanh toán khi nhận hàng"
          : "Thanh toán bằng mã QR";

      console.log("Trước khi hiển thị form xác nhận");
      confirmContainer.style.display = "flex";
      document.body.style.overflow = "hidden"; // Ngăn cuộn khi form xác nhận hiển thị
      console.log("Đã hiển thị form xác nhận");
    } catch (error) {
      console.error("Lỗi khi cập nhật form xác nhận:", error);
    }
  });

  closeButton.addEventListener("click", (e) => {
    e.preventDefault();
    console.log("Đã nhấn nút Hủy");
    confirmContainer.style.display = "none";
    document.body.style.overflow = "auto"; // Khôi phục cuộn
  });

  confirmForm.addEventListener("submit", (e) => {
    e.preventDefault();
    console.log("Xác nhận đặt hàng");
    document.body.style.overflow = "auto"; // Khôi phục cuộn trước khi submit
    checkoutForm.submit();
  });
});
