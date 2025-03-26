<?php
    require_once '../../common/models/Account.php';

    class AccountController{
        public function registerAjax(){
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $fname = $_POST['fullname'];
                $uname = $_POST['username'];
                $email = $_POST['email'];
                $pass = $_POST['password'];
                $phone = $_POST['phone'] ? $_POST['phone'] : '';
                $dob = $_POST['dob'] ? $_POST['dob'] : '';
                $gender = $_POST['gender'];
                $address = $_POST['address'] ? $_POST['address'] : '';

                $accountModel = new Account();
                // Kiểm tra email đã được đăng ký hay chưa
                if($accountModel->emailExist($email)){
                    echo json_encode([
                        'status' => 'error',
                        'field' => 'email',
                        'message' => 'Email đã được đăng ký'
                    ]);
                    return;
                }

                // Mã hóa mật khẩu
                $hashedPassword = hash('sha256', $pass);

                // Lưu thông tin người dùng mới
                $userModel = new User();
                $idNewUser = $userModel->createUser($fname, $address,$email, $gender, $phone, $dob);
                $currentCreate = date("Y-m-d");
                $accountModel->createAccount($uname, 0, $currentCreate, 1, $hashedPassword, $idNewUser);

                if($idNewUser){
                    // Bắt đầu session và lưu thông tin
                    session_start();
                    $_SESSION['user_id'] = $idNewUser;

                    // Trả về kết quả thành công
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
                // Trường hợp không phải yêu cầu POST
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Yêu cầu không hợp lệ'
                ]);
            }
        }
    }
?>