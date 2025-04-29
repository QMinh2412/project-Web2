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
    
    const providerSelect = document.getElementById('product-provider-input');
    const providerNameInput = document.getElementById('product-provider-name-input');
    const providerAddressInput = document.getElementById('product-provider-address-input');
    const providerEmailInput = document.getElementById('product-provider-email-input');

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

    /*********** Image Zoom **********/
    // 1. Common Modal Function for All
    const modal     = document.getElementById('universalImageModal');
    const modalImg  = document.getElementById('universalModalImage');
    const closeBtn  = modal.querySelector('.close');
    const prevBtn   = modal.querySelector('.prev');
    const nextBtn   = modal.querySelector('.next');

    let currentImages = [];
    let currentIndex = 0;

    function openModal(idx) {
        const img = currentImages[idx];
        if (!img) return;
        modalImg.src = img.src;
        modal.style.display = 'block';
    }

    function closeModal() {
        modal.style.display = 'none';
    }

    closeBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', e => {
        if (e.target === modal) closeModal();
    });

    prevBtn.addEventListener('click', () => {
        currentIndex = (currentIndex - 1 + currentImages.length) % currentImages.length;
        openModal(currentIndex);
    });

    nextBtn.addEventListener('click', () => {
        currentIndex = (currentIndex + 1) % currentImages.length;
        openModal(currentIndex);
    });

    document.addEventListener('keydown', e => {
        if (modal.style.display !== 'block') return;
        if (e.key === 'Escape') closeBtn.click();
        if (e.key === 'ArrowLeft') prevBtn.click();
        if (e.key === 'ArrowRight') nextBtn.click();
    });

    // 2. Binding function for all features

    function bindZoomableImages() {
        currentImages = Array.from(document.querySelectorAll('.zoomable-img'));
        currentImages.forEach((img, idx) => {
            img.style.cursor = 'pointer';
            img.onclick = () => {
                currentIndex = idx;
                openModal(idx);
            };
        });
    }

    // 3. Call binding function
    bindZoomableImages();

    // Modal for Product Creation
    const CreateProductInput = document.getElementById('product-create-image-input');
    const CreateProductPreviewContainer = document.getElementById('product-create-image-preview');

    if (CreateProductInput && CreateProductPreviewContainer) {
        CreateProductInput.addEventListener('change', function() {
            CreateProductPreviewContainer.innerHTML = ''; // clear cũ

            const files = Array.from(this.files);

            if (files.length > 5) {
                alert("Bạn chỉ được chọn tối đa 5 ảnh.");
                this.value = ""; 
                return;
            }
    
            files.forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'zoomable-img';
                    img.style.maxWidth = '150px';
                    img.style.margin = '5px';
                    img.style.cursor = 'pointer'; // Thêm cho rõ
                    CreateProductPreviewContainer.appendChild(img);
    
                    img.addEventListener('click', () => {
                        // openModalFromImage(img);
                        currentImages = Array.from(document.querySelectorAll('.zoomable-img'));
                        currentIndex = currentImages.indexOf(img);
                        openModal(currentIndex);
                    });
                };
                reader.readAsDataURL(file);
            });
        });
    }

    // Modal for Product Edition

    const editInput      = document.getElementById('edit-product-image-input');
    const editPreview    = document.getElementById('edit-product-new-image-preview');
    const notifSection   = document.getElementById('edit-product-new-image-section');
    const newImgNoti     = document.getElementById('product-image-preview-notification');
    const newImgAlert    = document.getElementById('product-image-preview-alert');
    const limitImages    = 5;
    const existingCount  = parseInt(document.getElementById('existing-image-count').value, 10);

    // Tính số ảnh khe còn trống (ảnh cũ chưa xoá)
    function getRemainingSlots() {
        const toDelete = document.querySelectorAll('input[name="delete_images[]"]:checked').length;
        return limitImages - (existingCount - toDelete);
    }

    // Kiểm tra xem thêm n ảnh có vượt quá limit không
    function canAdd(n) {
        if (getRemainingSlots() < n) {
        alert(`Tổng ảnh (cũ + mới) không được vượt quá ${limitImages}.`);
        return false;
        }
        return true;
    }

    // Vẽ preview cho file mới
    function previewFiles(files) {
        editPreview.innerHTML = '';
        Array.from(files).forEach(file => {
        if (!file.type.startsWith('image/')) return;
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.createElement('img');
            img.src       = e.target.result;
            img.className = 'zoomable-img';
            img.style     = 'max-width:150px;margin:5px;cursor:pointer';
            // khi click sẽ gọi modal zoom (hàm bạn đã có sẵn)
            img.addEventListener('click', () => {
                currentImages = Array.from(document.querySelectorAll('.zoomable-img'));
                currentIndex = currentImages.indexOf(img);
                openModal(currentIndex);
            });
            editPreview.appendChild(img);
        };
        reader.readAsDataURL(file);
        });
    }

    // Xử lý khi admin chọn file mới
    if (editInput && editPreview) {
        editInput.addEventListener('change', function() {
        const files = this.files;
        if (files.length === 0) {
            newImgNoti.style.display  = 'none';
            newImgAlert.style.display = 'block';
            editInput.value = '';
            editPreview.innerHTML = '';
            return;
        }
        newImgNoti.style.display  = 'block';
        newImgAlert.style.display = 'none';
        if (!canAdd(files.length)) {
            this.value = '';
            editPreview.innerHTML = '';
            return;
        }
        previewFiles(files);
        });
    }

    // Mỗi khi tick/untick xoá ảnh cũ, kiểm tra lại
    document.querySelectorAll('input[name="delete_images[]"]').forEach(cb => {
        cb.addEventListener('change', () => {
        const files = editInput.files;
        if (files.length && !canAdd(files.length)) {
            editInput.value = '';
            editPreview.innerHTML = '';
        }
        });
    });
});

// confirm delete product
function confirmDeleteProduct (productName, URL) {
    if (confirm(`Bạn có muốn xóa sản phẩm "${productName}"?`)) {
        window.location.href = URL;
    }
}