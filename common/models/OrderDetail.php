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
        
        public function getOrderDetailsByOrderId($orderId) {
            $query = "SELECT CTHD.SoLg, CTHD.MaSach, DS.TenSach, TL.TenLoai, DS.GiaBan
                        FROM CTHD 
                        JOIN DauSach DS ON CTHD.MaSach = DS.MaSach
                        JOIN TheLoai TL ON DS.MaLoai = TL.MaLoai
                        WHERE CTHD.MaHD = '$orderId'";

            $result = $this->db->query($query);
            
            $details = [];
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $details[] = $row;
                }
            }

            return $details;
        }
    }
?>