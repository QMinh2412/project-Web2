<?php
    require_once __DIR__ . '/../../common/core/BaseController.php';
    require_once __DIR__ . '/../../common/models/Product.php';
    require_once __DIR__ . '/../../common/models/Image.php';

    class ProductController extends BaseController {
        public function index() {
            // Gọi view tương ứng với action index
            $productModel = new Product();
            $products = $productModel->getAllProducts(); // Giả sử bạn có phương thức này trong model

            $this->render('product/index', [
                'products' => $products
            ]);
        }

    }
?>