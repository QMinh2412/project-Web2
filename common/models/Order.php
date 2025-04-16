<?php
    require_once __DIR__ . '/../config/Database.php';
    require_once __DIR__ . '/../models/Account.php';
    require_once __DIR__ . '/../models/User.php';

    class Order {
        protected $db;

        public function __construct() {
            $this->db = Database::getInstance();
        }

        public function getAllOrders($currentpage, $orderperpage) {
            $offset = ($currentpage - 1) * $orderperpage;
            $limit = $orderperpage;

            $query = "SELECT * FROM HoaDon LIMIT $offset, $limit";

            $stmt = $this->db->prepare($query);
            if (!$stmt) {
                die("Prepare failed: " . $this->db->error);
            }

            $stmt->execute();
            $result = $stmt->get_result();
            $orders = [];

            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $orders[] = $row; 
                }
            }

            $stmt->close();
            return $orders;
        }
    }
?>