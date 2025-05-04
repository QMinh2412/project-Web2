function plusItem() {
  const plusIcon = document.getElementById("plus_icon");
  plusIcon.addEventListener("click", () => {
    const quantity = document.getElementById("quantity");
    let number = parseInt(quantity.innerText);
    number++;
    quantity.innerHTML = number;
  });
}

function minusItem() {
  const minusIcon = document.getElementById("minus_icon");
  minusIcon.addEventListener("click", () => {
    const quantity = document.getElementById("quantity");
    let number = parseInt(quantity.innerText);
    if (number > 1) number--;
    quantity.innerHTML = number;
  });
}

function showTextarea() {
  const textReply = document.querySelectorAll(".text_reply");
  textReply.forEach((item) => {
    item.addEventListener("click", function () {
      const writeReply = item.nextElementSibling;
      if (writeReply.style.display == "none") {
        writeReply.style.display = "block";
      } else {
        writeReply.style.display = "none";
      }
    });
  });
}

function addCommentToUI(comment) {
  const oldComments = document.querySelector(".old_comments");

  // Tạo HTML cho bình luận mới
  const commentHtml = `
    <div class="comment" data-id="${comment.MaDG}">
      <div class="info_account">
        <div class="account_image">
          <img src="${comment.AnhKH}" alt="User">
        </div>
        <div class="account_name">${comment.TenKH}</div>
        <div class="date_comment">${comment.NgayViet}</div>
      </div>
      <div class="content">${comment.NoiDung}</div>
    </div>
  `;

  // Thêm bình luận vào đầu danh sách
  oldComments.insertAdjacentHTML("afterbegin", commentHtml);

  // Xóa thông báo "Chưa có đánh giá" nếu có
  const noReviewMessage = document.querySelector(".havent_review");
  if (noReviewMessage) {
    noReviewMessage.remove();
  }
}

function writeComment() {
  document.querySelector(".send").addEventListener("click", function (e) {
    e.preventDefault();

    const content = document.getElementById("my_comment").value;
    const url = new URLSearchParams(window.location.search);
    const id_book = url.get("id_book");

    const xhr = new XMLHttpRequest();
    xhr.open(
      "POST",
      "/project-Web2/user/index.php?page=detail&action=writeComment",
      true
    );
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
        const response = JSON.parse(xhr.responseText);
        console.log(response);

        if (response.success) {
          addCommentToUI(response.new_comment);
          document.getElementById("my_comment").value = "";
        } else {
          alert(response.message);
        }
      }
    };

    const data = `content=${encodeURIComponent(
      content
    )}&id_book=${encodeURIComponent(id_book)}`;
    xhr.send(data);
  });
}

function updateReplyUI(comment, reply) {
  // const writeReplyDiv = comment.querySelector(".write_reply");

  // Tạo HTML cho phản hồi
  const replyHtml = `
    <div class="reply_account_info">
      <div class="account_image">
        <img src="${reply.AnhDN}" alt="${reply.TenAdmin}">
      </div>
      <div class="account_name">${reply.TenAdmin}</div>
    </div>
    <div class="content reply_content">${reply.PhanHoi}</div>
  `;

  return replyHtml;
}

function writeReply() {
  const btn_reply = document.querySelectorAll(".btn_reply");

  btn_reply.forEach((btn) => {
    btn.addEventListener("click", function (e) {
      e.preventDefault();

      // lấy comment chứa nút trả lời
      const comment = this.closest(".comment");
      const content = comment.querySelector(".content_reply").value;
      const id_comment = comment.getAttribute("data-id");

      const xhr = new XMLHttpRequest();
      xhr.open(
        "POST",
        "/project-Web2/user/index.php?page=detail&action=replyComment",
        true
      );
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
          const response = JSON.parse(xhr.responseText);
          console.log(response);

          if (response.success) {
            const replyHtml = updateReplyUI(comment, response.new_reply);
            comment.querySelector(".write_reply").innerHTML = replyHtml;
            comment.querySelector(".text_reply").style.display = "none";
          } else {
            alert(response.message);
          }
        }
      };

      // Chuẩn bị dữ liệu
      const data = `content=${encodeURIComponent(
        content
      )}&comment_id=${encodeURIComponent(id_comment)}`;
      xhr.send(data);
    });
  });
}

function addToCart() {
  document.getElementById("addToCart").addEventListener("click", (e) => {
    e.preventDefault();

    const url = new URLSearchParams(window.location.search);
    const id_book = url.get("id_book");
    const qty = parseInt(document.getElementById("quantity").innerText);
    console.log(`ma sach: ${id_book}`);
    console.log(`so lg: ${qty}`);

    const xhr = new XMLHttpRequest();
    xhr.open(
      "POST",
      "/project-Web2/user/index.php?page=cart&action=addToCart",
      true
    );
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
        const response = JSON.parse(xhr.responseText);
        console.log(response);
        alert(response.message);
      }
    };

    let data = `id_book=${encodeURIComponent(
      id_book
    )}&quantity=${encodeURIComponent(qty)}`;
    xhr.send(data);
  });
}

function dragDropDetailImage() {
  const detailImageContainer = document.querySelector(
    ".book_image .detail_image"
  );
  const mainImage = document.querySelector(".book_image .main_image img");
  let isDragging = false;
  let startX;
  let scrollLeft;

  // Xử lý click vào ảnh trong detail_image
  detailImageContainer.addEventListener("click", (e) => {
    const clickedImage = e.target.closest("img");
    if (!clickedImage) return; // Nếu không click vào ảnh, bỏ qua

    // Cập nhật src của main_image
    mainImage.src = clickedImage.src;
    mainImage.alt = clickedImage.alt; // Giữ alt giống ảnh detail
  });

  // Xử lý kéo bằng chuột
  detailImageContainer.addEventListener("mousedown", (e) => {
    isDragging = true;
    startX = e.pageX - detailImageContainer.offsetLeft;
    scrollLeft = detailImageContainer.scrollLeft;
    detailImageContainer.style.cursor = "grabbing";
    // detailImageContainer.classList.remove("animate"); // Tắt transition khi kéo
  });

  detailImageContainer.addEventListener("mouseleave", () => {
    isDragging = false;
    detailImageContainer.style.cursor = "grab";
    // detailImageContainer.classList.add("animate"); // Bật lại transition
  });

  detailImageContainer.addEventListener("mouseup", () => {
    isDragging = false;
    detailImageContainer.style.cursor = "grab";
    // detailImageContainer.classList.add("animate"); // Bật lại transition
  });

  detailImageContainer.addEventListener("mousemove", (e) => {
    if (!isDragging) return;
    e.preventDefault();
    const x = e.pageX - detailImageContainer.offsetLeft;
    const walk = (x - startX) * 1.5; // Tốc độ kéo
    detailImageContainer.scrollLeft = scrollLeft - walk;

    // Giới hạn kéo
    const maxScrollLeft =
      detailImageContainer.scrollWidth - detailImageContainer.clientWidth;
    if (detailImageContainer.scrollLeft <= 0) {
      detailImageContainer.scrollLeft = 0; // Ngăn kéo quá bên phải (ảnh đầu)
    } else if (detailImageContainer.scrollLeft >= maxScrollLeft) {
      detailImageContainer.scrollLeft = maxScrollLeft; // Ngăn kéo quá bên trái (ảnh cuối)
    }
  });

  // Xử lý kéo trên thiết bị cảm ứng
  detailImageContainer.addEventListener("touchstart", (e) => {
    isDragging = true;
    startX = e.touches[0].pageX - detailImageContainer.offsetLeft;
    scrollLeft = detailImageContainer.scrollLeft;
    // detailImageContainer.classList.remove("animate"); // Tắt transition khi kéo
  });

  detailImageContainer.addEventListener("touchend", () => {
    isDragging = false;
    // detailImageContainer.classList.add("animate"); // Bật lại transition
  });

  detailImageContainer.addEventListener("touchmove", (e) => {
    if (!isDragging) return;
    const x = e.touches[0].pageX - detailImageContainer.offsetLeft;
    const walk = (x - startX) * 1.5; // Tốc độ kéo
    detailImageContainer.scrollLeft = scrollLeft - walk;

    // Giới hạn kéo
    const maxScrollLeft =
      detailImageContainer.scrollWidth - detailImageContainer.clientWidth;
    if (detailImageContainer.scrollLeft <= 0) {
      detailImageContainer.scrollLeft = 0;
    } else if (detailImageContainer.scrollLeft >= maxScrollLeft) {
      detailImageContainer.scrollLeft = maxScrollLeft;
    }
  });
}

function effectForOrtherBooks() {
  $(document).ready(function () {
    const $carousel = $(".orther_books").owlCarousel({
      loop: true, // Bật chế độ vòng lặp
      margin: 20, // Khoảng cách giữa các item (20px như trong CSS)
      autoplay: true, // Tự động trượt
      autoplayTimeout: 3000, // Thời gian chờ giữa các lần trượt (3 giây)
      autoplayHoverPause: true, // Tạm dừng khi hover
      nav: false, // Ẩn nút điều hướng mặc định của Owl Carousel
      dots: false, // Ẩn chấm điều hướng
      items: 5, // Hiển thị 5 item cùng lúc
      responsive: {
        0: {
          items: 2, // Hiển thị 2 item trên màn hình nhỏ
        },
        600: {
          items: 3, // Hiển thị 3 item trên màn hình trung bình
        },
        1050: {
          items: 4, // Hiển thị 5 item trên màn hình lớn
        },
      },
    });

    // Xử lý nút điều hướng tùy chỉnh
    $("#next").on("click", function () {
      $carousel.trigger("next.owl.carousel");
    });

    $("#prev").on("click", function () {
      $carousel.trigger("prev.owl.carousel");
    });
  });
}

function buyNow() {
  document.getElementById("buyNow").addEventListener("click", () => {
    const urlParam = new URLSearchParams(window.location.search);
    const bookId = urlParam.get("id_book");
    const qty = document.getElementById("quantity").textContent;

    const xhr = new XMLHttpRequest();
    xhr.open(
      "POST",
      "/project-Web2/user/index.php?page=product&action=buynow",
      true
    );
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
        const response = JSON.parse(xhr.responseText);
        console.log(response);

        if (response.status) {
          window.location.href =
            "/project-Web2/user/index.php?page=checkout&action=showCheckout&source=buynow";
        } else {
          alert(response.message);
        }
      }
    };

    let data = "";
    if (bookId) data += `id_book=${bookId}&`;
    if (qty) data += `quantity=${qty}`;

    xhr.send(data);
  });
}

document.addEventListener("DOMContentLoaded", function () {
  plusItem();
  minusItem();
  showTextarea();
  writeComment();
  writeReply();
  addToCart();
  dragDropDetailImage();
  effectForOrtherBooks();

  // document.getElementById("buyNow").addEventListener("click", function () {
  //   window.location.href = "/project-Web2/user/index.php?page=checkout";
  // });
  buyNow();
});
