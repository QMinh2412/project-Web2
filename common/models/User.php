<?php
    require_once __DIR__ . '/../config/Database.php';
    class User{
        protected $db;
        public function __construct() {
            // Lấy kết nối database từ Database.php
            $this->db = database::getInstance();
        }

        public function createUser($fullname, $address, $email, $gender, $phone, $dob) {
            $sql = "INSERT INTO users (fullname, address, email, gender, phone, dob) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ssssss", $fullname, $address, $email, $gender, $phone, $dob);
            $stmt->execute();
            $stmt->close();
            return $this->db->insert_id;
        }
    }
?>