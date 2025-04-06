<?php
    require_once __DIR__ . '/../config/Database.php';

    class Provider {
        protected $db;

        public function __construct() {
            $this->db = Database::getInstance();
        }

        public function getAllProviders() {
            $query = "SELECT * FROM NCC";
            $result = $this->db->query($query);
            $providers = [];

            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $providers[] = $row;
                }
            }

            return $providers;
        }

        public function getProviderByName($providerName) {
            $query = "SELECT * FROM NCC WHERE TenNCC = ?";
            $stmt = $this->db->prepare($query);
        
            if ($stmt) {
                $stmt->bind_param("s", $providerName);
                $stmt->execute();
                $result = $stmt->get_result();
                $provider = $result->fetch_assoc();
                $stmt->close();
                return $provider;
            }
        
            return null; // Return null if the statement couldn't be prepared
        }
    }
        
?>