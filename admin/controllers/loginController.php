<?php
require_once __DIR__ . '/../../common/models/Login.php';

class LoginController {
    private $loginModel;

    public function __construct() {
        $this->loginModel = new Login();
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

            $user = $this->loginModel->getUserByUsername($TenTK);

            if ($user) {
                if ($this->loginModel->verifyPassword($MKTK, $user['MKTK'])) {
                    if ($user['LoaiTK'] == 1 || $user['LoaiTK'] == 4) {
                        session_start();
                        $_SESSION['user_id'] = $user['MaTK'];
                        $_SESSION['role'] = $user['LoaiTK'];
                        $_SESSION['TenTK'] = $user['TenTK']; // Lưu tên người dùng vào session

                        // Trả về phản hồi JSON thành công
                        echo json_encode(['status' => 'success', 'message' => 'Đăng nhập thành công!']);
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

    // Hiển thị tên tài khoản
    

    // Xử lý đăng xuất
    public function logout() {
        session_start();
        session_destroy();
        header("Location: /project-Web2/admin/controllers/loginController.php?action=index");
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
