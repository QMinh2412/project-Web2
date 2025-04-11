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

        public function create() {
            // Gọi view tương ứng với action create
            $this->render('user/create', [
                'title' => 'Create User'
            ]);
        }

        public function view($id) {
            // Gọi view tương ứng với action view
            $userModel = new Account();
            $user = $userModel->getById($id); // Fetch user by ID

            if ($user) {
                $this->render('user/detail', [
                    'title' => 'User Detail',
                    'user' => $user
                ]);
            } else {
                // Handle user not found case
                header('HTTP/1.0 404 Not Found');
                exit('User not found');
            }
        }
    }
?>