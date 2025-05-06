<?php
    require_once __DIR__ . '/../config/init.php';
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

            // Kiểm tra tồn kho
            $book = $productModel->getProductById($id_book);
            if ($book['SoLgTon'] < $qty) {
                return false; // Không đủ hàng
            }
        
            $query = "INSERT INTO CTGH (MaSach, MaGH, TinhTrang, SoLg)
                        VALUES ('$id_book', '$id_cart', 0, '$qty')";
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

        public function getBookInCartByCartId($cartId){
            $cartId = $this->db->real_escape_string($cartId);
            $query = "SELECT * FROM ctgh WHERE MaGH = $cartId";
            $result = $this->db->query($query);
            $books = [];

            if($result){
                while($row = $result->fetch_assoc()){
                    $books[] = $row;
                }
            }

            return $books;
        }

        public function updateCartStatus($bookId, $status, $account_id) {
            $account_id = $this->db->real_escape_string($account_id);
            $bookId = $this->db->real_escape_string($bookId);
            $status = $this->db->real_escape_string($status);
        
            $cartModel = new Cart();
            $cart = $cartModel->getCartById($account_id);
            if (!$cart || !isset($cart['MaGH'])) {
                return false;
            }
        
            $id_cart = $this->db->real_escape_string($cart['MaGH']);
            $query = "UPDATE ctgh SET TinhTrang = '$status' WHERE MaGH = '$id_cart' AND MaSach = '$bookId'";
            $result = $this->db->query($query);
        
            return $result && $this->db->affected_rows > 0;
        }

        public function removeFromCart($bookId, $account_id){
            $bookId = $this->db->real_escape_string($bookId);
            $account_id = $this->db->real_escape_string($account_id);

            $cartModel = new Cart();
            $cart = $cartModel->getCartById($account_id);
            if (!$cart || !isset($cart['MaGH'])) {
                return false;
            }

            $id_cart = $this->db->real_escape_string($cart['MaGH']);

            $query = "DELETE FROM ctgh WHERE MaSach = '$bookId' and MaGH = '$id_cart'";
            $result = $this->db->query($query);
        
            return $result && $this->db->affected_rows > 0;
        }

        public function updateCartQuantity($bookId, $quantity, $account_id){
            $bookId = $this->db->real_escape_string($bookId);
            $quantity = $this->db->real_escape_string($quantity);
            $account_id = $this->db->real_escape_string($account_id);

            $cartModel = new Cart();
            $cart = $cartModel->getCartById($account_id);
            if (!$cart || !isset($cart['MaGH'])) {
                return false;
            }

            $id_cart = $this->db->real_escape_string($cart['MaGH']);

            $query = "UPDATE ctgh SET SoLg = '$quantity' WHERE MaGH = '$id_cart' and MaSach = '$bookId'";
            $result = $this->db->query($query);
        
            return $result && $this->db->affected_rows > 0;
        }

        public function getSelectedBookInCart($cartId){
            $cartId = $this->db->real_escape_string($cartId);
            $query = "SELECT * FROM ctgh WHERE MaGH = '$cartId' AND TinhTrang = 1";
            $result = $this->db->query($query);
            $books = [];

            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $books[] = $row;
                }
            }

            return $books;
        }
        
        public function deleteProductInCart($book_id){
            $book_id = intval($book_id);
            $query = "DELETE FROM ctgh WHERE MaSach = $book_id";
            $result = $this->db->query($query);
        
            return $result && $this->db->affected_rows > 0;
        }
    }
?>