<?php
    require_once __DIR__ . '/../../common/core/BaseController.php';
    require_once __DIR__ . '/../../common/models/User.php';
    require_once __DIR__ . '/../../common/models/Account.php';

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
            $userModel = new User();
            $accountModel = new Account();

            if ($_SERVER['REQUEST_METHOD'] === 'POST'){
                $fullname = $_POST['name'];
                $username = $_POST['username'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $address = $_POST['address'];
                $phone = $_POST['phone'];
                $birthdate = $_POST['birthdate'];
                $role = $_POST['role'];
                $created_at = date('Y-m-d H:i:s');
                $gender = isset($_POST['gender']) ? $_POST['gender'] : 0;
                $status = 1;

                $user_id = $userModel->createUser($fullname, $address, $email, $gender, $phone, $birthdate);
                $accountModel->createAccount($username, $role, $created_at, $status, $password, $user_id);
                header('Location: ?page=user&action=index');
                exit;
            }

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