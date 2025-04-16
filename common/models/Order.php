<!-- cần thông tin bên folder user -->
<?php
    require_once __DIR__ . '/../config/Database.php';
    require_once __DIR__ . '/../models/User.php';
    require_once __DIR__ . '/../models/Account.php';

    class Order {
        protected $db;

        public function __construct() {
            $this->db = Database::getInstance();
        }

        public function getOrderById($id) {
            $query = "SELECT * FROM HoaDon WHERE MaHD = '$id'";
            $result = $this->db->query($query);
            return $result->fetch_assoc();
        }

        public function deleteUserOrder($id) {
            $query = "DELETE FROM HoaDon WHERE MaKH = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        }
    }
?>