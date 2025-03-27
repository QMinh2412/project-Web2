<?php
// admin/controllers/DashboardController.php

require_once __DIR__ . '/../../common/core/BaseController.php';

class DashboardController extends BaseController {
    public function index() {
        // Chuẩn bị dữ liệu để gửi vào view, ở đây chỉ in "Hello World"
        $data = [
            'message' => 'Hello World'
        ];
        
        // Gọi phương thức render để hiển thị view dashboard/index.php
        $this->render('dashboard/index', $data);
    }
}