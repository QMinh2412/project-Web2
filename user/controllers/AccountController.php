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
                $hashedPassword = hash('sha256', $pass);
        
                // Lưu thông tin người dùng mới
                $userModel = new User();
                $idNewUser = $userModel->createUser($fname, $address, $email, $gender, $phone, $dob);
                $currentCreate = date("Y-m-d");
                $accountId = $accountModel->createAccount($uname, 0, $currentCreate, 1, $hashedPassword, $idNewUser);
        
                if ($idNewUser) {        
                    session_start();
                    $_SESSION['user_id'] = $idNewUser;
                    $_SESSION['account_id'] = $accountId;
                    $_SESSION['user_email'] = $email;

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
            header('Content-Type: application/json');
        
            if ($_SERVER["REQUEST_METHOD"] !== "POST") {
                echo json_encode(["status" => "error", "message" => "Yêu cầu không hợp lệ"]);
                exit;
            }
        
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
        
            if (empty($email) || empty($password)) {
                echo json_encode(["status" => "error", "message" => "Thiếu thông tin đăng nhập"]);
                exit;
            }
        
            require_once __DIR__ . "/../../config/db.php";
        
            $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if ($conn->connect_error) {
                echo json_encode(["status" => "error", "message" => "Lỗi kết nối database"]);
                exit;
            }
        
            // Tìm email trong bảng nguoidung
            $stmt = $conn->prepare("SELECT id FROM nguoidung WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 0) {
                echo json_encode(["status" => "error", "message" => "Email không tồn tại"]);
                exit;
            }
            
            $user = $result->fetch_assoc();
            $user_id = $user["id"];
        
            // Tìm mật khẩu trong bảng taikhoan
            $stmt = $conn->prepare("SELECT password FROM taikhoan WHERE user_id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 0) {
                echo json_encode(["status" => "error", "message" => "Không tìm thấy tài khoản"]);
                exit;
            }
        
            $account = $result->fetch_assoc();
        
            // Kiểm tra mật khẩu (Giả sử mật khẩu được lưu bằng SHA-256)
            if (hash('sha256', $password) !== $account["password"]) {
                echo json_encode(["status" => "error", "message" => "Sai mật khẩu"]);
                exit;
            }
        
            // Đăng nhập thành công
            session_start();
            $_SESSION["user_id"] = $user_id;
            $_SESSION["email"] = $email;
        
            echo json_encode(["status" => "success", "message" => "Đăng nhập thành công"]);
            exit;
        }

    }
?>

