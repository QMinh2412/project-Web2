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

        public function getAllOrdersWithTotals($currentpage, $orderperpage) {
            $offset = ($currentpage - 1) * $orderperpage;
            $limit  = $orderperpage;
        
            $query = "
                SELECT 
                    hd.MaHD,
                    hd.MaKH,
                    hd.NgLap,
                    hd.TrangThaiDH,
                    SUM(ct.SoLg * ds.GiaBan) AS TongTien
                FROM HoaDon hd
                LEFT JOIN CTHD ct ON hd.MaHD = ct.MaHD
                LEFT JOIN DauSach ds ON ct.MaSach = ds.MaSach
                GROUP BY hd.MaHD
                ORDER BY hd.MaHD ASC
                LIMIT ?, ?
            ";
        
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ii", $offset, $limit);
            $stmt->execute();
            $res = $stmt->get_result();
        
            $orders = [];

            if ($res) {
                while ($row = $res->fetch_assoc()) {
                    $orders[] = $row;
                }
            }
            
            $stmt->close();
            return $orders;
        }
        
        public function getOrderPagination($currentpage, $orderperpage) {
            $query = "SELECT COUNT(*) AS total FROM HoaDon";
            $result = $this->db->query($query);
            $row = $result->fetch_assoc();
            $totalOrder = $row['total'];
            $totalPages = ceil($totalOrder / $orderperpage);
            
            return [
            'totalPages' => $totalPages,
            'currentPage' => $currentpage
            ];
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