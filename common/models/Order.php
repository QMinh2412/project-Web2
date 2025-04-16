<?php
require_once __DIR__ . '/../config/Database.php';

class Order {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function createOrder($account_id, $id_book, $quantity, $total, $fullname, $phone, $address, $note, $payment_method, $shipping_method) {
        $sql = "INSERT INTO DonHang (MaND, MaSach, SoLuong, TongTien, HoTen, SDT, DiaChi, GhiChu, PhuongThucThanhToan, PhuongThucVanChuyen) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param("iiidssssss", $account_id, $id_book, $quantity, $total, $fullname, $phone, $address, $note, $payment_method, $shipping_method);
        $result = $stmt->execute();
        $order_id = $stmt->insert_id;
        $stmt->close();
        return $result ? $order_id : false;
    }

    public function getById($order_id) {
        $sql = "SELECT * FROM DonHang WHERE MaDH = ?";
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $order = $result->fetch_assoc();
        $stmt->close();
        return $order;
    }
}
?>