<?php
    require_once __DIR__ . '/../config/Database.php';
    class Image{
        protected $db;

        public function __construct() {
            $this->db = Database::getInstance();
        }

        public function getAllImages() {
            $query = "SELECT * FROM HinhAnh";
            $result = $this->db->query($query);
            $images = [];

            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $images[] = $row;
                }
            }

            return $images;
        }

        public function getImgProduct($id) {
            $query = "SELECT MaHA, DgDanAnh FROM HinhAnh WHERE MaSach = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $images = [];

            while ($row = $result->fetch_assoc()) {
                $images[] = [
                    'MaHA' => $row['MaHA'],
                    'DgDanAnh' => $row['DgDanAnh']
                ]; 
            }

            $stmt->close();
            return $images;
        }

        public function getImageAccount($id_account) {
            if ($id_account === null) return null;
        
            $query = "SELECT * FROM HinhAnh WHERE MaND = (SELECT MaND FROM TaiKhoan WHERE MaTK = ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $id_account);
            $stmt->execute();
            $result = $stmt->get_result();
            $image = null;
        
            if ($result) {
                if ($row = $result->fetch_assoc()) {
                    $image = $row['DgDanAnh'];
                }
            }
        
            $stmt->close();
            return $image;
        }
        
        
        public function getImageById($imageId) {
            $query = "SELECT * FROM HinhAnh WHERE MaHA = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $imageId);
            $stmt->execute();
            $result = $stmt->get_result();
            $image = $result->fetch_assoc();
            $stmt->close();
            return $image;
        }

        public function addImageToProduct($productId, $imagePath) {
            $query = "INSERT INTO HinhAnh (MaSach, DgDanAnh) VALUES (?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("is", $productId, $imagePath);
            $stmt->execute();
            $stmt->close();
        }

        public function addImageToAccount($accountId, $imagePath) {
            $query = "INSERT INTO HinhAnh (MaND, DgDanAnh) VALUES (?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("is", $accountId, $imagePath);
            $stmt->execute();
            $stmt->close();
        }

        public function deleteDefaultImage($user_id) {
            $query = "DELETE FROM HinhAnh WHERE MaND = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $stmt->close();
        }

        public function updateUserImage($user_id, $imagePath) {
            $query = "UPDATE HinhAnh SET DgDanAnh = ? WHERE MaND = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("si", $imagePath, $user_id);
            $stmt->execute();
            $stmt->close();
        }

        public function getUserImage($id) {
            $query = "SELECT DgDanAnh FROM hinhanh WHERE MaND = $id";
            $result = $this->db->query($query);
            if ($result && $row = $result->fetch_assoc()) {
                return $row['DgDanAnh'];
            }
            return null;
        }
        
        public function deleteImageById($imageId) {
            $query = "DELETE FROM HinhAnh WHERE MaHA = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $imageId);
            $stmt->execute();
            $stmt->close();
        }  
    }
?>