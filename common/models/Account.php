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

    public function phoneExist($phone) {
        $sql = "SELECT COUNT(*) as count FROM NgDung WHERE SDT = ?";
        $stmt = $this->db->prepare($sql);
    
        if (!$stmt) {
            die("Lỗi truy vấn: " . $this->db->error); // Debug nếu truy vấn lỗi
        }
    
        $stmt->bind_param("s", $phone);            
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $stmt->close();
            return $row['count'] > 0; // Trả về true nếu số điện thoại tồn tại
        }
    
        $stmt->close();
        return false;
    }

    public function usernameExist($username) {
        $sql = "SELECT COUNT(*) as count FROM TaiKhoan WHERE TenTK = ?";
        $stmt = $this->db->prepare($sql);
    
        if (!$stmt) {
            die("Lỗi truy vấn: " . $this->db->error); // Debug nếu truy vấn lỗi
        }
    
        $stmt->bind_param("s", $username);            
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $stmt->close();
            return $row['count'] > 0; // Trả về true nếu tên tài khoản tồn tại
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

    public function updateAccount($username, $role, $password, $user_id) {
        if (!empty($password)) {
            // Hash the new password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
            // Update all fields including the password
            $query = "UPDATE TaiKhoan SET TenTK = ?, LoaiTK = ?, MKTK = ? WHERE MaND = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("sisi", $username, $role, $hashedPassword, $user_id);
        } else {
            // If password is empty, update everything except password
            $query = "UPDATE TaiKhoan SET TenTK = ?, LoaiTK = ? WHERE MaND = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("sii", $username, $role, $user_id);
        }

        $stmt->execute();
        $stmt->close();
    }

    public function lockAccount($id, $status) {
        $query = "UPDATE TaiKhoan SET TinhTrang = ? WHERE MaND = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii",$status, $id);
        $stmt->execute();
        $stmt->close();
    }
}
?>