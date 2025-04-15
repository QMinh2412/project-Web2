<?php
    require_once __DIR__ . '/../config/Database.php';

    class Author {
        protected $db;

        public function __construct() {
            $this->db = Database::getInstance();
        }

        public function getAllAuthors() {
            $query = "SELECT * FROM TacGia";
            $result = $this->db->query($query);
            $authors = [];

            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $authors[] = $row;
                }
            }
            return $authors;
        }

        public function getAuthorsByName($authorName) {
            $query = "SELECT * FROM TacGia WHERE TenTacGia LIKE ?";
            $stmt = $this->db->prepare($query);
        
            if ($stmt) {
                $searchTerm = "%$authorName%";
                $stmt->bind_param("s", $searchTerm);
                $stmt->execute();
                $result = $stmt->get_result();
                $authors = [];

                while ($row = $result->fetch_assoc()) {
                    $authors[] = $row;
                }
                $stmt->close();
                return $authors;
            }
        
            return []; // Return an empty array if the statement couldn't be prepared
        }

        public function createAuthor($authorData) {
            $query = "INSERT INTO TacGia (TenTG, NgSinhTG, GioiTinhTG) VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($query);
        
            if ($stmt) {
                $stmt->bind_param("sdi", $authorData['TenTG'], $authorData['NgSinhTG'], $authorData['GioiTinhTG']);
                if ($stmt->execute()) {
                    return $this->db->insert_id; 
                }
            }
        
            return false; 
        }

        public function getAuthorById($id){
            $query = "SELECT * FROM TacGia WHERE MaTG = ?";
            $stmt = $this->db->prepare($query);
        
            if ($stmt) {
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $author = $result->fetch_assoc();
                $stmt->close();
                return $author;
            }
        
            return null;
        }
    }
?>