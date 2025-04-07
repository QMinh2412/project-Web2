document.addEventListener("DOMContentLoaded", function () {
  const menuLinks = document.querySelectorAll(".menu-list a:not(.menu-more)");

  menuLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      e.preventDefault();
      const targetId = this.getAttribute("href").substring(1); // Lấy ID của phần cần cuộn đến
      const targetSection = document.getElementById(targetId);

      if (targetSection) {
        targetSection.scrollIntoView({ behavior: "smooth" }); // Cuộn mượt mà đến phần đó
      }
    });
  });
  function toggleMenu() {
    const menu = document.getElementById("menuList");
    menu.classList.toggle("show");
  }
});
