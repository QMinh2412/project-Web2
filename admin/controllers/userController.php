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
            $imageModel = new Image();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $fullname = filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS);
                $username = filter_var($_POST['username'],  FILTER_SANITIZE_SPECIAL_CHARS);
                $email = filter_var(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
                $password = $_POST['password'];
                $address = filter_var($_POST['address'], FILTER_SANITIZE_SPECIAL_CHARS);
                $phone = $_POST['phone'];
                $birthdate = $_POST['birthdate'];
                $role = $_POST['role'];
                $created_at = date('Y-m-d H:i:s');
                $gender = isset($_POST['gender']) ? $_POST['gender'] : 0;
                $status = 1;
                $image = $_FILES['image']['name'];

                $user_id = $userModel->createUser($fullname, $address, $email, $gender, $phone, $birthdate);
                $accountModel->createAccount($username, $role, $created_at, $status, $password, $user_id);
                echo "<script>alert('Tạo tài khoản thành công!'); window.location.href='?page=user&action=index';</script>";
                exit;
            }

            $this->render('user/create', [
                'title' => 'Create User'
            ]);
        }

        public function view($id) {
            $userModel = new User();
            $accountModel = new Account();
        
            $user = $userModel->getById($id);
            $account = $accountModel->getById($id);
            $imagePath = $accountModel->getImage($id);
        
            if ($user && $account) {
                $this->render('user/view', [
                    'title' => 'Chi tiết tài khoản',
                    'user' => $user,
                    'account' => $account,
                    'imagePath' => $imagePath,
                ]);
            } 
            else {
                echo "Không tìm thấy người dùng.";
            }
        }

        public function edit($id) {
            $userModel = new User();
            $accountModel = new Account();

            $user = $userModel->getById($id);
            $account = $accountModel->getById($id);
            $imagePath = $accountModel->getImage($id);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $fullname = filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS);
                $username = filter_var($_POST['username'],  FILTER_SANITIZE_SPECIAL_CHARS);
                $email = filter_var(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
                $password = trim($_POST['password']);
                $address = filter_var($_POST['address'], FILTER_SANITIZE_SPECIAL_CHARS);
                $phone = $_POST['phone'];
                $birthdate = $_POST['birthdate'];
                $role = $_POST['role'];
                $gender = isset($_POST['gender']) ? $_POST['gender'] : 0;

                $userModel->updateUser($id, $fullname, $address, $email, $gender, $phone, $birthdate);
                $accountModel->updateAccount($username, $role, $password, $id);
                echo "<script>alert('Chỉnh sửa tài khoản thành công!'); window.location.href='?page=user&action=index';</script>";
                exit;
            }

            if ($user && $account) {
                $this->render('user/edit', [
                    'title' => 'Chỉnh sửa tài khoản',
                    'user' => $user,
                    'account' => $account,
                    'imagePath' => $imagePath,
                ]);
            }
            else {
                echo "Không tìm thấy người dùng.";
            }
        }
        
        public function lock($id) {
            $userModel = new User();
            $accountModel = new Account();

            $user = $userModel->getById($id);
            $account = $accountModel->getById($id);

            if ($user && $account) {
                $accountModel->lockAccount($id);
                echo "<script>alert('Tài khoản đã bị khóa!'); window.location.href='?page=user&action=index';</script>";
                exit;
            } else {
                echo "Không tìm thấy người dùng.";
            }
        }
    }
?>