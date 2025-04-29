<?php
    switch ($order['TrangThaiDH']) {
        case 0:
            $orderStatus = 'Đã hủy';
            break;
        case 1:
            $orderStatus = 'Chờ duyệt';
            break;
        case 2:
            $orderStatus = 'Đang giao';
            break;
        case 3:
            $orderStatus = 'Đã giao';
            break;
        default:
            $orderStatus = 'N/A';
            break;
    }

    switch ($order['PhThucTT']) {
        case 1:
            $paymentMethod = 'Thanh toán khi nhận hàng';
            break;
        case 2:
            $paymentMethod = 'Chuyển khoản';
            break;
        default:
            $paymentMethod = 'N/A';
            break;
    }

    switch ($order['PhThucVC']) {
        case 0:
            $deliveryMethod = 'Giao hàng tiêu chuẩn';
            break;
        case 1:
            $deliveryMethod = 'Giao hàng hỏa tốc';
            break;
        default:
            $deliveryMethod = 'N/A';
            break;
    }
?>

<div class="admin-wrapper" id="order-detail-wrapper">
    <div class="admin-header" id="order-header">
        <h2>Chi tiết đơn hàng</h2>
    </div>
    <div id="order-detail-form">
        <div class="general-order-info" id="order-id-div">
            <label class="order-create-label" for="order-id">ID đơn hàng:</label><br>
            <input class="order-create-text" type="text" name="order_id" id="order-id-input" value="<?= htmlspecialchars(number_format($order['MaHD'])) ?>" readonly>
        </div>

        <div class="general-order-info" id="order-status-div">
            <label class="order-create-label" for="order-status">Trạng thái:</label><br>
            <input class="order-create-text" type="text" name="order_status" id="order-status-input" value="<?= htmlspecialchars($orderStatus) ?>" readonly>
        </div>

        <div class="general-order-info" id="order-customer-div">
            <label class="order-create-label" for="order-customer">Tên khách hàng:</label><br>
            <input class="order-create-text" type="text" name="order_customer" id="order-customer-input" value="<?= htmlspecialchars($user['TenND']) ?>" readonly>
        </div>

        <div class="general-order-info" id="order-staff-div">
            <label class="order-create-label" for="order-staff">ID nhân viên:</label><br>
            <input class="order-create-text" type="text" name="order_staff" id="order-staff-input" value="<?= htmlspecialchars(number_format($order['MaNV'])) ?>" readonly>
        </div>

        <div class="general-order-info" id="order-date-div">
            <label class="order-create-label" for="order-date">Ngày tạo:</label><br>
            <input class="order-create-text" type="text" name="order_date" id="order-date-input" value="<?= date_format(new DateTime($order['NgLap']), "d/m/Y") ?>" readonly>
        </div>

        <div class="general-order-info" id="order-phone-div">
            <label class="order-create-label" for="order-phone">Số điện thoại:</label><br>
            <input class="order-create-text" type="text" name="order_phone" id="order-phone-input" value="<?= htmlspecialchars($user['SDT']) ?>" readonly>
        </div>

        <div class="general-order-info-full" id="order-address-div">
            <label class="order-create-label" for="address-id">Địa chỉ:</label><br>
            <input class="order-create-text" type="text" name="order_address" id="order-address-input" value="<?= htmlspecialchars($order['DiaChiGiaoHang']) ?>" readonly>
        </div>
        <div class="general-order-info" id="order-delivery-div">
            <label class="order-create-label" for="order-delivery">Phương thức vận chuyển:</label><br>
            <input class="order-create-text" type="text" name="order_delivery" id="order-delivery-input" value="<?= htmlspecialchars($paymentMethod) ?>" readonly>
        </div>

        <div class="general-order-info" id="order-payment-div">
            <label class="order-create-label" for="order-payment">Phương thức thanh toán:</label><br>
            <input class="order-create-text" type="text" name="order_payment" id="order-payment-input" value="<?= htmlspecialchars($deliveryMethod) ?>" readonly>
        </div>

        <div class="general-order-info-full" id="order-note">
            <label class="order-create-label" for="order-note">Ghi chú:</label><br>
            <textarea class="order-create-text" name="order_note" id="order-note-input"readonly><?= htmlspecialchars($order['GhiChu']) ?></textarea>
        </div>
    </div>

    <p class="order-create-label" id="orderDetailHeader">Danh sách sản phẩm</p>
    <table class="admin-list-container">
        <thead class="admin-list-header">
            <tr class="admin-list-header-content">
                <th id="order-detail-product-order">STT</th>
                <th id="order-detail-product-name">Tên sản phẩm</th>
                <th id="order-detail-product-category">Thể loại</th>
                <th id="order-detail-product-number">Số lượng</th>
                <th id="order-detail-product-price">Tổng tiền</th>
            </tr>
        </thead>
        <tbody class="admin-list-body">
            <?php 
                $orderDetail_order = 1;
                $totalValue = 0;
                foreach ($details as $index => $detail): 
                    $TotalOfProduct = $detail['DonGia'] * $detail['SoLg'];  
                    $totalValue += $TotalOfProduct;
            ?>
            <tr>
                <td class="admin-list-body-content-num" id="order-detail-product-order"><?= $orderDetail_order++ ?></td>
                <td class="admin-list-body-content-other" id="order-detail-product-name"><?= htmlspecialchars($detail['TenSach']) ?></td>
                <td class="admin-list-body-content-num" id="order-detail-product-category"><?= htmlspecialchars($detail['TenLoai']) ?></td>
                <td class="admin-list-body-content-num" id="order-detail-product-number"><?= htmlspecialchars(number_format($detail['SoLg'])) ?></td>
                <td class="admin-list-body-content-num" id="order-detail-product-price"><?= htmlspecialchars(number_format($TotalOfProduct)) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div id="orderDetailTotalValueDiv">
        <div id="orderDetailTotalValue">
            <label for="order-total-value" id="order-total-value-label">Thành tiền:</label>
            <input type="text" name="order_total_value" id="order-total-value-input" value="<?= htmlspecialchars(number_format($totalValue)) ?>" readonly>
        </div>
    </div>
    <div>
        <button type="button" class="order-detail-close-Btns" id="closeOrderDetailBtn" onclick="location.href='?page=order&action=index&current_page=<?= $currentPage ?>'">
            <i class='bx bx-check'></i>
            Xong
        </button>
    </div>
</div>