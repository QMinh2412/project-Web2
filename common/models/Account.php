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
    public function getAccountIdByEmail($email) {
        $query = "SELECT MaTK FROM TaiKhoan WHERE MaND = (SELECT MaND FROM NgDung WHERE EmailND = '$email')";
        $result = $this->db->query($query);

        if ($result && $row = $result->fetch_assoc()) {
            return $row['MaTK']; // Trả về mã tài khoản
        }

        return null; // Trả về null nếu không tìm thấy
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
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // Mã hóa mật khẩu
        $sql = "INSERT INTO TaiKhoan (TenTK, LoaiTK, NgLap, TinhTrang, MKTK, MaND) 
                VALUES ('$username', $role, '$created_at', $status, '$hashedPassword', $user_id)";
        
        if (!$this->db->query($sql)) {
            die("Lỗi SQL (query): " . $this->db->error); // Debug lỗi query
        }
        
        return true; // Trả về true nếu thành công
    }

    public function isAccountLocked($email) {
        $sql = "SELECT TinhTrang FROM TaiKhoan WHERE MaND = (SELECT MaND FROM NgDung WHERE EmailND = ?)";
        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            die("Lỗi SQL (prepare): " . $this->db->error); // Debug lỗi prepare
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $stmt->close();
            return $row['TinhTrang'] == 1; // Trả về true nếu tài khoản bị khóa
        }

        $stmt->close();
        return false; // Trả về false nếu không tìm thấy tài khoản
    }

    public function isPasswordCorrect($email, $password) {
        $sql = "SELECT MKTK FROM TaiKhoan 
                WHERE MaND = (SELECT MaND FROM NgDung WHERE EmailND = ?)";
        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            die("Lỗi SQL (prepare): " . $this->db->error); // Debug lỗi prepare
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $hashedPassword = $row['MKTK'];
            $stmt->close();
            // Kiểm tra mật khẩu đã mã hóa bằng password_hash
            return password_verify($password, $hashedPassword);
        }

        $stmt->close();
        return false; // Trả về false nếu không tìm thấy tài khoản
    }
}
?>
