<?php
    require_once __DIR__ . '/../../common/core/BaseController.php';

    class CategoryController extends BaseController {
        public function index() {
            // Gọi view tương ứng với action index
            $this->render('category/index', [
                'title' => 'User Management',
                'message' => 'Welcome to the User Management page!'
            ]);
        }

        public function create() {}
    }
?>