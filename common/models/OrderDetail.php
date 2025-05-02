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
            $query = "SELECT CTHD.SoLg, CTHD.MaSach, DS.TenSach, TL.TenLoai, CTHD.DonGia
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

        public function createOrderDetail($order_id, $product_id, $quantity, $price) {
            if (!$order_id || !$product_id || !$quantity) {
                error_log("Invalid input for createOrderDetail: order_id=$order_id, product_id=$product_id, quantity=$quantity");
                return false;
            }
        
            $query = "INSERT INTO CTHD (MaHD, MaSach, SoLg, DonGia) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            if (!$stmt) {
                error_log("Prepare failed: " . $this->db->error);
                return false;
            }
        
            $stmt->bind_param("iiii", $order_id, $product_id, $quantity, $price);
            $result = $stmt->execute();
            if (!$result) {
                error_log("Execute failed: " . $stmt->error);
                $stmt->close();
                return false;
            }
        
            $stmt->close();
            return true;
        }

        public function getOrderDetailByOrderId($orderId){
            $query = "SELECT * FROM CTHD WHERE MaHD = $orderId";
            $result = $this->db->query($query);
            $orderDetails = [];
            $productModel = new Product();

            if($result){
                while($row = $result->fetch_assoc()){
                    $productInfo = $productModel->getProductById($row['MaSach']);
                    $row['TenSach'] = $productInfo['TenSach'];
                    $orderDetails[] = $row;
                }
            }

            return $orderDetails;
        }
    }
?>