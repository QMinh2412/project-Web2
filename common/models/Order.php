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

        public function createOrder($staff_id, $user_id, $createDate, $status, $note, $address, $phone, $paymentMethod, $shippingMethod, $total_bill, $feeShip) {
            $query = "INSERT INTO HoaDon (MaNV, MaKH, NgLap, TrangThaiDH, GhiChu, DiaChiGiaoHang, SDT, PhThucTT, PhThucVC, TongTien, PhiVC) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $this->db->prepare($query);
            if (!$stmt) {
                error_log("Failed to prepare statement: " . $this->db->error);
                return false;
            }

            $stmt->bind_param(
            "iisisssiiii",
            $staff_id,
            $user_id,
            $createDate,
            $status,
            $note,
            $address,
            $phone,
            $paymentMethod,
            $shippingMethod,
            $total_bill,
            $feeShip
            );

            if (!$stmt->execute()) {
                error_log("Failed to execute statement: " . $stmt->error);
                $stmt->close();
                return false;
            }

            $insert_id = $stmt->insert_id;
            $stmt->close();
            return $insert_id;
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

        public function getOrdersByAccountId($account_id, $currentPage, $ordersPerPage = 10) {
            $offset = ($currentPage - 1) * $ordersPerPage;

            // lấy hóa đơn theo tài khoản
            $query = "SELECT * FROM HoaDon WHERE MaKH = $account_id LIMIT $offset, $ordersPerPage";
            $result = $this->db->query($query);
            $orders = [];

            if($result) {
             while ($row = $result->fetch_assoc()) {
                    $orders[] = $row;
                }
            }

            // lấy phân trang cho tổng hóa đơn của tài khoản đó
            $query = "SELECT COUNT(*) AS total FROM HoaDon WHERE MaKH = $account_id";
            $result = $this->db->query($query);
            $row = $result->fetch_assoc();
            $totalOrders = $row['total'];
            $totalPages = ceil($totalOrders / $ordersPerPage);

            return ['orders' => $orders, 'totalPages' => $totalPages, 'currentPage' => $currentPage];
            
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

        public function getFilteredOrdersAndPaginationByAccountId($accountId, $ordersPerPage, $currentPage, $orderId, $orderStatus, $fromDate, $toDate){
            $offset = ($currentPage - 1) * $ordersPerPage;

            $accountId = intval($accountId);
            $currentPage = intval($currentPage);
            // $orderId = intval($orderId);
            // $orderStatus = intval($orderStatus);
            // $fromDate = $this->db->real_escape_string($fromDate);
            // $toDate = $this->db->real_escape_string($toDate);

            $conditions = "WHERE MaKH = $accountId";

            if ($orderId !== '' && is_numeric($orderId)) {
                $conditions .= " AND MaHD = " . intval($orderId);
            }
        
            if ($orderStatus !== '' && is_numeric($orderStatus)) {
                $conditions .= " AND TrangThaiDH = " . intval($orderStatus);
            }
        
            if (!empty($fromDate)) {
                $conditions .= " AND NgLap >= '" . $this->db->real_escape_string($fromDate) . "'";
            }
        
            if (!empty($toDate)) {
                $conditions .= " AND NgLap <= '" . $this->db->real_escape_string($toDate) . "'";
            }

            // truy vấn hóa đơn
            $query = "SELECT * FROM HoaDon $conditions LIMIT $offset, $ordersPerPage";
            $result = $this->db->query($query);
            $orders = [];

            if($result) {
                while ($row = $result->fetch_assoc()) {
                    $orders[] = $row;
                }
            }

            // lấy phân trang cho hóa đơn lọc được của tài khoản đód
            $query = "SELECT COUNT(*) AS total FROM HoaDon $conditions";
            $result = $this->db->query($query);
            $row = $result->fetch_assoc();
            $totalOrders = $row['total'];
            $totalPages = ceil($totalOrders / $ordersPerPage);

            return ['orders' => $orders, 'totalPages' => $totalPages, 'currentPage' => $currentPage];
        }
        
    }
?>