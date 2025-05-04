<?php
// Thư mục lưu trữ ảnh được tải lên
$uploadDir = 'C:/xampp/htdocs/project-Web2/common/images/Ảnh minh chứng/';

// Kiểm tra và tạo thư mục nếu chưa tồn tại
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Kiểm tra xem form đã được gửi chưa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['proof_image'])) {
    $orderId = isset($_POST['order_id']) ? htmlspecialchars($_POST['order_id']) : '';
    $file = $_FILES['proof_image'];

    // Kiểm tra file
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxFileSize = 5 * 1024 * 1024; 

    if (!in_array($file['type'], $allowedTypes)) {
        echo json_encode(['status' => 'error', 'message' => 'Chỉ chấp nhận file JPEG, PNG hoặc GIF.']);
        exit;
    }

    if ($file['size'] > $maxFileSize) {
        echo json_encode(['status' => 'error', 'message' => 'Kích thước file không được vượt quá 5MB.']);
        exit;
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['status' => 'error', 'message' => 'Lỗi khi tải file lên.']);
        exit;
    }

    // Tạo tên file duy nhất để tránh xung đột
    $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newFileName = 'proof_' . $orderId . '_' . time() . '.' . $fileExtension;
    $destination = $uploadDir . $newFileName;

    // Di chuyển file đã tải lên đến thư mục đích
    if (move_uploaded_file($file['tmp_name'], $destination)) {
       
        echo json_encode(['status' => 'success', 'message' => 'Tải minh chứng thành công!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Không thể lưu file.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Không có file được tải lên.']);
}
?>