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
      document.getElementById("email").focus();
      return;
    }

    if (!password) {
      errPassword.innerHTML = "Mật khẩu không được bỏ trống";
      document.getElementById("password").focus();
      return;
    }

    // Tạo đối tượng XMLHttpRequest
    var xhr = new XMLHttpRequest();
    xhr.open(
      "POST",
      "/project-Web2/user/index.php?page=account&action=login",
      true
    );
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Không đặt Content-Type, vì FormData tự động thiết lập
    // var formData = new FormData();
    // formData.append("email", email);
    // formData.append("password", password);

    // Xử lý phản hồi từ server
    xhr.onreadystatechange = function () {
      // if (xhr.readyState === 4) {
      //   if (xhr.status === 200) {
      //     console.log("Phản hồi từ server:", xhr.responseText);
      //     try {
      //       var response = JSON.parse(xhr.responseText);
      //       if (response.status === "error") {
      //         errEmail.innerHTML = response.message;
      //       } else if (response.status === "success") {
      //         window.location.href = "/project-Web2/user/index.php";
      //       }
      //     } catch (e) {
      //       console.error("Lỗi JSON từ server:", e);
      //     }
      //   } else {
      //     console.error("Lỗi kết nối server:", xhr.status);
      //   }
      // }
      if (xhr.readyState === 4 && xhr.status === 200) {
        console.log(xhr.responseText); // Kiểm tra dữ liệu nhận về
        let response = JSON.parse(xhr.responseText);

        if (response.status === "error") {
          if (response.field === "email") {
            document.querySelector(".err_email").innerHTML = response.message;
          }
          if (response.field === "password") {
            document.querySelector(".err_password").innerHTML =
              response.message;
          }
        } else if (response.status === "success") {
          window.location.href = "/project-Web2/user/index.php";
        }
      }
    };

    let data = `email=${encodeURIComponent(
      email
    )}&password=${encodeURIComponent(password)}`;
    xhr.send(data);
  });
