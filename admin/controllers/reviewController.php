<?php
    require_once __DIR__ . '/../../common/core/BaseController.php';
    require_once __DIR__ . '/../../common/models/Product.php';
    require_once __DIR__ . '/../../common/models/Review.php';

    class ReviewController extends BaseController {
        public function index() {
            $reviewModel = new Review();
            $productModel = new Product();

            $product = $productModel->getAllProductsWithoutPagination();
            $currentPage = isset($_GET['current_page']) ? (int)$_GET['current_page'] : 1;

            $review = $reviewModel->getAllReview();


            $this->render('review/index', [
                'title' => 'User Management',
                'message' => 'Welcome to the User Management page!',
                'reviews' => $review,
                'products' => $product,
                'pagination' => [
                    'currentPage' => $currentPage,
                    'totalPages' => ceil(count($review) / 10), // Assuming 10 reviews per page
                ],
            ]);
        }
    }
?>