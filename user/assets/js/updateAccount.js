function updateAccountAjax() {
  document.querySelector("#btnSubmit").addEventListener("click", (e) => {
    e.preventDefault();

    // Lấy form element
    const form = document.getElementById("update-account-form");
    const formData = new FormData(form);

    // Kiểm tra định dạng email và phone
    const email = formData.get("email");
    const phone = formData.get("phone");
    const regEmail = /@gmail.com$/;
    const regPhone = /^0\d{9}$/;

    if (!regEmail.test(email)) {
      alert("Email không đúng định dạng!");
      document.getElementById("email").select();
      document.getElementById("email").focus();
      return;
    }
    if (!regPhone.test(phone)) {
      alert("Số điện thoại không đúng định dạng");
      document.getElementById("phone").select();
      document.getElementById("phone").focus();
      return;
    }

    // Gửi dữ liệu bằng AJAX
    const xhr = new XMLHttpRequest();
    xhr.open(
      "POST",
      "/project-Web2/user/index.php?page=account&action=updateAccountAjax",
      true
    );

    // Không cần set Content-Type, FormData sẽ tự động set thành multipart/form-data
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4) {
        if (xhr.status == 200) {
          const response = JSON.parse(xhr.responseText);
          console.log(`response: ${response}`);

          if (response.status == "success") {
            alert(response.message);
            window.location.href = "/project-Web2/user/index.php";
          } else {
            alert(response.message);
            return;
          }
        }
      }
    };

    // Gửi FormData
    xhr.send(formData);
  });
}

document.addEventListener("DOMContentLoaded", function () {
  updateAccountAjax();
});
