<?php
    require_once __DIR__ . '/../config/Database.php';
    require_once __DIR__ . '/../models/Product.php';

    class ImportDetail {
        protected $db;

        public function __construct() {
            $this->db = Database::getInstance();
        }

        public function getImportDetailById($importId) {
            $query = "SELECT CTPN.SoLgNhap, CTPN.MaSach, CTPN.GiaNhap, DS.TenSach, TL.TenLoai
                        FROM CTPN
                        JOIN DauSach DS ON CTPN.MaSach = DS.MaSach
                        JOIN TheLoai TL ON DS.MaLoai = TL.MaLoai
                        WHERE CTPN.MaPhNhap = '$importId'";

            $result = $this->db->query($query);
            
            $details = [];
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $details[] = $row;
                }
            }

            return $details;
        }
    }
?>