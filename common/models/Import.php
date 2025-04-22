<?php
    require_once __DIR__ . '/../config/database.php';

    class Import  {
        protected $db;

        public function __construct() {
            $this->db = Database::getInstance();
        }

        public function getFilteredImport($currentPage, $importsPerPage, $importId = '', $status = '', $fromDate = '', $toDate = '') {
            $offset = ($currentPage - 1) * $importsPerPage;
            $conditions = "WHERE 1=1";

            if (!empty($importId)) {
                $conditions .= " AND MaPhNhap = " . intval($importId);
            }

            if (isset($status) && is_numeric($status)) {
                $conditions .= " AND TinhTrang = " . intval($status);
            }

            if (!empty($fromDate)) {
                $conditions .= " AND NgNhap >= '" . $this->db->real_escape_string($fromDate) . "'";
            }
        
            if (!empty($toDate)) {
                $conditions .= " AND NgNhap <= '" . $this->db->real_escape_string($toDate) . "'";
            }

            // Câu truy vấn chính
            $query = "SELECT * FROM PhNhap $conditions ORDER BY NgNhap DESC LIMIT $importsPerPage OFFSET $offset";
            $result = $this->db->query($query);
        
            $imports = [];
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $imports[] = $row;
                }
            }
            
            return $imports;
        }

        public function getImportPaginationFiltered($currentPage, $importsPerPage, $importId = '', $status = '', $fromDate = '', $toDate = '') {
            $conditions = "WHERE 1=1";

            if (!empty($importId)) {
                $conditions .= " AND MaPhNhap = " . intval($importId);
            }

            if (isset($status) && is_numeric($status)) {
                $conditions .= " AND TinhTrang = " . intval($status);
            }

            if (!empty($fromDate)) {
                $conditions .= " AND NgNhap >= '" . $this->db->real_escape_string($fromDate) . "'";
            }
        
            if (!empty($toDate)) {
                $conditions .= " AND NgNhap <= '" . $this->db->real_escape_string($toDate) . "'";
            }

            $query = "SELECT COUNT(*) as total FROM PhNhap $conditions";
            $result = $this->db->query($query);
            $row = $result->fetch_assoc();
            $totalImport = $row['total'];
            $totalPages = ceil((int)$totalImport / (int)$importsPerPage);
        
            return [
                'totalOrders' => $totalImport,
                'totalPages' => $totalPages,
                'currentPage' => $currentPage
            ];
        }

        public function getImportById($id) {
            $query = "SELECT * FROM PhNhap WHERE MaPhNhap = '$id'";
            $result = $this->db->query($query);
            return $result->fetch_assoc();
        }

        public function changeImportStatusById($importId, $newStatus) {
            $query = "UPDATE PhNhap SET TinhTrang = ? WHERE MaPhNhap = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ii", $newStatus, $importId);
            
            return $stmt->execute();
        }
    }
?>