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
                TaiKhoan.MaTK, TaiKhoan.TenTK, TaiKhoan.LoaiTK, TaiKhoan.NgLap, TaiKhoan.TinhTrang, TaiKhoan.DaXoa
            FROM NgDung
            LEFT JOIN TaiKhoan ON NgDung.MaND = TaiKhoan.MaND
            WHERE TaiKhoan.LoaiTK != 4 and TaiKhoan.DaXoa = 0
        ";

        $result = $this->db->query($query);
        $users = [];

        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        $result->close(); 
        return $users;
    }

        public function getFullnameById($id) {
            $query = "SELECT TenND FROM NgDung WHERE MaND = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $fullname = null;
    
            if ($result && $row = $result->fetch_assoc()) {
                $fullname = $row['TenND'];
            }
    
            $stmt->close();
            return $fullname;
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

        // public function updateUser($user_id, $fullname, $address, $email, $gender, $phone, $dob) {
        //     $query = "UPDATE NgDung SET TenND = ?, DcND = ?, EmailND = ?, GioiTinhND = ?, SDT = ?, NgSinhND = ? WHERE MaND = ?";
        //     $stmt = $this->db->prepare($query);
        //     $stmt->bind_param("ssssssi", $fullname, $address, $email, $gender, $phone, $dob, $user_id);
        //     $stmt->execute();
        //     $stmt->close();
        // }
        
        public function getUserPagination($currentPage, $usersPerPage) {
            $offset = ($currentPage - 1) * $usersPerPage;
        
            $query = "
                SELECT 
                    NgDung.MaND, NgDung.TenND, NgDung.DcND, NgDung.EmailND, NgDung.GioiTinhND,
                    NgDung.SDT, NgDung.NgSinhND, 
                    TaiKhoan.MaTK, TaiKhoan.TenTK, TaiKhoan.LoaiTK, TaiKhoan.NgLap, TaiKhoan.TinhTrang
                FROM NgDung
                LEFT JOIN TaiKhoan ON NgDung.MaND = TaiKhoan.MaND
                WHERE TaiKhoan.LoaiTK != 4 
                  AND TaiKhoan.DaXoa = 0
                LIMIT $offset, $usersPerPage
            ";
        
            $result = $this->db->query($query);
            $users = [];
        
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        
            return $users;
        }
        
        public function getPagination($currentPage, $usersPerPage) {
            $query = "
                SELECT COUNT(*) AS total 
                FROM NgDung 
                LEFT JOIN TaiKhoan ON NgDung.MaND = TaiKhoan.MaND
                WHERE TaiKhoan.LoaiTK != 4 
                  AND TaiKhoan.DaXoa = 0
            ";
            $result = $this->db->query($query);
            $row = $result->fetch_assoc();
            $totalUsers = $row['total'];
            $totalPages = ceil($totalUsers / $usersPerPage);
        
            return [
                'totalPages' => $totalPages,
                'currentPage' => $currentPage
            ];
        }
        
        public function getTotalUserCount() {
            $query = "SELECT COUNT(*) AS total FROM NgDung";
            $result = $this->db->query($query);
            $row = $result->fetch_assoc();
            return $row['total'];
        }

        public function deleteUser($user_id) {
            $query = "DELETE FROM NgDung WHERE MaND = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $stmt->close();
        }

        // public function getById($id) {
        //     $sql = "SELECT * FROM NgDung WHERE MaND = ?";
        //     $stmt = $this->db->prepare($sql);
        //     if (!$stmt) {
        //         die(json_encode([
        //             "status" => "error",
        //             "message" => "Lỗi SQL: " . $this->db->error
        //         ]));
        //     }
        //     $stmt->bind_param("i", $id);
        //     $stmt->execute();
        //     $result = $stmt->get_result();
        //     $data = $result->fetch_assoc();
        //     error_log("User data for ID $id: " . print_r($data, true)); // Log để debug
        //     $stmt->close();
        //     return $data;
        // }

        public function updateUser($id, $fullname, $address, $email, $gender, $phone, $dob) {
            $sql = "UPDATE NgDung SET TenND = ?, DcND = ?, EmailND = ?, GioiTinhND = ?, SDT = ?, NgSinhND = ? WHERE MaND = ?";
            $stmt = $this->db->prepare($sql);
            if (!$stmt) {
                die(json_encode([
                    "status" => "error",
                    "message" => "Lỗi SQL: " . $this->db->error
                ]));
            }
            $stmt->bind_param("ssssssi", $fullname, $address, $email, $gender, $phone, $dob, $id);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        }
    }
?>