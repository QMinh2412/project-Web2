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
            $query = "SELECT DgDanAnh FROM HinhAnh WHERE MaSach = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $image = null;

            if ($result && $row = $result->fetch_assoc()) {
                $image = $row['DgDanAnh'];
            }

            $stmt->close();
            return $image;
        }
    }
?>