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
        
        public function createOrderDetail($order_id, $product_id, $quantity) {
            if (!$order_id || !$product_id || !$quantity) {
                error_log("Invalid input for createOrderDetail: order_id=$order_id, product_id=$product_id, quantity=$quantity");
                return false;
            }
        
            $query = "INSERT INTO CTHD (MaHD, MaSach, SoLg) VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($query);
            if (!$stmt) {
                error_log("Prepare failed: " . $this->db->error);
                return false;
            }
        
            $stmt->bind_param("iii", $order_id, $product_id, $quantity);
            $result = $stmt->execute();
            if (!$result) {
                error_log("Execute failed: " . $stmt->error);
                $stmt->close();
                return false;
            }
        
            $stmt->close();
            return true;
        }
    }
?>