<?php
    require_once __DIR__ . '/../../common/config/init.php';
    require_once __DIR__ . '/../../common/models/Account.php';
    require_once __DIR__ . '/../../common/models/User.php';
    require_once __DIR__ . '/../../common/models/Image.php';

    class AccountController{
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
                    // session_start();
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
            // session_start();
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

            // session_start();
            $accountId = $accountModel->getAccountIdByEmail($email);
            $_SESSION['account_id'] = $accountId;
            $_SESSION['account_role'] = $accountModel->getRoleByEmail($email);

            echo json_encode([
                'status' => 'success',
                'message' => 'Đăng nhập thành công'
            ]);
        }

        //changepassword
        public function changepassword() {
            ob_start();
            include __DIR__ . '/../views/layouts/changepasswordAjax.php';
            $main_content = ob_get_clean();
            include __DIR__ . '/../views/layouts/main_layout.php';
        }
    
        public function changepasswordAjax() {    
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                echo json_encode(['status' => 'error', 'message' => 'Yêu cầu không hợp lệ']);
                ob_end_flush();
                exit();
            }
    
            $old_password = $_POST['old_password'] ?? '';
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            $account_id = $_SESSION['account_id'];

            // kiểm tra dữ liệu không được trống
            if(empty($old_password)){
                echo json_encode(['status' => 'error', 'field' => 'old_password', 'message' => 'Vui lòng nhập vào mật khẩu cú']);
                exit();
            }
            if(empty($new_password)){
                echo json_encode(['status' => 'error', 'field' => 'new_password', 'message' => 'Vui lòng nhập vào mật khẩu mới']);
                exit();
            }
            if(empty($confirm_password)){
                echo json_encode(['status' => 'error', 'field' => 'confirm_password', 'message' => 'Vui lòng xác nhận lại mật khẩu mới']);
                exit();
            }
    
            $accountModel = new Account();
    
            $email = $accountModel->getEmailById($account_id);
            if (!$email) {
                echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy tài khoản']);
                // ob_end_flush();
                exit();
            }
    
            if (!$accountModel->isPasswordCorrect($email, $old_password)) {
                echo json_encode(['status' => 'error','field' => 'old_password', 'message' => 'Mật khẩu cũ không chính xác']);
                exit();
            }
    
            if ($new_password !== $confirm_password) {
                echo json_encode(['status' => 'error','field' => 'confirm_password', 'message' => 'Mật khẩu mới và xác nhận không khớp']);
                exit();
            }
    
            if ($old_password === $new_password) {
                echo json_encode(['status' => 'error','field' => 'new_password', 'message' => 'Mật khẩu mới không được trùng cũ']);
                exit();
            }
    
            if ($accountModel->updatePassword($account_id, $new_password)) {
                echo json_encode(['status' => 'success', 'message' => 'Đổi mật khẩu thành công']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Đổi mật khẩu thất bại']);
            }
            exit();
        }

        public function updateAccount() {
            $userModel = new User();
            $accountModel = new Account();
            $current_account = $_SESSION['account_id'];
            $userInfo = $userModel->getById($current_account);
            $accountInfo = $accountModel->getById($current_account);

            ob_start();
            include __DIR__ . '/../views/layouts/update.php';
            $main_content = ob_get_clean();
            include __DIR__ . '/../views/layouts/main_layout.php';
        }
    
        public function updateAccountAjax() {
            // session_start();
            // header('Content-Type: application/json');

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                echo json_encode(['status' => 'error', 'message' => 'Yêu cầu không hợp lệ']);
                exit();
            }

            if (!isset($_SESSION['account_id'])) {
                echo json_encode(['status' => 'error', 'message' => 'Vui lòng đăng nhập để cập nhật tài khoản']);
                exit();
            }

            // lấy thông tin từ form
            $account_id = $_SESSION['account_id'];
            $fullname = $_POST['fullname'] ?? '';
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $dob = $_POST['dob'] ?? ''; // Để null nếu không có dữ liệu
            $gender = $_POST['gender'] ?? '';
            $address = $_POST['address'] ?? '';
            $phone = $_POST['phone'] ?? '';

            // tạo đối tượng
            $accountModel = new Account();
            $userModel = new User();
            $imageModel = new Image();

            // Kiểm tra email có bị trùng không (trừ email của chính người dùng)
            $currentEmail = $userModel->getById($account_id)['EmailND'];
            if ($email !== $currentEmail && $accountModel->emailExist($email)) {
                echo json_encode(['status' => 'error', 'field' => 'email', 'message' => 'Email đã được sử dụng']);
                exit();
            }

            // Xử lý upload ảnh nếu có
            $imagePath = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../../common/images/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                // Kiểm tra loại file và kích thước
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($_FILES['image']['type'], $allowedTypes)) {
                    echo json_encode(['status' => 'error', 'message' => 'Chỉ cho phép upload file ảnh (JPEG, PNG, GIF)']);
                    exit();
                }
                $maxSize = 5 * 1024 * 1024; // 5MB
                if ($_FILES['image']['size'] > $maxSize) {
                    echo json_encode(['status' => 'error', 'message' => 'Kích thước file quá lớn, tối đa 5MB']);
                    exit();
                }

                // Tạo tên file duy nhất
                $fileName = 'user_' . $account_id . '_' . time() . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $uploadPath = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                    $imagePath = '/common/images/' . $fileName;
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Lỗi khi upload ảnh']);
                    exit();
                }
            }

            // Cập nhật thông tin người dùng
            $userUpdated = $userModel->updateUser($account_id, $fullname, $address, $email, $gender, $phone, $dob);
            $accountUpdated = $accountModel->updateAccountName($account_id, $username);

            // Cập nhật ảnh nếu có
            if ($imagePath) {
                $imageUpdated = $imageModel->updateImageForUser($account_id, $imagePath);
                if (!$imageUpdated) {
                    echo json_encode(['status' => 'error', 'message' => 'Lỗi khi cập nhật ảnh']);
                    exit();
                }
            }

            if ($userUpdated && $accountUpdated) {
                echo json_encode(['status' => 'success', 'message' => 'Cập nhật tài khoản thành công']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Cập nhật tài khoản thất bại']);
            }
            exit();
        } 
    }
?>

