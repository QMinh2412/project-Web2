<?php
    require_once __DIR__ . '/../config/Database.php';
    require_once __DIR__ . '/../models/Cart.php';
    require_once __DIR__ . '/../models/Product.php';
    class CartDetail{
        protected $db;

        public function __construct() {
            $this->db = Database::getInstance();
        }

        public function addToCart($account_id, $id_book, $qty) {
            $account_id = $this->db->real_escape_string($account_id);
            $id_book = $this->db->real_escape_string($id_book);
            $qty = $this->db->real_escape_string($qty);
        
            $cartModel = new Cart();
            $productModel = new Product();
            $cart = $cartModel->getCartById($account_id);
            $id_cart = $cart['MaGH'];
        
            $book = $productModel->getProductById($id_book);
            $book_price = $book['GiaBan'];
        
            $query = "INSERT INTO CTGH (MaSach, MaGH, TinhTrang, SoLg, GiaBan)
                        VALUES ('$id_book', '$id_cart', 0, '$qty', '$book_price')";
            $result = $this->db->query($query);
        
            return $result ? true : false;
        }

        public function deleteCartDetail($account_id) {
            $account_id = $this->db->real_escape_string($account_id);
            $cartModel = new Cart();
            $cart = $cartModel->getCartById($account_id);
            $id_cart = $cart['MaGH'];
        
            $query = "DELETE FROM CTGH WHERE MaGH = '$id_cart'";
            return $this->db->query($query);
        }
    }
?>