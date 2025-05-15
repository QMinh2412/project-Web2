document.addEventListener("DOMContentLoaded", () => {
    // Search/filter order
    const searchForm = document.querySelector(".order-search-form");
    if (searchForm) {
        searchForm.addEventListener("submit", (e) => {
            e.preventDefault();

            const importId = document.getElementById("import-search-import-id")?.value.trim() || "";
            const importProduct = document.getElementById("import-search-import-product")?.value.trim() || "";
            const importProvider = document.getElementById("import-search-import-provider")?.value.trim() || "";
            const importStatus = document.getElementById("import-search-import-status")?.value || "";
            const importFromDate = document.getElementById("import-search-from-date")?.value || "";
            const importToDate = document.getElementById("import-search-to-date")?.value || "";

            // Validate dates
            if ((!importFromDate && importToDate) || (importFromDate && !importToDate)) {
                alert("Bạn cần phải nhập cả ngày bắt đầu và ngày kết thúc!");
                return;
            }

            if (importFromDate && importToDate) {
                const from_date = new Date(importFromDate);
                const to_date = new Date(importToDate);

                if (from_date > to_date) {
                    alert("Ngày bắt đầu phải trước hoặc bằng ngày kết thúc!");
                    return;
                }

                const diffTime = to_date.getTime() - from_date.getTime();
                const diffDays = diffTime / (1000 * 60 * 60 * 24);
                if (diffDays > 30) {
                    alert("Khoảng thời gian tìm kiếm không được vượt quá 30 ngày.");
                    return;
                }
            }

            // Build search params including Product & Provider
            const searchParams = {
                import_id: importId,
                import_product: importProduct,
                import_provider: importProvider,
                import_status: importStatus,
                import_from_date: importFromDate,
                import_to_date: importToDate
            };

            // Build query string
            const queryString = Object.entries(searchParams)
                .filter(([_, value]) => value) // Remove empty values
                .map(([key, value]) => `${key}=${encodeURIComponent(value)}`)
                .join("&");

            // Redirect with search query
            window.location.href = `?page=import&action=index&${queryString}`;
        });
    }

    document.querySelectorAll(".import-status-dropdown").forEach(select => {
        setStatusStyle(select); 
        select.addEventListener("change", () => setStatusStyle(select));
    });

    function setStatusStyle(select) {
        const value = parseInt(select.value);
        const styles = {
            0: { border: "#ffc107", background: "#fff3cd", fontcolor: "#696700" },
            1: { border: "#198754", background: "#d1e7dd", fontcolor: "#007326" } 
        };
        const style = styles[value] || { border: "#ced4da", background: "#fff", fontcolor: "#000" };
        select.style.border = `1px solid ${style.border}`;
        select.style.backgroundColor = style.background;
        select.style.color = style.fontcolor;
    }

    /* Add book modal when creating import */
    document.getElementById("createProductImportBtn").addEventListener("click", function () {
        document.getElementById("addBookModal").style.display = "block";
    });
});

function handleStatusChange(select, importId, currentPage) {
    const newStatus = select.value;
    window.location.href = `?page=import&action=changeStatus&id=${importId}&status=${newStatus}&current_page=${currentPage}`;
}

function addImport() {
    const addForm = document.getElementById("import-add-modal");
    addForm.style.display = "flex";
}

function closeAddImport() {
    const addForm = document.getElementById("import-add-modal");
    addForm.style.display = "none";
}
/* Close product add form */
function closeAddBookModal() {
    document.getElementById("addBookModal").style.display = "none";
}



/* Model them san pham */
let selectedBooks = [];
let bookCount = 0;

function addBookToTable() {
    bookCount ++;
    const select = document.getElementById("importAddBookSelect");
    const bookId = select.value;
    const name = select.options[select.selectedIndex].dataset.name;
    const category = select.options[select.selectedIndex].dataset.category;
    const quantity = document.getElementById("importAddBookQuantity").value;
    const price = document.getElementById("importAddBookPrice").value;

    if (!quantity || !price || quantity <= 0 || price < 10000 || bookId == 0) {
        alert("Vui lòng kiểm tra lại thông tin.");
        return;
    }

    // Thêm sách vào mảng
    selectedBooks.push({
        id: bookId,
        name: name,
        category: category,
        quantity: quantity,
        price: price
    });

    // Disable option để tránh chọn lại
    select.querySelector(`option[value="${bookId}"]`).disabled = true;

    // Render lại table
    renderBookTable();

    closeAddBookModal();

    // Reset form
    document.getElementById("importAddBookQuantity").value = "";
    document.getElementById("importAddBookPrice").value = "";
    document.getElementById("importAddBookSelect").selectedIndex = 0;
}

function renderBookTable() {
    const tbody = document.querySelector(".admin-list-body");
    tbody.innerHTML = "";

    selectedBooks.forEach((book, index) => {
        const row = document.createElement("tr");

        row.innerHTML = `
            <td>
                <button type="button" class="btn btn-sm btn-danger delete-btn" data-index="${index}">
                    <i class='bx bx-x'></i>
                </button>
            </td>
            <td>${index + 1}</td>
            <td>${book.name}</td>
            <td>${book.category}</td>
            <td>${book.quantity}</td>
            <td>${book.price}</td>

            <input type="hidden" name="books[${index}][id]" value="${book.id}">
            <input type="hidden" name="books[${index}][quantity]" value="${book.quantity}">
            <input type="hidden" name="books[${index}][price]" value="${book.price}">
        `;

        tbody.appendChild(row);
    });

    // Gán lại sự kiện delete
    const deleteBtns = document.querySelectorAll(".delete-btn");
    deleteBtns.forEach(btn => {
        btn.addEventListener("click", function() {
            const index = this.getAttribute("data-index");
            const book = selectedBooks[index];

            // Enable lại option khi xóa
            const select = document.getElementById("importAddBookSelect");
            select.querySelector(`option[value="${book.id}"]`).disabled = false;

            // Xóa khỏi mảng
            selectedBooks.splice(index, 1);

            // Render lại bảng
            renderBookTable();
        });
    });
}

function exportDetail() {
    // Lấy nội dung cần in
    const wrapper = document.getElementById('import-detail-wrapper');
    const content = wrapper.innerHTML;

    // Tạo bản sao nội dung để chỉnh sửa
    const tempDiv = document.createElement('div');
    tempDiv.innerHTML = content;

    // Xóa các nút "Xong" và "In"
    const buttons = tempDiv.querySelectorAll('#closeImportDetailBtn, #exportDetailBtn');
    buttons.forEach(button => button.remove());

    // Tạo cửa sổ in
    const printWindow = window.open('', '_blank');
    printWindow.document.open();
    printWindow.document.write(`
        <html>
            <head>
                <title>Chi Tiết Phiếu Nhập</title>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; }
                    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                    table, th, td { border: 1px solid black; }
                    th, td { padding: 8px; text-align: left; }
                    th { background-color: #f2f2f2; }
                    #importDetailTotalValueDiv { margin-top: 20px; }
                </style>
            </head>
            <body>
                ${tempDiv.innerHTML}
            </body>
        </html>
    `);
    printWindow.document.close();

    // Thực hiện in
    printWindow.print();

    // Đóng cửa sổ in sau khi in xong
    printWindow.onafterprint = () => printWindow.close();
}
