<?php
// C:\xampp\htdocs\project-Web2\common\models\Order.php
class Order {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getOrderHistory($filters = []) {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            return [];
        }
        $query = "SELECT hd.MaHD, hd.NgLap, cthd.PhThucTT, cthd.PhThucVC 
                  FROM HoaDon hd JOIN CTHD cthd ON hd.MaHD = cthd.MaHD 
                  WHERE hd.MaKH = ?";
        $params = [$_SESSION['user_id']];
        $types = 'i';

        if (!empty($filters['invoice_id'])) {
            $query .= " AND hd.MaHD = ?";
            $params[] = $filters['invoice_id'];
            $types .= 'i';
        }
        if (!empty($filters['status'])) {
            $query .= " AND cthd.TrangThaiDH = ?";
            $params[] = $filters['status'];
            $types .= 'i';
        }
        if (!empty($filters['from_date'])) {
            $query .= " AND cthd.NgLap >= ?";
            $params[] = $filters['from_date'];
            $types .= 's';
        }
        if (!empty($filters['to_date'])) {
            $query .= " AND cthd.NgLap <= ?";
            $params[] = $filters['to_date'];
            $types .= 's';
        }

        $stmt = $this->db->prepare($query);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
        return $orders;
    }

    public function calculateTotal($orderId) {
        $query = "SELECT SUM(GiaBan * SoLg) as TongTien FROM CTHD WHERE MaHD = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $orderId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['TongTien'] ?? 0;
    }

    public function getOrderDetails($orderId) {
        $query = "SELECT cthd.*, ds.TenSach 
                  FROM CTHD cthd JOIN DauSach ds ON cthd.MaSach = ds.MaSach 
                  WHERE cthd.MaHD = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        $details = [];
        while ($row = $result->fetch_assoc()) {
            $details[] = $row;
        }
        return $details;
    }
}