<?php
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
    }
?>