<?php
    require_once __DIR__ . '/../../common/models/Account.php';
    require_once __DIR__ . '/../../common/models/User.php';

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
                    session_start();
                    $_SESSION['account_id'] = $idNewUser;

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

            echo json_encode([
                'status' => 'success',
                'message' => 'Đăng nhập thành công'
            ]);
        }

    }
?>

