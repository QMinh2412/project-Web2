<?php
    require_once __DIR__ . '/../config/Database.php';
    require_once __DIR__ . '/../models/Image.php';
    class Product{
        protected $db;

        public function __construct() {
            $this->db = Database::getInstance();
        }

        public function getAllProducts($currentpage, $bookperpage) {
            $offset = ($currentpage - 1) * $bookperpage;
            $limit = $bookperpage;
            
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
                    $row['DgDanAnh'] = $image->getImgProduct($row['MaSach'])[0];
                    $products[] = $row;
                }
            }
        
            return $products;
        }

        public function getProductByCategory($category_id, $currentpage = 1, $bookperpage = 10) {
            $offset = ($currentpage - 1) * $bookperpage;

            $query = "SELECT * FROM DauSach WHERE MaLoai = $category_id LIMIT $offset, $bookperpage";
            $result = $this->db->query($query);
            $products = [];

            if ($result) {
            while ($row = $result->fetch_assoc()) {
                $image = new Image();
                $row['DgDanAnh'] = $image->getImgProduct($row['MaSach'])[0];
                $products[] = $row;
            }
            }

            return $products;
        }

        public function getProductByAuthor($author_id, $currentpage = 1, $bookperpage = 10) {
            $offset = ($currentpage - 1) * $bookperpage;

            $query = "SELECT * FROM DauSach WHERE MaTG = $author_id LIMIT $offset, $bookperpage";
            $result = $this->db->query($query);
            $products = [];

            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $image = new Image();
                    $row['DgDanAnh'] = $image->getImgProduct($row['MaSach'])[0];
                    $products[] = $row;
                }
            }

            return $products;
        }

        public function getPagination($currentpage, $bookperpage) {
            $query = "SELECT COUNT(*) AS total FROM DauSach";
            $result = $this->db->query($query);
            $row = $result->fetch_assoc();
            $totalBook = $row['total'];
            $totalPages = ceil($totalBook / $bookperpage);
            
            return [
            'totalPages' => $totalPages,
            'currentPage' => $currentpage
            ];
        }

        public function getPaginationByCategory($category_id, $currentpage = 1, $bookperpage = 10) {
            $query = "SELECT COUNT(*) AS total FROM DauSach WHERE MaLoai = $category_id";
            $result = $this->db->query($query);
            $row = $result->fetch_assoc();
            $totalBook = $row['total'];
            $totalPages = ceil($totalBook / $bookperpage);

            return [
            'totalPages' => $totalPages,
            'currentPage' => $currentpage
            ];
        }

        public function getPaginationByAuthor($author_id, $currentpage = 1, $bookperpage = 10) {
            $query = "SELECT COUNT(*) AS total FROM DauSach WHERE MaTG = $author_id";
            $result = $this->db->query($query);
            $row = $result->fetch_assoc();
            $totalBook = $row['total'];
            $totalPages = ceil($totalBook / $bookperpage);

            return [
            'totalPages' => $totalPages,
            'currentPage' => $currentpage
            ];
        }

        public function filterPriceRange($price_ranges = [], $currentpage = 1, $bookperpage = 10){
            $offset = ($currentpage - 1) * $bookperpage;
            if(empty($price_ranges)){
                $query = "SELECT * FROM DauSach LIMIT $offset, $bookperpage";
            } else {
                $condition = [];
                foreach ($price_ranges as $range){
                    list($min, $max) = explode('_', $range);
                    if($min == "under"){
                        $min = 0;
                    } else {
                        $min = $this->db->real_escape_string($min);
                    }
                    if($max == "over"){
                        $max = 1000000000;
                    } else {
                        $max = $this->db->real_escape_string($max);
                    }
                    $condition[] = "(GiaBan >= $min AND GiaBan <= $max)";
                }
                $where_claude = implode(' OR ', $condition); 
                $query = "SELECT * FROM DauSach WHERE $where_claude LIMIT $offset, $bookperpage";
            }
            $result = $this->db->query($query);
            $products = [];

            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $image = new Image();
                    $row['DgDanAnh'] = $image->getImgProduct($row['MaSach'])[0];
                    $products[] = $row;
                }
            }

            // while($row = $result->fetch_assoc()){
            //     $product[] = $row;
            // }

            return $products;
        }

        public function getPaginationByPriceRange($price_ranges = [], $currentpage = 1, $bookperpage = 10){
            if(empty($price_ranges)){
                $query = "SELECT COUNT(*) AS total FROM DauSach";
            } else {
                $condition = [];
                foreach ($price_ranges as $range){
                    list($min, $max) = explode('_', $range);
                    if($min == "under"){
                        $min = 0;
                    } else {
                        $min = $this->db->real_escape_string($min);
                    }
                    if($max == "over"){
                        $max = 1000000000;
                    } else {
                        $max = $this->db->real_escape_string($max);
                    }
                    $condition[] = "(GiaBan >= $min AND GiaBan <= $max)";
                }
                $where_claude = implode(' OR ', $condition); 
                $query = "SELECT COUNT(*) AS total FROM DauSach WHERE $where_claude";
            }
            $result = $this->db->query($query);
            $row = $result->fetch_assoc();
            $totalBook = $row['total'];
            $totalPages = ceil($totalBook / $bookperpage);

            return [
                'totalPages' => $totalPages,
                'currentPage' => $currentpage
            ];
        }

        public function getProductById($id) {
            $query = "SELECT * FROM DauSach WHERE MaSach = ?";
            $stmt = $this->db->prepare($query);

            if ($stmt) {
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $product = $result->fetch_assoc();
                $stmt->close();
                return $product;
            }
        
            return null;
        }

        public function createProduct($productData) {
            $query = "INSERT INTO DauSach (TenSach, MaLoai, MaTG, MaNXB, SoLgTon, GiaBan, NamXB, SoTrang, KichThuoc, MoTaChiTiet) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("siiiiiiiss", 
                                $productData['TenSach'], 
                                $productData['MaLoai'], 
                                $productData['MaTG'], 
                                $productData['MaNXB'], 
                                $productData['SoLgTon'], 
                                $productData['GiaBan'], 
                                $productData['NamXB'], 
                                $productData['SoTrang'], 
                                $productData['KichThuoc'], 
                                $productData['MoTaChiTiet']
            );
            
            return array($stmt->execute(), $this->db->insert_id);
        }

        public function updateProduct($productId, $productData) {
            $query = "UPDATE DauSach SET TenSach = ?, MaLoai = ?, MaTG = ?, MaNXB = ?, SoLgTon = ?, GiaBan = ?, NamXB = ?, SoTrang = ?, KichThuoc = ?, MoTaChiTiet = ? WHERE MaSach = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("siiiiiiissi", 
                                $productData['TenSach'], 
                                $productData['MaLoai'], 
                                $productData['MaTG'], 
                                $productData['MaNXB'], 
                                $productData['SoLgTon'], 
                                $productData['GiaBan'], 
                                $productData['NamXB'], 
                                $productData['SoTrang'], 
                                $productData['KichThuoc'], 
                                $productData['MoTaChiTiet'],
                                $productId
            );
            
            return $stmt->execute();
        }

        public function updateProductStatus($productId, $productStatus) {
            $query = "UPDATE DauSach SET TinhTrang = ? WHERE MaSach = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ii", $productStatus, $productId);
            
            return $stmt->execute();
        }
    }
?>