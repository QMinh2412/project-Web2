document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".order-status-dropdown").forEach(select => {
        setStatusStyle(select); 
        select.addEventListener("change", () => setStatusStyle(select));
    });

    function setStatusStyle(select) {
        const value = parseInt(select.value);
        const styles = {
            0: { border: "#dc3545", background: "#f8d7da", fontcolor: "#4f0000" },
            1: { border: "#ffc107", background: "#fff3cd", fontcolor: "#696700" },
            2: { border: "#0d6efd", background: "#cfe2ff", fontcolor: "#003099" },
            3: { border: "#198754", background: "#d1e7dd", fontcolor: "#007326" }  
        };
        const style = styles[value] || { border: "#ced4da", background: "#fff", fontcolor: "#000" };
        select.style.border = `1px solid ${style.border}`;
        select.style.backgroundColor = style.background;
        select.style.color = style.fontcolor;
    }

    // Search/filter order
    const searchForm = document.querySelector(".order-search-form");
    if (searchForm) {
        searchForm.addEventListener("submit", (e) => {
            e.preventDefault(); // Prevent default form submission if needed
            const searchParams = {
                order_id: document.getElementById("order-search-order-id")?.value || "",
                order_status: document.getElementById("order-search-order-status")?.value || "",
                order_from_date: document.getElementById("order-search-from-date")?.value || "",
                order_to_date: document.getElementById("order-search-to-date")?.value || ""
            };

            // Construct query string
            const queryString = Object.entries(searchParams)
                .filter(([_, value]) => value) // Remove empty values
                .map(([key, value]) => `${key}=${encodeURIComponent(value)}`)
                .join("&");

            // Redirect with query parameters
            window.location.href = `?page=order&action=index&${queryString}`;
        });
    }
});

function handleStatusChange(select, orderId, currentPage) {
    const newStatus = select.value;
    window.location.href = `?page=order&action=changeStatus&id=${orderId}&status=${newStatus}&current_page=${currentPage}`;
}