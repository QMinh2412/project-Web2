<?php
    require_once __DIR__ . '/../../common/config/Database.php';

    class Dashboard {
        private $db;

        public function __construct() {
            $this->db = Database::getInstance();
        }

        // Lấy danh sách khách hàng thân thiết
        public function getLoyalCustomers() {
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
                WHERE tk.LoaiTK = 0
                  AND hd.TrangThaiDH = 3
                GROUP BY tk.MaTK
                ORDER BY total_amount DESC
                LIMIT 5
            ";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $customers = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        
            return $customers;
        }
        
        public function getBestSellingProducts() {
            $query = "
                SELECT 
                    ds.TenSach AS TenSach,
                    SUM(ct.SoLg) AS total_sold,
                    SUM(ct.SoLg * ct.DonGia) AS total_amount
                FROM CTHD ct
                JOIN DauSach ds ON ct.MaSach = ds.MaSach
                JOIN HoaDon hd ON ct.MaHD = hd.MaHD
                WHERE hd.TrangThaiDH = 3
                GROUP BY ds.MaSach
                ORDER BY total_sold DESC
                LIMIT 5
            ";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        
            return $products;
        }
        
        

        public function getTotalRevenue() {
            $sql = "SELECT SUM(TongTien) AS TotalRevenue FROM hoadon WHERE TrangThaiDH = 3";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            return $result['TotalRevenue'] ?? 0;
        }
        
        public function getTotalCost() {
            $sql = "SELECT SUM(TongTien) AS TotalRevenue FROM phnhap WHERE TinhTrang = 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            return $result['TotalRevenue'] ?? 0;
        }
    }
?>