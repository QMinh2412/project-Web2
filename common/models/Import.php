<?php
require_once __DIR__ . '/../config/Database.php';

class Import {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    // Lưu phiếu nhập
    public function saveImport($supplierId, $employeeId, $importDate, $products) {
        $this->db->begin_transaction();

        try {
            // Lưu phiếu nhập
            $query = "INSERT INTO PhieuNhap (MaNCC, MaNV, NgayNhap) VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("iis", $supplierId, $employeeId, $importDate);
            $stmt->execute();
            $importId = $stmt->insert_id;

            // Lưu chi tiết phiếu nhập
            foreach ($products as $product) {
                $query = "INSERT INTO ChiTietPhieuNhap (MaPN, TenSach, TacGia, TheLoai, NhaXuatBan, SoLuong, GiaNhap) 
                          VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param(
                    "issssii",
                    $importId,
                    $product['name'],
                    $product['author'],
                    $product['category'],
                    $product['publisher'],
                    $product['quantity'],
                    $product['price']
                );
                $stmt->execute();
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollback();
            return false;
        }
    }

    // Lấy lịch sử nhập hàng
    public function getImportHistory() {
        $query = "SELECT pn.MaPN, ncc.TenNCC, nv.TenNV, pn.NgayNhap, 
                         SUM(ctpn.SoLuong * ctpn.GiaNhap) AS TongTien
                  FROM PhieuNhap pn
                  JOIN NhaCungCap ncc ON pn.MaNCC = ncc.MaNCC
                  JOIN NhanVien nv ON pn.MaNV = nv.MaNV
                  JOIN ChiTietPhieuNhap ctpn ON pn.MaPN = ctpn.MaPN
                  GROUP BY pn.MaPN";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Lấy chi tiết phiếu nhập
    public function getImportDetail($id) {
        $query = "SELECT ctpn.TenSach, ctpn.TacGia, ctpn.TheLoai, ctpn.NhaXuatBan, ctpn.SoLuong, ctpn.GiaNhap
                  FROM ChiTietPhieuNhap ctpn
                  WHERE ctpn.MaPN = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}