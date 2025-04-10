document.addEventListener('DOMContentLoaded', function () {
    const authorSelect = document.getElementById('product-author-input');
    const authorNameInput = document.getElementById('product-author-name-input');
    const authorBirthdayInput = document.getElementById('product-author-birthday-input');
    const authorGenderInput = document.getElementById('product-author-gender-input');

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

    const publisherSelect = document.getElementById('product-publisher-input');
    const publisherNameInput = document.getElementById('product-publisher-name-input');
    const publisherAddressInput = document.getElementById('product-publisher-address-input');
    const publisherEmailInput = document.getElementById('product-publisher-email-input');

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

    const providerSelect = document.getElementById('product-provider-input');
    const providerNameInput = document.getElementById('product-provider-name-input');
    const providerAddressInput = document.getElementById('product-provider-address-input');
    const providerEmailInput = document.getElementById('product-provider-email-input');

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

    const ImageInput = document.getElementById('product-image-input');
    const ImagePreview = document.getElementById('product-image-preview');
    const limitImages = 5;

    ImageInput.addEventListener('change', function (event) {
        
        ImagePreview.innerHTML = '';

        const files = event.target.files;

        if (files.length > limitImages) {
            alert("Bạn chỉ được phép tải lên tối đa 5 ảnh!");
            ImageInput.value = '';
            return;
        }

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
                    ImagePreview.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        }
    });
    
});