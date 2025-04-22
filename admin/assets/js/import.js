document.addEventListener("DOMContentLoaded", () => {
    // Search/filter order
    const searchForm = document.querySelector(".order-search-form");
    if (searchForm) {
        searchForm.addEventListener("submit", (e) => {
            e.preventDefault();
            
            const importId = document.getElementById("import-search-import-id")?.value || "";
            const importStatus = document.getElementById("import-search-import-status")?.value || "";
            const importFromDate = document.getElementById("import-search-from-date")?.value || "";
            const importToDate = document.getElementById("import-search-to-date")?.value || "";

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

            const searchParams = {
                import_id: importId,
                import_status: importStatus,
                import_from_date: importFromDate,
                import_to_date: importToDate
            };

            // Construct query string
            const queryString = Object.entries(searchParams)
                .filter(([_, value]) => value) // Remove empty values
                .map(([key, value]) => `${key}=${encodeURIComponent(value)}`)
                .join("&");

            // Redirect with query parameters
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
    
    
    // let bookCount = 0;

    // function addBookToTable() {
    //     const select = document.getElementById("importAddBookSelect");
    //     const bookId = select.value;
    //     const name = select.options[select.selectedIndex].dataset.name;
    //     const category = select.options[select.selectedIndex].dataset.category;
    //     const quantity = document.getElementById("importAddBookQuantity").value;
    //     const price = document.getElementById("importAddBookPrice").value;

    //     if (!quantity || !price || quantity <= 0 || price <= 0) {
    //         alert("Vui lòng nhập số lượng và giá nhập hợp lệ.");
    //         return;
    //     }

    //     const tbody = document.querySelector(".admin-list-body");
    //     const row = document.createElement("tr");

    //     row.innerHTML = `
    //         <td>${++bookCount}</td>
    //         <td>${name}</td>
    //         <td>${category}</td>
    //         <td>${quantity}</td>
    //         <td>${price}</td>
    //         <input type="hidden" name="books[${bookCount}][id]" value="${bookId}">
    //         <input type="hidden" name="books[${bookCount}][quantity]" value="${quantity}">
    //         <input type="hidden" name="books[${bookCount}][price]" value="${price}">
    //     `;

    //     tbody.appendChild(row);
    //     closeAddBookModal();
    // }

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

let bookCount = 0;

/* Model them san pham */
function addBookToTable() {
    const select = document.getElementById("importAddBookSelect");
    const bookId = select.value;
    const name = select.options[select.selectedIndex].dataset.name;
    const category = select.options[select.selectedIndex].dataset.category;
    const quantity = document.getElementById("importAddBookQuantity").value;
    const price = document.getElementById("importAddBookPrice").value;

    if (!quantity || !price || quantity <= 0 || price < 10000) {
        alert("Vui lòng nhập số lượng và giá nhập hợp lệ.");
        return;
    }

    select.querySelector(`option[value="${bookId}"]`).disabled = true;

    const tbody = document.querySelector(".admin-list-body");
    const row = document.createElement("tr");

    row.innerHTML = `
        <td><button type="button" class="btn btn-sm btn-danger delete-btn"><i class='bx bx-x'></i></button></td>
        <td>${++bookCount}</td>
        <td>${name}</td>
        <td>${category}</td>
        <td>${quantity}</td>
        <td>${price}</td>
           <input type="hidden" name="books[${bookCount}][id]" value="${bookId}">
           <input type="hidden" name="books[${bookCount}][quantity]" value="${quantity}">
           <input type="hidden" name="books[${bookCount}][price]" value="${price}">
    `;

    row.querySelector(".delete-btn").addEventListener("click", () => {
        row.remove();
        // Bỏ disable cho option đã bị ẩn, để được chọn lại
        select.querySelector(`option[value="${bookId}"]`).disabled = false;
    });
    tbody.appendChild(row);
    closeAddBookModal();

    document.getElementById("importAddBookQuantity").value = "";
    document.getElementById("importAddBookPrice").value = "";
    document.getElementById("importAddBookSelect").selectedIndex = 0;
}