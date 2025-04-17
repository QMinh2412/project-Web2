<?php
    require_once __DIR__ . '/../../common/core/BaseController.php';
    require_once __DIR__ . '/../../common/models/Product.php';
    require_once __DIR__ . '/../../common/models/Review.php';

    class ReviewController extends BaseController {
        public function index() {
            $reviewModel = new Review();
            $productModel = new Product();

            $product = $productModel->getAllProductsWithoutPagination();

            $review = $reviewModel->getAllReview();


            $this->render('review/index', [
                'title' => 'User Management',
                'message' => 'Welcome to the User Management page!',
                'reviews' => $review,
                'products' => $product,
            ]);
        }
    }
?>