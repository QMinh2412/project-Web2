<?php
require_once __DIR__ . '/../config/Database.php';

class Account {
    protected $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getById($id) {
        $sql = "SELECT * FROM TaiKhoan WHERE MaTK = ?";
        $stmt = $this->db->prepare($sql);
        if (!$stmt) return null;
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        return $data;
    }

    public function getAccountIdByEmail($email) {
        $query = "SELECT MaTK FROM TaiKhoan WHERE MaND = (SELECT MaND FROM NgDung WHERE EmailND = ?)";
        $stmt = $this->db->prepare($query);
        if (!$stmt) return null;
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $stmt->close();
            return $row['MaTK'];
        }
        $stmt->close();
        return null;
    }

    public function getNameById($id) {
        $result = $this->db->query("SELECT TenTK FROM TaiKhoan WHERE MaND = $id");
        if ($result && $row = $result->fetch_assoc()) {
            return $row['TenTK'];
        }
        return null;
    }

    public function getImage($id) {
        $query = "SELECT DgDanAnh FROM HinhAnh WHERE MaND = ?";
        $stmt = $this->db->prepare($query);
        if (!$stmt) return null;
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $stmt->close();
            return $row['DgDanAnh'];
        }
        $stmt->close();
        return null;
    }

    public function emailExist($email) {
        $sql = "SELECT COUNT(*) as count FROM NgDung WHERE EmailND = ?";
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            die("Lỗi truy vấn: " . $this->db->error);
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $stmt->close();
            return $row['count'] > 0;
        }
        $stmt->close();
        return false;
    }

    public function createAccount($username, $role, $created_at, $status, $password, $user_id) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO TaiKhoan (TenTK, LoaiTK, NgLap, TinhTrang, MKTK, MaND) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("sissss", $username, $role, $created_at, $status, $hashedPassword, $user_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function isAccountLocked($email) {
        $sql = "SELECT TinhTrang FROM TaiKhoan WHERE MaND = (SELECT MaND FROM NgDung WHERE EmailND = ?)";
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            die("Lỗi SQL (prepare): " . $this->db->error);
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $stmt->close();
            return $row['TinhTrang'] == 1;
        }
        $stmt->close();
        return false;
    }

    public function isPasswordCorrect($email, $password) {
        $sql = "SELECT MKTK FROM TaiKhoan WHERE MaND = (SELECT MaND FROM NgDung WHERE EmailND = ?)";
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            die("Lỗi SQL (prepare): " . $this->db->error);
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $hashedPassword = $row['MKTK'];
            $stmt->close();
            return password_verify($password, $hashedPassword);
        }
        $stmt->close();
        return false;
    }

    public function getEmailById($id) {
        $sql = "SELECT EmailND FROM NgDung WHERE MaND = ?";
        $stmt = $this->db->prepare($sql);
        if (!$stmt) return null;
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $stmt->close();
            return $row['EmailND'];
        }
        $stmt->close();
        return null;
    }

    public function updatePassword($account_id, $new_password) {
        $hashedPassword = password_hash($new_password, PASSWORD_BCRYPT);
        $sql = "UPDATE TaiKhoan SET MKTK = ? WHERE MaND = ?";
        $stmt = $this->db->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("si", $hashedPassword, $account_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function updateAccountName($account_id, $username) {
        $sql = "UPDATE TaiKhoan SET TenTK = ? WHERE MaND = ?";
        $stmt = $this->db->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("si", $username, $account_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
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

    public function lockAccount($id) {
        $query = "UPDATE TaiKhoan SET TinhTrang = 0 WHERE MaND = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    public function getRoleByEmail($email){
        $query = "SELECT LoaiTK FROM TaiKhoan WHERE MaND = ( SELECT MaND FROM NgDung WHERE EmailND = $email)";
        $result = $this->db->query($query);
        return $result;
    }
}
?>