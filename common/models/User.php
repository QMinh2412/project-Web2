<?php
    require_once __DIR__ . '/../config/Database.php';
    class User{
        protected $db;
        public function __construct() {
            // Lấy kết nối database từ Database.php
            $this->db = database::getInstance();
        }

        public function createUser($fullname, $address, $email, $gender, $phone, $dob) {
            $sql = "INSERT INTO NgDung (TenND, DcND, EmailND, GioiTinhND, SDT, NgSinhND) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
        
            if (!$stmt) {
                // Lỗi khi prepare statement
                die(json_encode([
                    "status" => "error",
                    "message" => "Lỗi SQL: " . $this->db->error
                ]));
            }
        
            // Ràng buộc tham số và kiểm tra lỗi
            if (!$stmt->bind_param("ssssss", $fullname, $address, $email, $gender, $phone, $dob)) {
                die(json_encode([
                    "status" => "error",
                    "message" => "Lỗi khi bind_param: " . $stmt->error
                ]));
            }
        
            // Thực thi truy vấn và kiểm tra lỗi
            if (!$stmt->execute()) {
                die(json_encode([
                    "status" => "error",
                    "message" => "Lỗi khi execute: " . $stmt->error
                ]));
            }
        
            $insertId = $this->db->insert_id;
            $stmt->close();
        
            return $insertId;
        }
        
    }
?>