<?php
    require_once __DIR__ . '/../../common/core/BaseController.php';
    require_once __DIR__ . '/../../common/models/User.php';
    require_once __DIR__ . '/../../common/models/Account.php';

    class UserController extends BaseController {
        public function index() {
            $userModel = new User();
            $users = $userModel->getAllUsers();

            $usersPerPage = 10;
            $currentPage = isset($_GET['current_page']) ? (int)$_GET['current_page'] : 1;

            $users = $userModel->getUserPagination($currentPage, $usersPerPage);
            $pagination = $userModel->getPagination($currentPage, $usersPerPage);

            $this->render('user/index', [
                'users' => $users,
                'pagination' => $pagination
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

                if ($accountModel->usernameExist($username)) {
                    echo "<script>alert('Tên tài khoản đã tồn tại!'); window.history.back();</script>";
                    exit;
                }
                if ($accountModel->emailExist($email)) {
                    echo "<script>alert('Email đã tồn tại!'); window.history.back();</script>";
                    exit;
                }
                if ($accountModel->phoneExist($phone)) {
                    echo "<script>alert('Số điện thoại đã tồn tại!'); window.history.back();</script>";
                    exit;
                }

                $user_id = $userModel->createUser($fullname, $address, $email, $gender, $phone, $birthdate);
                $accountModel->createAccount($username, $role, $created_at, $status, $password, $user_id);
                $projectRoot = realpath(__DIR__ . '/../../'); 
                $targetDir = $projectRoot . '/common/images/user/' . $username;

                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                if (!empty($_FILES['image']['name'])) {
                    $imageName = $_FILES['image']['name'];
                    $uploadPath = $targetDir . '/' . $imageName;
                    $relativePath = '/project-Web2/common/images/user/' . $username . '/' . $imageName;

                    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                        $imageModel->updateUserImage($user_id, $relativePath);
                    }
                } else {
                    $defaultImgSource = $projectRoot . '/common/images/defaultuser.png';
                    $defaultImgDest   = $targetDir . '/defaultuser.png';
                    $relativePath     = '/project-Web2/common/images/user/' . $username . '/defaultuser.png';

                    if (!file_exists($defaultImgDest)) {
                        copy($defaultImgSource, $defaultImgDest);
                    }
                    $imageModel->updateUserImage($user_id, $relativePath);
                }


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
            $imageModel = new Image();
        
            $user = $userModel->getById($id);
            $account = $accountModel->getById($id);
            $imagePath = $imageModel->getUserImage($id);
        
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
            $imageModel = new Image();

            $user = $userModel->getById($id);
            $account = $accountModel->getById($id);
            $imagePath = $imageModel->getUserImage($id);

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

                if (!empty($_FILES['image']['name'])) {
                    $projectRoot = realpath(__DIR__ . '/../../');
                    $UserName = $accountModel->getNameById($id);
                    $targetDir = $projectRoot . '/common/images/user/' . $UserName . '/';
                
                    if (is_dir($targetDir)) {
                        $files = glob($targetDir . '*');
                        foreach ($files as $file) {
                            if (is_file($file)) {
                                unlink($file);
                            }
                        }
                    } else {
                        mkdir($targetDir, 0777, true);
                    }

                    $newImageName = basename($_FILES['image']['name']);
                    $tmp_name = $_FILES['image']['tmp_name'];
                    $newImagePath = $targetDir . $newImageName;
                
                    if (move_uploaded_file($tmp_name, $newImagePath)) {
                        $relativePath = '/project-Web2/common/images/user/' . $username . '/' . $newImageName;
                        $imageModel->updateUserImage($id, $relativePath);
                    }
                }

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
                $Status = $account['TinhTrang'];

               $newStatus = $Status == 0 ? 1 : 0;
                $accountModel->lockAccount($id, $newStatus);

                $statusText = $newStatus == 1 ? 'đã được mở khóa' : 'đã bị khóa';
                echo "<script>alert('Tài khoản $statusText!'); window.location.href='?page=user&action=index';</script>";
                exit;
            } else {
                echo "Không tìm thấy người dùng.";
            }
        }
    }
?>