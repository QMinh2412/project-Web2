<?php
    require_once __DIR__ . '/../../common/core/BaseController.php';
    require_once __DIR__ . '/../../common/models/User.php';

    class UserController extends BaseController {
        public function index() {
            // Gọi view tương ứng với action index
            $userModel = new User();
            $users = $userModel->getAllUsers(); // Fetch all users with account details

            $this->render('user/index', [
                'title' => 'User Management',
                'users' => $users
            ]);
        }
    }
?>