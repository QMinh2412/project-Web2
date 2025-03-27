document.addEventListener("DOMContentLoaded", function () {
  document.querySelector(".account_box").addEventListener("click", () => {
    const subMenu = document.querySelector(".sub_menu");
    if (subMenu.style.display == "none") {
      subMenu.style.display = "block";
    } else {
      subMenu.style.display = "none";
    }
  });
});
