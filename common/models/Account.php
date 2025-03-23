<?php
require_once __DIR__ . '/../config/Database.php';

class Account {
    protected $db;

    public function __construct() {
        // Lấy kết nối database từ Database.php
        $this->db = database::getInstance();
    }

    public function getById($id) {
        $result = $this->db->query("SELECT * FROM taikhoan WHERE MaTK = $id");
        return $result->fetch_assoc();
    }

    public function getImage($id){
        $query = "select DgDanAnh
                    from hinhanh
                    where hinhanh.MaND = taikhoan.MaND and MaTK = $id";
        $result = $this->db->query($query);
        return $result;
    }
}
?>
