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
        // $dashboardController = new DashboardController();
        // $dashboardController->index();
        // $userController = new UserController();
        // $userController->index();

        $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
        $action = isset($_GET['action']) ? $_GET['action'] : 'index';
        $id = isset($_GET['id']) ? $_GET['id'] : null;

        switch($page) {
            case 'dashboard':
                $controller = new DashboardController();
                break;
            case 'category':
                $controller = new CategoryController();
                break;
            case 'user':
                $controller = new UserController();
                break;
            case 'product':
                $controller = new ProductController();
                break;
            case 'import':
                $controller = new ImportController();
                break;
            case 'order':
                $controller = new OrderController();
                break;
            
            case 'review':
                $controller = new ReviewController();
                break;
            default:
                // Nếu không tìm thấy controller, có thể chuyển hướng về trang 404 hoặc trang mặc định
                header('HTTP/1.0 404 Not Found');
                exit('Page not found');
        }
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
            case 'delete':
                $controller->delete($id);
                break;
            // case 'authorSuggestion':
            //     if ($page == 'product') {
            //         $controller->authorSuggestion();
            //     } else {
            //         // Nếu không phải là trang sản phẩm, có thể chuyển hướng về trang 404 hoặc trang mặc định
            //         header('HTTP/1.0 404 Not Found');
            //         exit('Action not found');   
            //     }
            //     break;
            default:
                // Nếu không tìm thấy action, có thể chuyển hướng về trang 404 hoặc trang mặc định
                header('HTTP/1.0 404 Not Found');
                exit('Action not found');   
        }
    }
}