<?php
    require_once __DIR__ . '/../config/Database.php';

    class Login {
        protected $db;

        public function __construct() {
            $this->db = Database::getInstance();
        }

        // Lấy thông tin tài khoản dựa trên tên tài khoản
        public function getUserByUsername($TenTK) {
            $query = "SELECT * FROM TaiKhoan WHERE TenTK = ?";
            $stmt = $this->db->prepare($query);

            if ($stmt) {
                $stmt->bind_param("s", $TenTK);
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();
                $stmt->close();
                return $user; // Trả về thông tin tài khoản nếu tìm thấy
            }

            return null; // Trả về null nếu không tìm thấy tài khoản
        }

        // Kiểm tra mật khẩu
        public function verifyPassword($inputPassword, $hashedPassword) {
            // So sánh mật khẩu người dùng nhập với mật khẩu đã hash trong cơ sở dữ liệu
            return hash('sha256', $inputPassword) === $hashedPassword;
        }
    }
?>