<?php

require_once __DIR__ . '/../../admin/controllers/categoryController.php';
require_once __DIR__ . '/../../admin/controllers/dashboardController.php';
require_once __DIR__ . '/../../admin/controllers/importController.php';
require_once __DIR__ . '/../../admin/controllers/orderController.php';
require_once __DIR__ . '/../../admin/controllers/productController.php';
require_once __DIR__ . '/../../admin/controllers/userController.php';
require_once __DIR__ . '/../../admin/controllers/reviewController.php';
require_once __DIR__ . '/../../admin/controllers/providerController.php';

class RouteAdmin {
    public function router($url) {
        $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
        $action = isset($_GET['action']) ? $_GET['action'] : 'index';
        $current_page = isset($_GET['current_page']) ? (int)$_GET['current_page'] : 1;
        $id = isset($_GET['id']) ? $_GET['id'] : null;

        if (!isset($_SESSION['user_id'])) {
            header("Location: /project-Web2/admin/views/layouts/login.php");
            exit;
        }

        error_log("User ID: " . $_SESSION['user_id']);
        error_log("Role: " . $_SESSION['role']);

        // Lấy loại tài khoản từ session
        $role = isset($_SESSION['role']) ? $_SESSION['role'] : null;
        
        $permissions = [
            'dashboard' => [1, 2, 3, 4], 
            'category' => [1, 4],
            'product' => [1, 4], 
            'user' => [3, 4], 
            'import' => [1, 4], 
            'order' => [2, 4], 
            'review' => [2, 4],
        ];
        
        // Kiểm tra quyền truy cập
        if (isset($permissions[$page]) && !in_array($role, $permissions[$page])) {
            echo "<script>alert('Bạn không có quyền truy cập vào trang này!'); window.history.back();</script>";
            exit;
        }
        switch ($page) {
            case 'dashboard':
                $controller = new DashboardController();
                switch($action) {
                    case 'index':
                        $controller->index();
                        break;
                    default:
                        // Nếu không tìm thấy action, có thể chuyển hướng về trang 404 hoặc trang mặc định
                        header('HTTP/1.0 404 Not Found');
                        exit('Action not found');   
                }
                break;
            case 'category':
                $controller = new CategoryController();
                switch($action) {
                    case 'index':
                        $controller->index();
                        break;
                    case 'create':
                        $controller->create();
                        break;
                    case 'edit':
                        $controller->edit();
                        break;
                    case 'delete':
                        $controller->delete();
                        break;
                    default:
                        // Nếu không tìm thấy action, có thể chuyển hướng về trang 404 hoặc trang mặc định
                        header('HTTP/1.0 404 Not Found');
                        exit('Action not found');   
                }
                break;

            case 'user':
                $controller = new UserController();
                switch($action) {
                    case 'index':
                        $controller->index();
                        break;
                    case 'create':
                        $controller->create();
                        break;
                    case 'edit':
                        $controller->edit($id);
                        break;
                    case 'view':    
                        $controller->view($id);
                        break;
                    case 'lock':
                        $controller->lock($id);
                        break;
                    case 'delete':
                        $controller->delete($id);
                        break;
                    default:
                        // Nếu không tìm thấy action, có thể chuyển hướng về trang 404 hoặc trang mặc định
                        header('HTTP/1.0 404 Not Found');
                        exit('Action not found');   
                }
                break;

            case 'provider':
                $controller = new ProviderController();
                switch($action) {
                    case 'index':
                        $controller->index();
                        break;
                    case 'create':
                        $controller->create();
                        break;
                    case 'edit':
                        $controller->edit();
                        break;
                    case 'detail':
                        $controller->detail();
                        break;
                    case 'delete':
                        $controller->delete();
                        break;  
                    default:
                        header('HTTP/1.0 404 Not Found');
                        exit('Action not found');  
                }
                break;

            case 'product':
                $controller = new ProductController();
                switch($action) {
                    case 'index':
                        $controller->index($current_page);
                        break;
                    case 'create':
                        $controller->create();
                        break;
                    case 'edit':
                        $controller->edit($id);
                        break;
                    case 'allow':
                        $controller->allow();
                        break;
                    case 'detail':
                        $controller->detail($id);
                        break;
                    case 'delete':
                        $controller->delete($id);
                        break;
                    default:
                        // Nếu không tìm thấy action, có thể chuyển hướng về trang 404 hoặc trang mặc định
                        header('HTTP/1.0 404 Not Found');
                        exit('Action not found');   
                }
                break;

            case 'import':
                $controller = new ImportController();
                switch ($action) {
                    case 'index':
                        $controller->index($current_page);
                        break;
                    case 'changeStatus':
                        $controller->changeStatus();
                        break;
                    case 'create':
                        $controller->create();
                        break;
                    case 'detail':
                        $controller->detail();
                        break;
                    case 'detail':
                        $id = $_GET['id'] ?? null;
                        if ($id) {
                            $controller->detail($id);
                        } else {
                            header('HTTP/1.0 404 Not Found');
                            exit('ID not provided');
                        }
                        break;
                    default:
                        header('HTTP/1.0 404 Not Found');
                        exit('Action not found');
                }
                break;

            case 'order':
                $controller = new OrderController();
                switch($action) {
                    case 'index':
                        $controller->index($current_page);
                        break;
                    case 'detail':
                        $controller->detail($id);
                        break;
                    case 'changeStatus':
                        $controller->changeStatus();
                        break;
                    default:
                        // Nếu không tìm thấy action, có thể chuyển hướng về trang 404 hoặc trang mặc định
                        header('HTTP/1.0 404 Not Found');
                        exit('Action not found');   
                }
                break;

            case 'review':
                $controller = new ReviewController();
                switch($action) {
                    case 'index':
                        $controller->index();
                        break;
                    default:
                        // Nếu không tìm thấy action, có thể chuyển hướng về trang 404 hoặc trang mặc định
                        header('HTTP/1.0 404 Not Found');
                        exit('Action not found');   
                }
                break;

            default:
                header('HTTP/1.0 404 Not Found');
                exit('Page not found');
        }
    }
}
?>
