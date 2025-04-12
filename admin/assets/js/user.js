function previewImage(event) {
    const file = event.target.files[0];
    const previewContainer = document.getElementById('user-image-preview');

    previewContainer.innerHTML = ''; // Clear previous preview

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
