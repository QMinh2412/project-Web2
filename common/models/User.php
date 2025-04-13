<?php
require_once __DIR__ . '/../config/Database.php';

class User {
    protected $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function createUser($fullname, $address, $email, $gender, $phone, $dob) {
        $sql = "INSERT INTO NgDung (TenND, DcND, EmailND, GioiTinhND, SDT, NgSinhND) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            die(json_encode([
                "status" => "error",
                "message" => "Lỗi SQL: " . $this->db->error
            ]));
        }

        if (!$stmt->bind_param("ssssss", $fullname, $address, $email, $gender, $phone, $dob)) {
            die(json_encode([
                "status" => "error",
                "message" => "Lỗi khi bind_param: " . $stmt->error
            ]));
        }

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
        ";

        $result = $this->db->query($query);
        $users = [];

        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        return $users;
    }

   public function getById($id) {
    $sql = "SELECT * FROM NgDung WHERE MaND = ?";
    $stmt = $this->db->prepare($sql);
    if (!$stmt) {
        die(json_encode([
            "status" => "error",
            "message" => "Lỗi SQL: " . $this->db->error
        ]));
    }
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    error_log("User data for ID $id: " . print_r($data, true)); // Log để debug
    $stmt->close();
    return $data;
}

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