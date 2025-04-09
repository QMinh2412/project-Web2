<?php
    require_once __DIR__ . '/../config/Database.php';

    class Publisher {
        protected $db;

        public function __construct() {
            $this->db = Database::getInstance();
        }

        public function getAllPublishers() {
            $query = "SELECT * FROM NXB";
            $result = $this->db->query($query);
            $publishers = [];

            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $publishers[] = $row;
                }
            }

            return $publishers;
        }

        
    }
?>