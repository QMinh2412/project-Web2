document.addEventListener("DOMContentLoaded", () => {
    document.querySelector("form").addEventListener("submit", function(event) {
        const from = document.getElementById("customer-from-date").value;
        const to = document.getElementById("customer-to-date").value;

        if (from && to && from > to) {
            alert("Ngày bắt đầu phải trước hoặc bằng ngày kết thúc!");
            event.preventDefault();
        }
    });

})