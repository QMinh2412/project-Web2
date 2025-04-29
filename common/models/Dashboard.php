<?php
    require_once __DIR__ . '/../../common/config/Database.php';

    class Dashboard {
        private $db;

        public function __construct() {
            $this->db = Database::getInstance();
        }

        private function buildDateFilter(&$params, $from = null, $to = null) {
            $filter = "hd.TrangThaiDH = 3";
            if ($from && $to) {
                $filter .= " AND DATE(hd.NgLap) BETWEEN ? AND ?";
                $params[] = $from;
                $params[] = $to;
            }
            return $filter;
        }
        
        // Lấy danh sách khách hàng thân thiết
        public function getLoyalCustomers($from = null, $to = null) {
            $params = [];
            $whereClause = $this->buildDateFilter($params, $from, $to);
        
            $query = "
                SELECT 
                    nd.TenND AS name,
                    nd.EmailND AS email,
                    tk.LoaiTK AS account_type,
                    COUNT(hd.MaHD) AS order_count,
                    SUM(hd.TongTien) AS total_amount
                FROM TaiKhoan tk
                JOIN NgDung nd ON tk.MaND = nd.MaND
                JOIN HoaDon hd ON tk.MaTK = hd.MaKH
                WHERE $whereClause
                GROUP BY tk.MaTK
                ORDER BY total_amount DESC
                LIMIT 5
            ";
        
            $stmt = $this->db->prepare($query);
            if (!empty($params)) {
                $stmt->bind_param(str_repeat('s', count($params)), ...$params);
            }
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }
        
        
        public function getBestSellingProducts($from = null, $to = null) {
            $params = [];
            $whereClause = $this->buildDateFilter($params, $from, $to);
        
            $query = "
                SELECT 
                    ds.TenSach AS TenSach,
                    SUM(ct.SoLg) AS total_sold,
                    SUM(ct.SoLg * ct.DonGia) AS total_revenue
                FROM CTHD ct
                JOIN DauSach ds ON ct.MaSach = ds.MaSach
                JOIN HoaDon hd ON ct.MaHD = hd.MaHD
                WHERE $whereClause
                GROUP BY ds.MaSach
                ORDER BY total_sold DESC
                LIMIT 5
            ";
        
            $stmt = $this->db->prepare($query);
            if (!empty($params)) {
                $stmt->bind_param(str_repeat('s', count($params)), ...$params);
            }
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }        
        
        

        public function getTotalRevenue($from = null, $to = null) {
            $query = "SELECT SUM(TongTien) AS TotalRevenue FROM hoadon WHERE TrangThaiDH = 3";
        
            $params = [];
            $types = '';
        
            if ($from && $to) {
                $query .= " AND DATE(NgLap) BETWEEN ? AND ?";
                $params[] = $from;
                $params[] = $to;
                $types = 'ss';
            }
        
            $stmt = $this->db->prepare($query);
            if (!empty($params)) {
                $stmt->bind_param($types, ...$params);
            }
        
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            return $result['TotalRevenue'] ?? 0;
        }
        
        
        
        public function getTotalCost($from = null, $to = null) {
            $query = "SELECT SUM(TongTien) AS TotalCost FROM phnhap WHERE TinhTrang = 1";
        
            $params = [];
            $types = '';
        
            if ($from && $to) {
                $query .= " AND DATE(NgNhap) BETWEEN ? AND ?";
                $params[] = $from;
                $params[] = $to;
                $types = 'ss';
            }
        
            $stmt = $this->db->prepare($query);
            if (!empty($params)) {
                $stmt->bind_param($types, ...$params);
            }
        
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            return $result['TotalCost'] ?? 0;
        }
        
    }
?>