<?php

require_once __DIR__ . '/../../admin/controllers/categoryController.php';
require_once __DIR__ . '/../../admin/controllers/dashboardController.php';
require_once __DIR__ . '/../../admin/controllers/importController.php';
require_once __DIR__ . '/../../admin/controllers/orderController.php';
require_once __DIR__ . '/../../admin/controllers/productController.php';
require_once __DIR__ . '/../../admin/controllers/userController.php';
require_once __DIR__ . '/../../admin/controllers/reviewController.php';

class RouteAdmin {
    public function router($url) {
        $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
        $action = isset($_GET['action']) ? $_GET['action'] : 'index';
        $current_page = isset($_GET['current_page']) ? (int)$_GET['current_page'] : 1;
        $id = isset($_GET['id']) ? $_GET['id'] : null;

        switch ($page) {
            case 'dashboard':
                $controller = new DashboardController();
                switch($action) {
                    case 'index':
                        $controller->index();
                        break;
                    case 'favoriteCustomers': // Thêm action này
                        $controller->favoriteCustomers();
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
                switch($action) {
                    case 'index':
                        $controller->index($current_page);
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
            
            // case 'warehouse':
            //     $controller = new WarehouseController();
            //     switch($action) {
            //         case 'history':
            //             $controller->history();
            //         default:
            //             // Nếu không tìm thấy action, có thể chuyển hướng về trang 404 hoặc trang mặc định
            //             header('HTTP/1.0 404 Not Found');
            //             exit('Action not found');   
            //     }
            //     break;
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
