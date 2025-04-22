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
});

function handleStatusChange(select, importId, currentPage) {
    const newStatus = select.value;
    window.location.href = `?page=import&action=changeStatus&id=${importId}&status=${newStatus}&current_page=${currentPage}`;
}