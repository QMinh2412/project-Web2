document.addEventListener('DOMContentLoaded', function () {
    const authorSelect = document.getElementById('product-author-input');
    const authorNameInput = document.getElementById('product-author-name-input');
    const authorBirthdayInput = document.getElementById('product-author-birthday-input');
    const authorGenderInput = document.getElementById('product-author-gender-input');

    if (authorSelect && authorNameInput && authorBirthdayInput && authorGenderInput) {
        authorSelect.addEventListener('change', function () {
            if (this.value === '0') {
                authorNameInput.style.display = 'block';
                authorBirthdayInput.style.display = 'block';
                authorGenderInput.style.display = 'block';
            } else {
                authorNameInput.style.display = 'none';
                authorNameInput.value = '';
                authorBirthdayInput.style.display = 'none';
                authorBirthdayInput.value = '';
                authorGenderInput.style.display = 'none';
            }
        });
    }

    const publisherSelect = document.getElementById('product-publisher-input');
    const publisherNameInput = document.getElementById('product-publisher-name-input');
    const publisherAddressInput = document.getElementById('product-publisher-address-input');
    const publisherEmailInput = document.getElementById('product-publisher-email-input');

    if (publisherSelect && publisherNameInput && publisherAddressInput && publisherEmailInput) {
        publisherSelect.addEventListener('change', function () { 
            if (this.value === '0') {
                publisherNameInput.style.display = 'block';
                publisherAddressInput.style.display = 'block';
                publisherEmailInput.style.display = 'block';
            } else {
                publisherNameInput.style.display = 'none';
                publisherNameInput.value = '';
                publisherAddressInput.style.display = 'none';
                publisherAddressInput.value = '';
                publisherEmailInput.style.display = 'none';
                publisherEmailInput.value = '';
            }
        });
    }
    
    const providerSelect = document.getElementById('providerSelect');
    const providerNameInput = document.getElementById('providerNameInput');
    const providerAddressInput = document.getElementById('providerAddressInput');
    const providerEmailInput = document.getElementById('providerEmailInput');

    if (providerSelect && providerNameInput && providerAddressInput && providerEmailInput) {
        providerSelect.addEventListener('change', function () {
            if (this.value === '0') {
                providerNameInput.style.display = 'block';
                providerAddressInput.style.display = 'block';
                providerEmailInput.style.display = 'block';
            } else {
                providerNameInput.style.display = 'none';
                providerNameInput.value = '';
                providerAddressInput.style.display = 'none';
                providerAddressInput.value = '';
                providerEmailInput.style.display = 'none';
                providerEmailInput.value = '';
            }
        });
    }

    const ImageInput = document.getElementById('product-image-input');
    const ImagePreview = document.getElementById('product-image-preview');
    const limitImages = 5;
    const existingCountInput = document.getElementById('existing-image-count');
    const existingCount = existingCountInput ? parseInt(existingCountInput.value) : 0;

    let previewCreateProductImages = [];

    function showModalwhenCreatingProduct(index) {
        if (!previewCreateProductImages[index]) return;
        modal.style.display = "block";
        modalImg.src = previewCreateProductImages[index].src;
        modalImg.style.transform = "scale(1)";
        currentScaleImg = 1;
    }

    function getRemainingOldCount() {
        const deleteCheckboxes = document.querySelectorAll('input[name="delete_images[]"]:checked');
        return existingCount - deleteCheckboxes.length;
    }

    function validateImageCount(fileCount) {
        const remainOld = getRemainingOldCount();
        if ((remainOld + fileCount) > limitImages) {
            alert(`Tổng ảnh sau khi tính ảnh bị xóa không được vượt quá ${limitImages}!`);
            return false;
        }
        return true;
    }

    function handleFilePreview(files) {
        ImagePreview.innerHTML = '';
        previewCreateProductImages = [];

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.maxWidth = '200px';
                    img.style.maxHeight = '200px';
                    img.style.margin = '5px';
                    img.style.cursor = 'pointer';
                    img.addEventListener("click", () => {
                        currentIndex = previewCreateProductImages.indexOf(img);
                        showModalwhenCreatingProduct(currentIndex);
                    });

                    ImagePreview.appendChild(img);
                    previewCreateProductImages.push(img);
                };
                reader.readAsDataURL(file);
            }
        }
    }

    // Gắn event thay đổi file
    if (ImageInput && ImagePreview) {
        ImageInput.addEventListener('change', function (event) {
            const files = event.target.files;
            if (!validateImageCount(files.length)) {
                ImageInput.value = '';
                ImagePreview.innerHTML = '';
                return;
            }
            handleFilePreview(files);
        });
    }

    // Gắn event mỗi khi người dùng tick/untick ảnh cũ cần xoá
    document.querySelectorAll('input[name="delete_images[]"]').forEach(cb => {
        cb.addEventListener('change', () => {
            const files = ImageInput.files;
            if (files.length && !validateImageCount(files.length)) {
                ImageInput.value = '';
                ImagePreview.innerHTML = '';
            }
        });
    });

    const modal = document.getElementById("imageModal");
    const modalImg = document.getElementById("modalImage");
    const closeBtn = document.querySelector(".close");
    const prevBtn = document.querySelector(".prev");
    const nextBtn = document.querySelector(".next");
    const imageElements = document.querySelectorAll(".product-image-img");
    const oldImageElements = document.querySelectorAll(".product-preview-img");

    let currentIndex = 0;

    function showModal(index) {
        const selectedImg = imageElements[index];
        if (!selectedImg) return;

        modal.style.display = "block";
        modalImg.src = selectedImg.src;
        currentIndex = index;
    }

    imageElements.forEach((img, index) => {
        img.style.cursor = "pointer";
        img.addEventListener("click", () => showModal(index));
    });

    function showModalforOldImages(index) {
        const selectedImg = oldImageElements[index];
        if (!selectedImg) return;

        modal.style.display = "block";
        modalImg.src = selectedImg.src;
        currentIndex = index;
    }

    oldImageElements.forEach((img, index) => {
        img.style.cursor = "pointer";
        img.addEventListener("click", () => showModalforOldImages(index));
    });

    closeBtn.onclick = () => {
        modal.style.display = "none";
    };

    prevBtn.onclick = () => {
        currentIndex = (currentIndex - 1 + imageElements.length) % imageElements.length;
        showModal(currentIndex);
    };

    nextBtn.onclick = () => {
        currentIndex = (currentIndex + 1) % imageElements.length;
        showModal(currentIndex);
    };

    window.onclick = function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    };

    document.addEventListener("keydown", function(e) {
        if (modal.style.display === "block") {
            if (e.key === "Escape") {
                modal.style.display = "none";
            } else if (e.key === "ArrowLeft") {
                currentIndex = (currentIndex - 1 + imageElements.length) % imageElements.length;
                showModal(currentIndex);
            } else if (e.key === "ArrowRight") {
                currentIndex = (currentIndex + 1) % imageElements.length;
                showModal(currentIndex);
            }
        }
    });

});