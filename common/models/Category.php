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
    }
?>