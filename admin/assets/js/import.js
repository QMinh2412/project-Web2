document.addEventListener('DOMContentLoaded', function () {
    const productList = document.getElementById('product-list');

    // Thêm dòng mới
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-add-row')) {
            const row = e.target.closest('tr');
            const newRow = row.cloneNode(true);

            // Xóa giá trị trong các ô input
            newRow.querySelectorAll('input').forEach(input => input.value = '');

            // Cập nhật index của các input
            const index = productList.children.length;
            newRow.querySelectorAll('input').forEach(input => {
                const name = input.getAttribute('name');
                if (name) {
                    input.setAttribute('name', name.replace(/\d+/, index));
                }
            });

            productList.appendChild(newRow);
        }

        // Xóa dòng
        if (e.target.classList.contains('btn-remove-row')) {
            const row = e.target.closest('tr');
            if (productList.children.length > 1) {
                row.remove();
            }
        }
    });
});