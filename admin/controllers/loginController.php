<?php
    require_once __DIR__ . '/../../common/models/Account.php';

    class LoginController {
        private $accountModel;

        public function __construct() {
            $this->accountModel = new Account();
        }

        // Hiển thị trang đăng nhập
        public function index() {
            include '../views/layouts/login.php';
        }

        // Xử lý đăng nhập
        public function login() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $TenTK = $_POST['TenTK'];
                $MKTK  = $_POST['MKTK'];

                $user = $this->accountModel->getUserByUsername($TenTK);

                if ($user) {
                    if ($this->accountModel->verifyPassword($MKTK, $user['MKTK'])) {
                        if ($user['LoaiTK'] == 1 || $user['LoaiTK'] == 2 || $user['LoaiTK'] == 3 || $user['LoaiTK'] == 4) {
                            session_start();
                            $_SESSION['user_id'] = $user['MaTK'];
                            $_SESSION['role'] = $user['LoaiTK'];
                            $_SESSION['TenTK'] = $user['TenTK'];
                
                            // Lưu thông tin vào cookie (thời hạn 7 ngày)
                            setcookie('user_id', $user['MaTK'], time() + (7 * 24 * 60 * 60), '/');
                            setcookie('role', $user['LoaiTK'], time() + (7 * 24 * 60 * 60), '/');
                            setcookie('TenTK', $user['TenTK'], time() + (7 * 24 * 60 * 60), '/');

                            // xác định URL mặc định cho từng loại tài khoản
                            $redirectUrl = '/project-Web2/admin/views/layouts/login.php'; 
                            switch ($user['LoaiTK']) {
                                case 0: // Khách hàng
                                    $redirectUrl = '/project-Web2/admin/index.php?page=dashboard&action=index';
                                    break;
                                case 1: // Quản lý
                                    $redirectUrl = '/project-Web2/admin/index.php?page=import&action=index';
                                    break;
                                case 2: // Nhân viên
                                    $redirectUrl = '/project-Web2/admin/index.php?page=dashboard&action=index';
                                    break;
                                case 3: // Admin
                                    $redirectUrl = '/project-Web2/admin/index.php?page=user&action=index';
                                    break;
                                case 4: // Chủ doanh nghiệp
                                    $redirectUrl = '/project-Web2/admin/index.php?page=dashboard&action=index';
                                    break;
                                default:
                                    // Nếu không khớp với bất kỳ loại tài khoản nào, chuyển hướng đến trang mặc định
                                    $redirectUrl = '/project-Web2/admin/views/layouts/login.php';
                                    break;
                            }

                            // Trả về phản hồi JSON thành công
                            echo json_encode(['status' => 'success', 'redirect' => $redirectUrl]);
                            exit;
                        } else {
                            // Trả về lỗi không có quyền truy cập
                            echo json_encode(['status' => 'error', 'message' => 'Bạn không có quyền truy cập!']);
                            exit;
                        }
                    } else {
                        // Trả về lỗi mật khẩu không chính xác
                        echo json_encode(['status' => 'error', 'message' => 'Mật khẩu không chính xác!']);
                        exit;
                    }
                } else {
                    // Trả về lỗi tài khoản không tồn tại
                    echo json_encode(['status' => 'error', 'message' => 'Tên tài khoản không tồn tại!']);
                    exit;
                }
            }
        }

        // Xử lý đăng xuất
        public function logout() {
            session_start();
            session_destroy();
        
            // Xóa cookie
            setcookie('user_id', '', time() - 3600, '/');
            setcookie('role', '', time() - 3600, '/');
            setcookie('TenTK', '', time() - 3600, '/');
        
            header("Location: /project-Web2/admin/views/layouts/login.php");
            exit;
        }
    }

    // Xử lý yêu cầu từ form
    $action = isset($_GET['action']) ? $_GET['action'] : 'index';
    $controller = new LoginController();

    switch ($action) {
        case 'index':
            $controller->index();
            break;
        case 'login':
            $controller->login();
            break;
        case 'logout':
            $controller->logout();
            break;
        default:
            echo "Action không hợp lệ!";
            break;
    }
?>