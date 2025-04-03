<?php
    require_once __DIR__ . '/../../common/core/BaseController.php';

    class UserController extends BaseController {
        public function index() {
            // Gọi view tương ứng với action index
            $this->render('user/index', [
                'title' => 'User Management',
                'message' => 'Welcome to the User Management page!'
            ]);
        }
    }
?>