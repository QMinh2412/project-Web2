<?php
    require_once __DIR__ . '/../../common/models/Account.php';
    require_once __DIR__ . '/../../common/models/User.php';

    class AccountController{
        private $accountModel;
        private $userModel; 
        public function __construct() {
            $this->accountModel = new Account();
            $this->userModel = new User();
        }
        public function registerAjax(){
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $fname = $_POST['fullname'];
                $uname = $_POST['username'];
                $email = $_POST['email'];
                $pass = $_POST['password'];
                $phone = $_POST['phone'] ?? '';
                $dob = $_POST['dob'] ?? '';
                $gender = $_POST['gender'];
                $address = $_POST['address'] ?? '';
        
                $accountModel = new Account();
                
                // Kiểm tra email đã được đăng ký chưa
                if ($accountModel->emailExist($email)) {
                    echo json_encode([
                        'status' => 'error',
                        'field' => 'email',
                        'message' => 'Email đã được đăng ký'
                    ]);
                    return;
                }
        
                // Mã hóa mật khẩu
                // $hashedPassword = password_hash($pass, PASSWORD_BCRYPT);
        
                // Lưu thông tin người dùng mới
                $userModel = new User();
                $idNewUser = $userModel->createUser($fname, $address, $email, $gender, $phone, $dob);
                $currentCreate = date("Y-m-d");
                $accountModel->createAccount($uname, 0, $currentCreate, 1, $pass, $idNewUser);
        
                if ($idNewUser) {        
                    session_start();
                    $_SESSION['account_id'] = $idNewUser;
                    $_SESSION['account_type'] = 0;

                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Đăng ký thành công'
                    ]);

                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Đăng ký thất bại, vui lòng thử lại'
                    ]);
                }
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Yêu cầu không hợp lệ'
                ]);
            }
        }

        public function logout(){
            session_start();
            session_destroy();
            header('Location: /project-Web2/user/index.php');
            exit();
        }
        
        // xử lý Đăng nhập
        public function loginAjax() {
        
            if ($_SERVER["REQUEST_METHOD"] !== "POST") {
                echo json_encode(["status" => "error", "message" => "Yêu cầu không hợp lệ"]);
                exit;
            }
        
            $email = $_POST['email'];
            $password = $_POST['password'];

            $accountModel = new Account();

            if (!$accountModel->emailExist($email)) {
                echo json_encode([
                    'status' => 'error',
                    'field' => 'email',
                    'message' => 'Email chưa được đăng ký'
                ]);
                return;
            }

            if (!$accountModel->isAccountLocked($email)) {
                echo json_encode([
                    'status' => 'error',
                    'field' => 'email',
                    'message' => 'Tài khoản đang bị khóa'
                ]);
                return;
            }

            // $hashedPassword = hash('sha256', $password);
            if (!$accountModel->isPasswordCorrect($email, $password)) {
                echo json_encode([
                    'status' => 'error',
                    'field' => 'password',
                    'message' => 'Mật khẩu không chính xác'
                ]);
                return;
            }

            session_start();
            $accountId = $accountModel->getAccountIdByEmail($email);
            $_SESSION['account_id'] = $accountId;
            // $_SESSION['account_type'] = 

            echo json_encode([
                'status' => 'success',
                'message' => 'Đăng nhập thành công'
            ]);
        }

        //changepassword
        public function changepassword() {
            session_start();
            if (!isset($_SESSION['account_id'])) {
                header('Location: /project-Web2/user/index.php');
                exit();
            }
            ob_start();
            include __DIR__ . '/../views/layouts/changepasswordAjax.php';
            echo ob_get_clean();
        }
    
        public function changepasswordAjax() {
            ob_start();
            header('Content-Type: application/json');
    
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                echo json_encode(['status' => 'error', 'message' => 'Yêu cầu không hợp lệ']);
                ob_end_flush();
                exit();
            }
    
            session_start();
            if (!isset($_SESSION['account_id'])) {
                echo json_encode(['status' => 'error', 'message' => 'Vui lòng đăng nhập để đổi mật khẩu']);
                ob_end_flush();
                exit();
            }
    
            $old_password = $_POST['old_password'] ?? '';
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            $account_id = $_SESSION['account_id'];
    
            $email = $this->accountModel->getEmailById($account_id);
            if (!$email) {
                echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy tài khoản']);
                ob_end_flush();
                exit();
            }
    
            if (!$this->accountModel->isPasswordCorrect($email, $old_password)) {
                echo json_encode(['status' => 'error', 'message' => 'Mật khẩu cũ không chính xác']);
                ob_end_flush();
                exit();
            }
    
            if ($new_password !== $confirm_password) {
                echo json_encode(['status' => 'error', 'message' => 'Mật khẩu mới và xác nhận không khớp']);
                ob_end_flush();
                exit();
            }
    
            if ($old_password === $new_password) {
                echo json_encode(['status' => 'error', 'message' => 'Mật khẩu mới không được trùng cũ']);
                ob_end_flush();
                exit();
            }
    
            if ($this->accountModel->updatePassword($account_id, $new_password)) {
                echo json_encode(['status' => 'success', 'message' => 'Đổi mật khẩu thành công']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Đổi mật khẩu thất bại']);
            }
            ob_end_flush();
            exit();
        }

        public function updateAccount() {
            session_start();
            if (!isset($_SESSION['account_id'])) {
                header('Location: /project-Web2/user/index.php');
                exit();
            }
            ob_start();
            include __DIR__ . '/../views/layouts/update.php';
            echo ob_get_clean();
        }
    
        public function updateAccountAjax() {
    ob_start();
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['status' => 'error', 'message' => 'Yêu cầu không hợp lệ']);
        ob_end_flush();
        exit();
    }

    session_start();
    if (!isset($_SESSION['account_id'])) {
        echo json_encode(['status' => 'error', 'message' => 'Vui lòng đăng nhập để cập nhật tài khoản']);
        ob_end_flush();
        exit();
    }

    $account_id = $_SESSION['account_id'];
    $fullname = $_POST['fullname'] ?? '';
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $dob = $_POST['dob'] ?? null; // Để null nếu không có dữ liệu
    $gender = $_POST['gender'] ?? null;
    $address = $_POST['address'] ?? null;
    $phone = $_POST['phone'] ?? null;

    // Kiểm tra email có bị trùng không (trừ email của chính người dùng)
    $currentEmail = $this->accountModel->getEmailById($account_id);
    if ($email !== $currentEmail && $this->accountModel->emailExist($email)) {
        echo json_encode(['status' => 'error', 'field' => 'email', 'message' => 'Email đã được sử dụng']);
        ob_end_flush();
        exit();
    }

    // Xử lý upload ảnh nếu có
    $imagePath = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../../assets/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $imagePath = '/project-Web2/user/assets/uploads/' . time() . '_' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../../..' . $imagePath);
    }

    // Cập nhật thông tin người dùng
    $userUpdated = $this->userModel->updateUser($account_id, $fullname, $address, $email, $gender, $phone, $dob);
    $accountUpdated = $this->accountModel->updateAccount($account_id, $username);

    // Cập nhật ảnh nếu có
    if ($imagePath) {
        $this->accountModel->updateImage($account_id, $imagePath);
    }

    if ($userUpdated && $accountUpdated) {
        echo json_encode(['status' => 'success', 'message' => 'Cập nhật tài khoản thành công']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Cập nhật tài khoản thất bại']);
    }
    ob_end_flush();
    exit();
} 
    }
?>

