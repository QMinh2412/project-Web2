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

        public function getAllUsers() {
            $query = "
                SELECT 
                    NgDung.MaND, NgDung.TenND, NgDung.DcND, NgDung.EmailND, NgDung.GioiTinhND,
                    NgDung.SDT, NgDung.NgSinhND, 
                    TaiKhoan.MaTK, TaiKhoan.TenTK, TaiKhoan.LoaiTK, TaiKhoan.NgLap, TaiKhoan.TinhTrang
                FROM NgDung
                LEFT JOIN TaiKhoan ON NgDung.MaND = TaiKhoan.MaND
                WHERE TaiKhoan.LoaiTK != 4
            ";
    
            $result = $this->db->query($query);
            $users = [];
    
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
    
            return $users;
        }

        public function getById($id) {
            $query = "SELECT * FROM NgDung WHERE MaND = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = null;
    
            if ($result && $row = $result->fetch_assoc()) {
                $user = $row;
            }
    
            $stmt->close();
            return $user;
        }

        public function updateUser($user_id, $fullname, $address, $email, $gender, $phone, $dob) {
            $query = "UPDATE NgDung SET TenND = ?, DcND = ?, EmailND = ?, GioiTinhND = ?, SDT = ?, NgSinhND = ? WHERE MaND = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ssssssi", $fullname, $address, $email, $gender, $phone, $dob, $user_id);
            $stmt->execute();
            $stmt->close();
        } 
    }
?>