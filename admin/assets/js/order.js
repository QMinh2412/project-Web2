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
            e.preventDefault();
            
            const orderId = document.getElementById("order-search-order-id")?.value || "";
            const orderStatus = document.getElementById("order-search-order-status")?.value || "";
            const orderFromDate = document.getElementById("order-search-from-date")?.value || "";
            const orderToDate = document.getElementById("order-search-to-date")?.value || "";

            if ((!orderFromDate && orderToDate) || (orderFromDate && !orderToDate)) {
                alert("Bạn cần phải nhập cả ngày bắt đầu và ngày kết thúc!");
                return;
            }

            if (orderFromDate && orderToDate) {
                const from_date = new Date(orderFromDate);
                const to_date = new Date(orderToDate);

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
                order_id: orderId,
                order_status: orderStatus,
                order_from_date: orderFromDate,
                order_to_date: orderToDate
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

function exportOrderDetail() {
    // Lấy nội dung cần in
    const wrapper = document.getElementById('order-detail-wrapper');
    const content = wrapper.innerHTML;

    // Tạo bản sao nội dung để chỉnh sửa
    const tempDiv = document.createElement('div');
    tempDiv.innerHTML = content;

    // Xóa các nút "Xong" và "In"
    const buttons = tempDiv.querySelectorAll('#closeOrderDetailBtn, #exportOrderDetailBtn');
    buttons.forEach(button => button.remove());

    // Tạo cửa sổ in
    const printWindow = window.open('', '_blank');
    printWindow.document.open();
    printWindow.document.write(`
        <html>
            <head>
                <title>Chi Tiết Đơn Hàng</title>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; padding: 20px; }
                    
                    #order-detail-form {
                        display: flex;
                        flex-wrap: wrap;
                        gap: 16px;
                        margin-bottom: 20px;
                    }
                    .general-order-info {
                        flex: 1 1 calc(45% - 10px);
                    }
                    .general-order-info-full {
                        flex: 1 1 100%;
                    }
                    .order-create-label {
                        font-weight: bold;
                        font-size: 1em;
                        margin: 6px 0 4px 0;
                    }
                    .order-create-text {
                        border-radius: 5px;
                        padding: 8px;
                        font-size: 14px;
                        width: 100%;
                        box-sizing: border-box;
                        border: solid 1px black;
                    }

                    #order-note-input {
                        height: 100px;
                        resize: vertical;
                    }

                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-top: 20px;
                    }

                    table, th, td {
                        border: 1px solid black;
                    }

                    th, td {
                        padding: 8px;
                        text-align: left;
                    }

                    th {
                        background-color: #f2f2f2;
                    }

                    #orderDetailTotalValueDiv {
                        display: flex;
                        justify-content: flex-end;
                        margin-top: 30px;
                    }

                    .order-value-row {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        width: 350px;
                        margin-bottom: 10px;
                    }

                    .order-value-row label {
                        font-weight: bold;
                    }

                    .order-value-row input {
                        width: 150px;
                        text-align: right;
                        padding: 8px;
                        border: 1px solid #ccc;
                        background-color: #f9f9f9;
                        border-radius: 5px;
                    }
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
