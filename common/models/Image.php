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

        public function deleteImageById($imageId) {
            $query = "DELETE FROM HinhAnh WHERE MaHA = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $imageId);
            $stmt->execute();
            $stmt->close();
        }  
    }
?>