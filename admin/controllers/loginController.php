<?php
class LoginController {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $TenTK = $_POST['TenTK'];
            $MKTK = $_POST['MKTK'];

            // Giả lập kiểm tra tài khoản (thay bằng truy vấn cơ sở dữ liệu)
            if ($TenTK === 'admin' && $MKTK === '123456') {
                session_start();
                $_SESSION['user_id'] = 1;
                $_SESSION['TenTK'] = $TenTK;

                echo json_encode(['status' => 'success', 'message' => 'Đăng nhập thành công!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Tên tài khoản hoặc mật khẩu không đúng!']);
            }
            exit;
        }
    }

    public function logout() {
        session_start();
        $_SESSION = [];
        session_destroy();

        // Xóa PHP session cookie
        if (ini_get("session.use_cookies")) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $p['path'], $p['domain'], $p['secure'], $p['httponly']
            );
        }

        // Xóa cookie ứng dụng
        setcookie('user_id', '', time() - 3600, '/');
        setcookie('role', '', time() - 3600, '/');
        setcookie('TenTK', '', time() - 3600, '/');

        // Chuyển hướng đến trang login
        header("Location: /project-Web2/admin/views/layouts/login.php");
        exit;
    }
}

// Xử lý yêu cầu từ URL
$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$controller = new LoginController();

switch ($action) {
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