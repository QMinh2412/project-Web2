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

document.addEventListener("DOMContentLoaded", function () {
  plusItem();
  minusItem();
  showTextarea();
  writeComment();
  writeReply();
});
