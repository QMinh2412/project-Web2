<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Image.php';
require_once __DIR__ . '/../models/Author.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Provider.php';
require_once __DIR__ . '/../models/Publisher.php';

class Product {
    protected $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAllProductsWithoutPagination() {
        $query = "SELECT * FROM DauSach";

        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            die("Prepare failed: " . $this->db->error);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $products = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
    
        return $products;
    }

    public function getAllProducts($currentpage, $bookperpage = 10) {
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
                $imgs = $image->getImgProduct($row['MaSach']);
                $row['DgDanAnh'] = !empty($imgs) ? $imgs[0] : null;
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

    public function getPagination($currentpage, $bookperpage = 10) {
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

    public function filterPriceRange($price_ranges = [], $currentpage = 1, $bookperpage = 10) {
        $offset = ($currentpage - 1) * $bookperpage;
        if (empty($price_ranges)) {
            $query = "SELECT * FROM DauSach LIMIT $offset, $bookperpage";
        } else {
            $condition = [];
            foreach ($price_ranges as $range) {
                list($min, $max) = explode('_', $range);
                if ($min == "under") {
                    $min = 0;
                } else {
                    $min = $this->db->real_escape_string($min);
                }
                if ($max == "over") {
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

        return $products;
    }

    public function getPaginationByPriceRange($price_ranges = [], $currentpage = 1, $bookperpage = 10) {
        if (empty($price_ranges)) {
            $query = "SELECT COUNT(*) AS total FROM DauSach";
        } else {
            $condition = [];
            foreach ($price_ranges as $range) {
                list($min, $max) = explode('_', $range);
                if ($min == "under") {
                    $min = 0;
                } else {
                    $min = $this->db->real_escape_string($min);
                }
                if ($max == "over") {
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
        if (!$stmt) {
            die("Prepare failed: " . $this->db->error);
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $book_data = $result->fetch_assoc();
        if ($book_data) {
            $image = new Image();
            $author = new Author();
            $category = new Category();
            $publisher = new Publisher();
            
            // Lấy danh sách hình ảnh
            $images = $image->getImgProduct($book_data['MaSach']);
            $book_data['DgDanAnh'] = !empty($images) ? $images : []; // Gán mảng rỗng nếu không có hình ảnh

            // Lấy thông tin tác giả, thể loại, nhà xuất bản (kiểm tra null)
            $authorData = $author->getAuthorById($book_data['MaTG'] ?? 0);
            $book_data['TenTG'] = $authorData['TenTG'] ?? 'Không xác định';

            $categoryData = $category->getCategoryById($book_data['MaLoai'] ?? 0);
            $book_data['TenLoai'] = $categoryData['TenLoai'] ?? 'Không xác định';

            $publisherData = $publisher->getPublisherById($book_data['MaNXB'] ?? 0);
            $book_data['TenNXB'] = $publisherData['TenNXB'] ?? 'Không xác định';
        }

        $stmt->close();
        return $book_data;
    }

    public function createProduct($productData) {
        $query = "INSERT INTO DauSach (TenSach, MaLoai, MaTG, MaNXB, MaNCC, NamXB, SoTrang, KichThuoc, MoTaChiTiet, SoLgTon, GiaBan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("siiiiiissii", 
                            $productData['TenSach'], 
                            $productData['MaLoai'], 
                            $productData['MaTG'], 
                            $productData['MaNXB'],
                            $productData['MaNCC'],
                            $productData['NamXB'], 
                            $productData['SoTrang'], 
                            $productData['KichThuoc'], 
                            $productData['MoTaChiTiet'],
                            $productData['SoLgTon'],
                            $productData['GiaBan']
        );
        
        return array($stmt->execute(), $this->db->insert_id);
    }

    public function updateProduct($productId, $productData) {
        $query = "UPDATE DauSach SET TenSach = ?, MaLoai = ?, MaTG = ?, MaNXB = ?, MaNCC = ?, GiaBan = ?, NamXB = ?, SoTrang = ?, KichThuoc = ?, MoTaChiTiet = ? WHERE MaSach = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("siiiiiiissi", 
                            $productData['TenSach'], 
                            $productData['MaLoai'], 
                            $productData['MaTG'], 
                            $productData['MaNXB'],
                            $productData['MaNCC'], 
                            $productData['GiaBan'], 
                            $productData['NamXB'], 
                            $productData['SoTrang'], 
                            $productData['KichThuoc'], 
                            $productData['MoTaChiTiet'],
                            $productId
        );
        
        return $stmt->execute();
    }

    public function search($search) {
        $query = "SELECT * FROM DauSach WHERE TenSach LIKE '%$search%'";
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

    public function getPaginationBySearch($search, $currentpage = 1, $bookperpage = 5) {
        $query = "SELECT COUNT(*) AS total FROM DauSach WHERE TenSach LIKE '%$search%'";
        $result = $this->db->query($query);
        $row = $result->fetch_assoc();
        $totalBook = $row['total'];
        $totalPages = ceil($totalBook / $bookperpage);

        return [
            'totalPages' => $totalPages,
            'currentPage' => $currentpage
        ];
    }

    public function getBooksTypeSame($id_book) {
        $query = "SELECT * FROM DauSach WHERE MaSach = $id_book";
        $result = $this->db->query($query);
        
        if ($result) {
            $book_data = $result->fetch_assoc();
            $id_category = $book_data['MaLoai'];
            $q = "SELECT * FROM DauSach WHERE MaLoai = $id_category AND MaSach != $id_book";
            $r = $this->db->query($q);
            $orther_books = [];
            if ($r) {
                while ($row = $r->fetch_assoc()) {
                    $image = new Image();
                    $row['DgDanAnh'] = $image->getImgProduct($row['MaSach']);
                    $orther_books[] = $row;
                }   
            }
        }

        return $orther_books;
    }

    public function updateProductStatus($productId, $productStatus) {
        $query = "UPDATE DauSach SET TinhTrang = ? WHERE MaSach = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $productStatus, $productId);
        
        return $stmt->execute();
    }

    public function deleteProduct($productId) {
        $query = "DELETE FROM DauSach WHERE MaSach = ?";
        $stmt = $this->db->prepare($query);

        if ($stmt) {
            $stmt->bind_param("i", $productId);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        }

        return false;
    }

    public function updateStock($id_book, $quantity) {
        $query = "UPDATE DauSach SET SoLgTon = SoLgTon - ? WHERE MaSach = ?";
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            die("Prepare failed: " . $this->db->error);
        }
        $stmt->bind_param("ii", $quantity, $id_book);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
}
?>