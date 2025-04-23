<?php
require_once __DIR__ . '/../../common/core/BaseController.php';
require_once __DIR__ . '/../../common/models/Import.php';

class ImportController {
    // Hiển thị giao diện nhập sách
    public function index() {
        require_once __DIR__ . '/../views/import/nhapsach.php';
    }

    // Lưu phiếu nhập
    public function save() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $importModel = new Import();

            // Lấy dữ liệu từ form
            $supplierId = $_POST['supplier_id'];
            $employeeId = $_POST['employee_id'];
            $importDate = $_POST['import_date'];
            $products = $_POST['products']; // Danh sách sản phẩm nhập

            // Gọi model để lưu dữ liệu
            $result = $importModel->saveImport($supplierId, $employeeId, $importDate, $products);

            if ($result) {
                echo "<script>
                    alert('Lưu phiếu nhập thành công!');
                    window.location.href = '?page=import&action=history';
                </script>";
            } else {
                echo "<script>
                    alert('Lưu phiếu nhập thất bại!');
                </script>";
            }
        }
    }

    // Hiển thị lịch sử nhập hàng
    public function history() {
        $importModel = new Import();

        // Lấy dữ liệu lịch sử nhập hàng từ model
        $importHistory = $importModel->getImportHistory();

        // Gửi dữ liệu đến view
        require_once __DIR__ . '/../views/import/history.php';
    }

    // Hiển thị chi tiết phiếu nhập
    public function detail($id) {
        $importModel = new Import();

        // Lấy dữ liệu chi tiết phiếu nhập từ model
        $importDetail = $importModel->getImportDetail($id);

        // Gửi dữ liệu đến view
        require_once __DIR__ . '/../views/import/detail.php';
    }
}