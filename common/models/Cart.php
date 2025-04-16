<?php
    require_once __DIR__ . '/../config/Database.php';
    class Cart{
        protected $db;

        public function __construct() {
            $this->db = Database::getInstance();
        }

        public function getCartById($account_id) {
            $account_id = $this->db->real_escape_string($account_id);
            $query = "SELECT * FROM GioHang WHERE MaTK = '$account_id'";
            $result = $this->db->query($query);
        
            if ($result) {
                return $result->fetch_assoc(); // Trả về một bản ghi
            }
        
            return null;
        }

        public function deleteCart($account_id) {
            $account_id = $this->db->real_escape_string($account_id);
            $query = "DELETE FROM GioHang WHERE MaTK = '$account_id'";
            return $this->db->query($query);
        }
    }
?>