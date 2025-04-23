// function hiddenShowAdvacedSearch() {
//   const icon = document.querySelector(".icon");
//   const advanceSearch = document.querySelector(".box_input");
//   icon.addEventListener("click", function () {
//     icon.querySelector("i").classList.toggle("active");
//     advanceSearch.classList.toggle("active");
//   });
// }

function hiddenShowBoxAccount() {
  document.querySelector(".account_box").addEventListener("click", () => {
    const subMenu = document.querySelector(".sub_menu");
    if (subMenu.style.display == "none") {
      subMenu.style.display = "block";
    } else {
      subMenu.style.display = "none";
    }
  });
}

function searchAjax() {
  document
    .querySelector("button[type=submit]")
    .addEventListener("click", function (e) {
      e.preventDefault();
      console.log("đang click vào nút tìm kiếm");
      const name = document.getElementsByName("name");
      const category = document.getElementsByName("category");
      const author = document.getElementsByName("author");

      console.log(name.value);
      console.log(category.value);
      console.log(author.value);

      if (!name.value) {
        console.log("không có tên nào được tìm");
        name.focus();
        return;
      }

      xhr = new XMLHttpRequest();
      xhr.open(
        "POST",
        `/project-Web2/user/index.php?page=product&action=search`,
        true
      );
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange() = function() {

      };
    });
}

document.addEventListener("DOMContentLoaded", function () {
  hiddenShowBoxAccount();
  // hiddenShowAdvacedSearch();
  // searchAjax();
});
