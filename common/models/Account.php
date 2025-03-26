<?php
require_once __DIR__ . '/../config/Database.php';

class Account {
    protected $db;

    public function __construct() {
        // Lấy kết nối database từ Database.php
        $this->db = database::getInstance();
    }

    public function getById($id) {
        $result = $this->db->query("SELECT * FROM taikhoan WHERE MaTK = $id");
        return $result->fetch_assoc();
    }

    public function getImage($id){
        $query = "select DgDanAnh
                    from hinhanh
                    where hinhanh.MaND = taikhoan.MaND and MaTK = $id";
        $result = $this->db->query($query);
        return $result;
    }

    public function emailExist($email) {
        $sql = "SELECT COUNT(*) as count FROM NgDung WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("s", $email);            
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();            
            return $row['count'] == 0;
        }
        return false;
    }

    public function createAccount($username, $role, $created_at, $status, $password, $user_id) {
        $sql = "INSERT INTO accounts (username, role, created_at, status, password, user_id) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sisiis", $username, $role, $created_at, $status, $password, $user_id);
        $stmt->execute();
        $stmt->close();
    }
}
?>
