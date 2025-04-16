<?php
    require_once __DIR__ . '/../../common/config/Database.php';

    class Customer {
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
                    tk.LoaiTK AS account_type
                FROM TaiKhoan tk
                JOIN NgDung nd ON tk.MaND = nd.MaND
                WHERE tk.LoaiTK = 0
                LIMIT 5"; 
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $customers = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

            // Gắn số đơn hàng và tổng tiền mặc định bằng 0
            foreach ($customers as &$customer) {
                $customer['order_count'] = 0; // Số đơn hàng mặc định
                $customer['total_amount'] = 0; // Tổng tiền mặc định
            }

            return $customers;
        }
    }
?>