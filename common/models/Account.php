<?php
require_once __DIR__ . '/../config/Database.php';

class Account {
    protected $db;

    public function __construct() {
        // Lấy kết nối database từ Database.php
        $this->db = database::getInstance();
    }

    public function getById($id) {
        $result = $this->db->query("SELECT * FROM taikhoan WHERE MaND = $id");
        return $result->fetch_assoc();
    }

    public function getNameById($id) {
        $result = $this->db->query("SELECT TenTK FROM taikhoan WHERE MaND = $id");
        if ($result && $row = $result->fetch_assoc()) {
            return $row['TenTK'];
        }
        return null;
    }
    
    public function getImage($id) {
        $query = "SELECT DgDanAnh FROM hinhanh WHERE MaND = $id";
        $result = $this->db->query($query);
        if ($result && $row = $result->fetch_assoc()) {
            return $row['DgDanAnh'];
        }
        return null;
    }
    

    public function emailExist($email) {
        $sql = "SELECT COUNT(*) as count FROM NgDung WHERE EmailND = ?";
        $stmt = $this->db->prepare($sql);
    
        if (!$stmt) {
            die("Lỗi truy vấn: " . $this->db->error); // Debug nếu truy vấn lỗi
        }
    
        $stmt->bind_param("s", $email);            
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $stmt->close();
            return $row['count'] > 0; // Trả về true nếu email tồn tại
        }
    
        $stmt->close();
        return false;
    }
    

    public function createAccount($username, $role, $created_at, $status, $password, $user_id) {
        $sql = "INSERT INTO TaiKhoan (TenTK, LoaiTK, NgLap, TinhTrang, MKTK, MaND) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
    
        if (!$stmt) {
            die("Lỗi SQL (prepare): " . $this->db->error); // Debug lỗi prepare
        }
    
        if (!$stmt->bind_param("sisiis", $username, $role, $created_at, $status, $password, $user_id)) {
            die("Lỗi bind_param: " . $stmt->error); // Debug lỗi bind_param
        }
    
        if (!$stmt->execute()) {
            die("Lỗi execute: " . $stmt->error); // Debug lỗi execute
        }
    
        $stmt->close();
        return true; // Trả về true nếu thành công
    }
    
}
?>
