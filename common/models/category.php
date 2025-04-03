<?php
require_once __DIR__ . '/../config/Database.php';

class TheLoai {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
      }

    public function getAllTenLoai() {
        $query = "SELECT TenLoai FROM theloai";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
