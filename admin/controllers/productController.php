<?php
    require_once __DIR__ . '/../../common/core/BaseController.php';
    require_once __DIR__ . '/../../common/models/Product.php';
    require_once __DIR__ . '/../../common/models/Image.php';
    require_once __DIR__ . '/../../common/models/Author.php';
    require_once __DIR__ . '/../../common/models/Category.php';
    require_once __DIR__ . '/../../common/models/Publisher.php';
    require_once __DIR__ . '/../../common/models/Provider.php';

    class ProductController extends BaseController {
        public function index() {
            // Gọi view tương ứng với action index
            $productModel = new Product();
            $products = $productModel->getAllProducts(); // Giả sử bạn có phương thức này trong model

            $this->render('product/index', [
                'products' => $products
            ]);
        }

        public function create() {
            $productModel = new Product();
            $imageModel = new Image();

            $this->render('product/create', []);

            
        }
        public function authorSuggestion() {
            $authorModel = new Author();
            $authorName = $_GET['name'] ?? null;
        
            if ($authorName) {
                $authors = $authorModel->getAuthorsByName($authorName); // Fetch matching authors
                echo json_encode($authors); // Return as JSON
            } else {
                echo json_encode([]); // Return an empty array if no name is provided
            }
            exit;
        }
    }
?>