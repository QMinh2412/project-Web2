<?php
    require_once __DIR__ . '/../../common/core/BaseController.php';

    class CategoryController extends BaseController {
        public function index() {
            // Gọi view tương ứng với action index
            $categoryModel = new Category();
            $categories = $categoryModel->getAllCategories(); // Giả sử bạn có phương thức này trong model

            $this->render('category/index', [
                'title' => 'User Management',
                'categories' => $categories
            ]);
        }
    }
?>