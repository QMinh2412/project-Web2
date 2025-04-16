<?php
    require_once __DIR__ . '/../config/Database.php';
    require_once __DIR__ . '/../models/Order.php';
    require_once __DIR__ . '/../models/Product.php';

    class OrderDetail {
        protected $db;

        public function __construct() {
            $this->db = Database::getInstance();
        }

        public function deleteDetailsByUserId($id) {
            $query = "DELETE C FROM CTHD C 
                      JOIN HoaDon H ON C.MaHD = H.MaHD 
                      WHERE H.MaKH = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        }
        
    }
?>