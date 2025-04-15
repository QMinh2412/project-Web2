function togglePassword(inputId) {
  const input = document.getElementById(inputId);
  const type = input.getAttribute("type") === "password" ? "text" : "password";
  //   this.innerHTML == `<i class="fa-regular fa-eye"></i>`
  //     ? `<i class="fa-regular fa-eye-slash"></i>`
  //     : `<i class="fa-regular fa-eye"></i>`;
  input.setAttribute("type", type);
}

function changepasswordAjax() {
  document.getElementById("btn_submit").addEventListener("click", function (e) {
    e.preventDefault();

    const old_pwd = document.getElementById("old_password");
    const new_pwd = document.getElementById("new_password");
    const confirm_pwd = document.getElementById("confirm_password");

    const xhr = new XMLHttpRequest();
    xhr.open(
      "POST",
      "/project-Web2/user/index.php?page=account&action=changepasswordAjax",
      true
    );
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
        const response = JSON.parse(xhr.responseText);
        console.log(response);

        document.querySelector(".err_old_pass").innerHTML = "";
        document.querySelector(".err_new_pass").innerHTML = "";
        document.querySelector(".err_confirm_pass").innerHTML = "";

        if (response.status == "error") {
          if (response.field == "old_password") {
            document.querySelector(".err_old_pass").innerHTML =
              response.message;
            old_pwd.select();
            old_pwd.focus();
          } else if (response.field == "new_password") {
            document.querySelector(".err_new_pass").innerHTML =
              response.message;
            new_pwd.select();
            new_pwd.focus();
          } else if (response.field == "confirm_password") {
            document.querySelector(".err_confirm_pass").innerHTML =
              response.message;
            confirm_pwd.select();
            confirm_pwd.focus();
          } else {
            alert(response.message);
          }
        } else {
          alert(response.message);
          window.location.href = "/project-Web2/user/index.php";
        }
      }
    };

    let data = "";
    if (old_pwd.value) data += `old_password=${old_pwd.value}&`;
    if (new_pwd.value) data += `new_password=${new_pwd.value}&`;
    if (confirm_pwd.value) data += `confirm_password=${confirm_pwd.value}`;

    xhr.send(data);
  });
}

document.addEventListener("DOMContentLoaded", function () {
  changepasswordAjax();
});
