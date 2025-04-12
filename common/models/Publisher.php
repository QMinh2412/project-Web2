<?php
    require_once __DIR__ . '/../config/Database.php';

    class Publisher {
        protected $db;

        public function __construct() {
            $this->db = Database::getInstance();
        }

        public function getAllPublishers() {
            $query = "SELECT * FROM NXB";
            $result = $this->db->query($query);
            $publishers = [];

            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $publishers[] = $row;
                }
            }

            return $publishers;
        }

        public function createPublisher($publisherData) {
            $query = "INSERT INTO NXB (TenNXB, DcNXB, EmailNXB) VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($query);

            if ($stmt) {
                $stmt->bind_param("sss", $publisherData['TenNXB'], $publisherData['DcNXB'], $publisherData['EmailNXB']);
                if ($stmt->execute()) {
                    return $this->db->insert_id; 
                }
            }

            return false; 
        } 
    }
?>