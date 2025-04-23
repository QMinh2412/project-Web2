<?php
    require_once __DIR__ . '/../../common/core/BaseController.php';
    require_once __DIR__ . '/../../common/models/User.php';
    require_once __DIR__ . '/../../common/models/Account.php';
    require_once __DIR__ . '/../../common/models/Cart.php';
    require_once __DIR__ . '/../../common/models/CartDetail.php';
    require_once __DIR__ . '/../../common/models/Order.php';
    require_once __DIR__ . '/../../common/models/OrderDetail.php';
    require_once __DIR__ . '/../../common/models/Review.php';

    class UserController extends BaseController {
        public function index() {
            $userModel = new User();
            $users = $userModel->getAllUsers();

            $usersPerPage = 10;
            $currentPage = isset($_GET['current_page']) ? (int)$_GET['current_page'] : 1;

            $users = $userModel->getUserPagination($currentPage, $usersPerPage);
            $pagination = $userModel->getPagination($currentPage, $usersPerPage);
            $pagination['limit'] = $usersPerPage;

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
                $role = filter_var($_POST['role'], FILTER_SANITIZE_NUMBER_INT);
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

                if ($accountModel->usernameExist($username, $id)) {
                    echo "<script>alert('Tên tài khoản đã tồn tại!'); window.history.back();</script>";
                    exit;
                }
                if ($accountModel->emailExist($email, $id)) {
                    echo "<script>alert('Email đã tồn tại!'); window.history.back();</script>";
                    exit;
                }
                if ($accountModel->phoneExist($phone, $id)) {
                    echo "<script>alert('Số điện thoại đã tồn tại!'); window.history.back();</script>";
                    exit;
                }

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

        public function delete($id) {
            session_start();

            $userModel = new User();
            $accountModel = new Account();
            $imageModel = new Image();
            $cartModel = new Cart();
            $cartdetailModel = new CartDetail();
            $reviewModel = new Review();
            $orderModel = new Order();
            $orderdetailModel = new OrderDetail();

            $currentUser = $_SESSION['user_id'];
            $currentAccount = $accountModel->getById($currentUser);
            $user = $userModel->getById($id);
            $account = $accountModel->getById($id);
            $cart = $cartModel->getCartById($id);
            $order = $orderModel->getOrderById($id);

            if ($currentUser == $id) {
                echo "<script>alert('Không thể xóa tài khoản của chính bạn!'); window.location.href='?page=user&action=index';</script>";
                exit;
            }

            if ($currentAccount['LoaiTK'] <= 2 || $currentAccount['LoaiTK'] <= $user['LoaiTK']) {
                // Proper console log
                echo "<script>";
                echo "console.log('Current Role: " . $currentAccount['LoaiTK'] . "');";
                echo "console.log('Target Role: " . $account['LoaiTK'] . "');";
                echo "window.history.back();";
                echo "</script>";
                echo "<script>alert('Bạn không có quyền xóa tài khoản có quyền cao hơn hoặc bằng!');</script>";
    
                

                exit;
            }

            if ($user && $account) {
                if ($order) {
                    $orderdetailModel->deleteDetailsByUserId($id);
                    $orderModel->deleteUserOrder($id);
                }
                $reviewModel->deleteUserReviews($id);
                if ($cart) {
                    $cartdetailModel->deleteCartDetail($id);
                    $cartModel->deleteCart($id);
                }

                $imagePath = $imageModel->getUserImage($id);
                $fullPath = $_SERVER['DOCUMENT_ROOT'] . $imagePath;
                if(file_exists($fullPath)) {    
                    unlink($fullPath);
                }

                $imageModel->deleteImageById($id);
                $accountModel->deleteAccount($id);
                $userModel->deleteUser($id);

                echo "<script>alert('Xóa tài khoản thành công!'); window.location.href='?page=user&action=index';</script>";
                exit;
            } else {
                echo "Không tìm thấy người dùng.";
            }

        }
    }
?>