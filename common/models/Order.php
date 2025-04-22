<!-- cần thông tin bên folder user -->
<?php
    require_once __DIR__ . '/../config/Database.php';
    require_once __DIR__ . '/../models/User.php';
    require_once __DIR__ . '/../models/Account.php';
    require_once __DIR__ . '/../models/OrderDetail.php';

    class Order {
        protected $db;

        public function __construct() {
            $this->db = Database::getInstance();
        }

        public function createOrder($account_id, $items, $personalInfo, $shipping_method, $payment_method) {
            try {
                $this->db->beginTransaction();
    
                // Tính tổng tiền
                $total = array_sum(array_map(fn($item) => $item['GiaBan'] * $item['SoLg'], $items));
                $shipping_fee = $shipping_method === 'express' ? $total * 0.1 : 0;
                $total += $shipping_fee;
    
                // Tạo đơn hàng (HoaDon)
                $sql = "INSERT INTO HoaDon (MaNV, MaKH, NgLap, TrangThaiDH, GhiChu, DiaChiGiaoHang, PhThucTT, PhThucVC, SDT, TongTien) 
                        VALUES (?, ?, NOW(), 1, ?, ?, ?, ?, ?, ?)";
                $stmt = $this->db->prepare($sql);
                $maNV = 0; // Giả sử MaNV mặc định là 2 (có thể lấy từ hệ thống)
                $stmt->bind_param("iissiisi", 
                    $maNV, 
                    $account_id, 
                    $personalInfo['note'], 
                    $personalInfo['address'], 
                    $payment_method, 
                    $shipping_method, 
                    $personalInfo['phone'], 
                    $total
                );
                $stmt->execute();
                $order_id = $this->db->insert_id;
    
                // Thêm chi tiết đơn hàng (CTHD)
                $sql = "INSERT INTO CTHD (SoLg, MaHD, MaSach) VALUES (?, ?, ?)";
                $stmt = $this->db->prepare($sql);
                foreach ($items as $item) {
                    $stmt->bind_param("iii", $item['SoLg'], $order_id, $item['MaSach']);
                    $stmt->execute();
                }
    
                // Cập nhật tồn kho
                $productModel = new Product();
                foreach ($items as $item) {
                    $productModel->updateStock($item['MaSach'], $item['SoLg']);
                }
    
                $this->db->commit();
                return $order_id;
            } catch (Exception $e) {
                $this->db->rollBack();
                return false;
            }
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

        public function changeOrderStatusById($orderId, $newStatus) {
            $query = "UPDATE HoaDon SET TrangThaiDH = ? WHERE MaHD = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ii", $newStatus, $orderId);
            
            return $stmt->execute();
        }

        public function getFilteredOrders($currentPage, $ordersPerPage, $orderId = '', $status = '', $fromDate = '', $toDate = '') {
            $offset = ($currentPage - 1) * $ordersPerPage;
            $conditions = "WHERE 1=1";
        
            // Gắn điều kiện nếu có giá trị
            if (!empty($orderId)) {
                $conditions .= " AND MaHD = " . intval($orderId);
            }
        
            if (isset($status) && is_numeric($status)) {
                $conditions .= " AND TrangThaiDH = " . intval($status);
            }
        
            if (!empty($fromDate)) {
                $conditions .= " AND NgLap >= '" . $this->db->real_escape_string($fromDate) . "'";
            }
        
            if (!empty($toDate)) {
                $conditions .= " AND NgLap <= '" . $this->db->real_escape_string($toDate) . "'";
            }
        
            // Câu truy vấn chính
            $query = "SELECT * FROM HoaDon $conditions ORDER BY NgLap DESC LIMIT $ordersPerPage OFFSET $offset";
            $result = $this->db->query($query);
        
            $orders = [];
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $orders[] = $row;
                }
            }
            
            return $orders;
        }
        

        public function getOrderPaginationFiltered($currentPage, $ordersPerPage, $orderId = '', $status = '', $fromDate = '', $toDate = '') {
            $conditions = "WHERE 1=1";
        
            if (!empty($orderId)) {
                $conditions .= " AND MaHD = " . intval($orderId);
            }
        
            if (isset($status) && is_numeric($status)) {
                $conditions .= " AND TrangThaiDH = " . intval($status);
            }
        
            if (!empty($fromDate)) {
                $conditions .= " AND NgLap >= '" . $this->db->real_escape_string($fromDate) . "'";
            }
        
            if (!empty($toDate)) {
                $conditions .= " AND NgLap <= '" . $this->db->real_escape_string($toDate) . "'";
            }
        
            $query = "SELECT COUNT(*) as total FROM HoaDon $conditions";
            $result = $this->db->query($query);
            $row = $result->fetch_assoc();
            $totalOrder = $row['total'];
            $totalPages = ceil((int)$totalOrder / (int)$ordersPerPage);
        
            return [
                'totalOrders' => $totalOrder,
                'totalPages' => $totalPages,
                'currentPage' => $currentPage
            ];
        }
        
    }
?>