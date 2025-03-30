document
  .getElementById("loginForm")
  .addEventListener("submit", function (event) {
    event.preventDefault(); // Ngăn reload trang

    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();
    const errEmail = document.querySelector(".err_email");
    const errPassword = document.querySelector(".err_password");

    errEmail.innerHTML = "";
    errPassword.innerHTML = "";

    // Kiểm tra dữ liệu đầu vào
    if (!email) {
      errEmail.innerHTML = "Email không được bỏ trống";
      return;
    }

    if (!password) {
      errPassword.innerHTML = "Mật khẩu không được bỏ trống";
      return;
    }

    // Tạo đối tượng XMLHttpRequest
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../../controllers/xulylogin.php", true);

    // Không đặt Content-Type, vì FormData tự động thiết lập
    var formData = new FormData();
    formData.append("email", email);
    formData.append("password", password);

    // Xử lý phản hồi từ server
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) {
        if (xhr.status === 200) {
          console.log("Phản hồi từ server:", xhr.responseText);
          try {
            var response = JSON.parse(xhr.responseText);
            if (response.status === "error") {
              errEmail.innerHTML = response.message;
            } else if (response.status === "success") {
              window.location.href = "../../views/layouts/main_layout.php";
            }
          } catch (e) {
            console.error("Lỗi JSON từ server:", e);
          }
        } else {
          console.error("Lỗi kết nối server:", xhr.status);
        }
      }
    };

    xhr.send(formData);
  });
