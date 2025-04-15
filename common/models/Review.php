<?php
    require_once __DIR__ . '/../config/Database.php';
    require_once __DIR__ . '/../models/Image.php';
    require_once __DIR__ . '/../models/Account.php';
    class Review{
        protected $db;

        public function __construct() {
            $this->db = Database::getInstance();
        }

        public function getAllReviewById($id_book){
            $query = "SELECT * FROM DanhGia WHERE MaSach = $id_book";
            $result = $this->db->query($query);
            $reviews = [];

            if($result){
                while($row = $result->fetch_assoc()){
                    $image = new Image();
                    $account = new Account();
                    $row['AnhKH'] = $image->getImageAccount($row['MaKH']);
                    $row['AnhDN'] = $image->getImageAccount($row['MaAdmin']);
                    $row['TenKH'] = $account->getNameById($row['MaKH']);
                    $row['TenAdmin'] = $account->getNameById($row['MaAdmin']);
                    $reviews[] = $row;
                }
            }

            return $reviews;
        }

        public function saveComment($content, $id_book, $id_account, $current_time){
            $content = $this->db->real_escape_string($content);
            $id_book = $this->db->real_escape_string($id_book);
            $id_account = $this->db->real_escape_string($id_account);
            $current_time = $this->db->real_escape_string($current_time);
            $q = "INSERT INTO DanhGia(PhanHoi, NoiDung, NgayViet, MaKH, MaAdmin, MaSach)
                    VALUES (NULL, '$content', '$current_time', '$id_account', NULL, '$id_book')";
            $r = $this->db->query($q);

            if(!$r){
                return false;
            }
            
            $new_id = $this->db->insert_id;

            $query = "SELECT * FROM DanhGia WHERE MaDG = $new_id";
            $result = $this->db->query($query);
            $new_reivew = [];

            if($result){
                while($row = $result->fetch_assoc()){
                    $image = new Image();
                    $account = new Account();
                    $row['AnhKH'] = $image->getImageAccount($row['MaKH']);
                    $row['AnhDN'] = $image->getImageAccount($row['MaAdmin']);
                    $row['TenKH'] = $account->getNameById($row['MaKH']);
                    $row['TenAdmin'] = $account->getNameById($row['MaAdmin']);
                    $new_reivew = $row;
                }
            }

            return $new_reivew;
        }

        public function saveReply($content, $comment_id, $current_account){
            $content = $this->db->real_escape_string($content);
            $comment_id = $this->db->real_escape_string($comment_id);
            $current_account = $this->db->real_escape_string($current_account);

            $q = "UPDATE DanhGia 
                SET PhanHoi = '$content', MaAdmin = '$current_account'
                WHERE MaDG = '$comment_id'";
            $r = $this->db->query($q);
            
            if(!$r){
                return false;
            }

            $query = "SELECT * FROM DanhGia WHERE MaDG = $comment_id";
            $result = $this->db->query($query);
            $new_reply = [];

            if($result){
                while($row = $result->fetch_assoc()){
                    $image = new Image();
                    $account = new Account();
                    $row['AnhKH'] = $image->getImageAccount($row['MaKH']);
                    $row['AnhDN'] = $image->getImageAccount($row['MaAdmin']);
                    $row['TenKH'] = $account->getNameById($row['MaKH']);
                    $row['TenAdmin'] = $account->getNameById($row['MaAdmin']);
                    $new_reply = $row;
                }
            }

            return $new_reply;
        }

        public function deleteUserReviews($maKH) {
            $query = "DELETE FROM DanhGia WHERE MaKH = ?";
            $stmt = $this->db->prepare($query);
        
            if (!$stmt) {
                die("Lỗi truy vấn: " . $this->db->error);
            }
        
            $stmt->bind_param("i", $maKH);
            $result = $stmt->execute();
            $stmt->close();
        
            return $result;
        }
    }
?>