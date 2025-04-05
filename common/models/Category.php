<?php
    require_once __DIR__ . '/../config/Database.php';

    class Category {
        protected $db;

        public function __construct() {
            $this->db = Database::getInstance();
        }

        public function getAllCategories() {
            $query = "SELECT * FROM TheLoai";
            $result = $this->db->query($query);
            $categories = [];

            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $categories[] = $row;
                }
            }

            return $categories;
        }

        public function getCategoryByName($categoryName) {
            $query = "SELECT * FROM TheLoai WHERE TenLoai = ?";
            $stmt = $this->db->prepare($query);
        
            if ($stmt) {
                $stmt->bind_param("s", $categoryName);
                $stmt->execute();
                $result = $stmt->get_result();
                $category = $result->fetch_assoc();
                $stmt->close();
                return $category;
            }
        
            return null; // Return null if the statement couldn't be prepared
        }

        public function getCategoryById($categoryId) {
            $query = "SELECT * FROM TheLoai WHERE MaLoai = ?";
            $stmt = $this->db->prepare($query);
        
            if ($stmt) {
                $stmt->bind_param("i", $categoryId);
                $stmt->execute();
                $result = $stmt->get_result();
                $category = $result->fetch_assoc();
                $stmt->close();
                return $category;
            }
        
            return null; // Return null if the statement couldn't be prepared
        }

        public function addCategory($categoryName) {
            $query = "INSERT INTO TheLoai (TenLoai) VALUES (?)";
            $stmt = $this->db->prepare($query);
        
            if ($stmt) {
                $stmt->bind_param("s", $categoryName);
                $result = $stmt->execute();
                $stmt->close();
                return $result; // Returns true if the query was successful, false otherwise
            }
        
            return false; // Return false if the statement couldn't be prepared
        }

        public function updateCategory($categoryId, $categoryName) {
            $query = "UPDATE TheLoai SET TenLoai = ? WHERE MaLoai = ?";
            $stmt = $this->db->prepare($query);
        
            if ($stmt) {
                $stmt->bind_param("si", $categoryName, $categoryId);
                $result = $stmt->execute();
                $stmt->close();
                return $result; // Returns true if the query was successful, false otherwise
            }
        
            return false; // Return false if the statement couldn't be prepared
        }

        public function deleteCategory($categoryId) {
            $query = "DELETE FROM TheLoai WHERE MaLoai = ?";
            $stmt = $this->db->prepare($query);
        
            if ($stmt) {
                $stmt->bind_param("i", $categoryId);
                $result = $stmt->execute();
                $stmt->close();
                return $result; // Returns true if the query was successful, false otherwise
            }
        
            return false; // Return false if the statement couldn't be prepared
        }
    }
?>