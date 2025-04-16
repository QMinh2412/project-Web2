function previewImage(event) {
    alert("Vui lòng chọn ảnh đại diện cho người dùng.");
    const file = event.target.files[0];
    const previewContainer = document.getElementById('user-image-preview');

    previewContainer.innerHTML = '';

    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.maxWidth = '200px';
            img.style.maxHeight = '200px';
            img.style.margin = '5px';
            previewContainer.appendChild(img);
        };
        reader.readAsDataURL(file);
    }
}

function confirmDelete(userId) {
    if (confirm("Bạn có chắc chắn muốn xóa tài khoản này?")) {
        window.location.href = `?page=user&action=delete&id=${userId}`;
    }
    return false;
}    



