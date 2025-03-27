<?php
// common/core/BaseController.php

class BaseController {
    public function render($view, $data = []) {
        // Giải nén mảng dữ liệu để tạo các biến cục bộ, ví dụ $title, $message,...
        extract($data);

        // Lấy nội dung của view con bằng output buffering
        ob_start();
        $viewPath = __DIR__ . '/../../admin/views/' . $view . '.php';
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            echo "View not found: " . $viewPath;
        }
        $content = ob_get_clean();

        // Sau đó, nạp file layout và truyền nội dung view con vào biến $content
        $layoutPath = __DIR__ . '/../../admin/views/layouts/main_layout.php';
        if (file_exists($layoutPath)) {
            include $layoutPath;
        } 
        else {
            echo "Layout not found: " . $layoutPath;
        }
    }
}