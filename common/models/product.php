<?php
    require_once __DIR__ . '/../config/Database.php';
    require_once __DIR__ . '/../models/Image.php';
    class Product{
        protected $db;
        protected $bookperpage = 15;

        public function __construct() {
            $this->db = Database::getInstance();
        }

        public function getAllProducts($currentpage = 1) {
            $offset = ($currentpage - 1) * $this->bookperpage;
            $limit = $this->bookperpage;
            
            // Gán giá trị trực tiếp vào truy vấn (vì LIMIT không dùng bind_param)
            $query = "SELECT * FROM DauSach LIMIT $offset, $limit";
            
            $stmt = $this->db->prepare($query);
            if (!$stmt) {
                die("Prepare failed: " . $this->db->error);
            }
        
            $stmt->execute();
            $result = $stmt->get_result();
            $products = [];
        
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $image = new Image();
                    $row['DgDanAnh'] = $image->getImgProduct($row['MaSach']);
                    $products[] = $row;
                }
            }
        
            return $products;
        }

        public function getPagination($currentpage = 1) {
            $query = "SELECT COUNT(*) AS total FROM DauSach";
            $result = $this->db->query($query);
            $row = $result->fetch_assoc();
            $totalBook = $row['total'];
            $totalPages = ceil($totalBook / $this->bookperpage);
            
            return [
            'totalPages' => $totalPages,
            'currentPage' => $currentpage
            ];
        }

        public function getProductById($id) {
            $query = "SELECT * FROM SanPham WHERE idSanPham = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            return $result->fetch_assoc();
        }
    }
?>