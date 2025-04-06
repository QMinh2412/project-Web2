<?php
require_once __DIR__ . '/../../user/controllers/HomeController.php';
require_once __DIR__ . '/../../user/controllers/AccountController.php';
require_once __DIR__ . '/../../user/controllers/ProductController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Account.php';
class Route {
    public function router($url) {
        // Phân tách URL thành các phần
        // $urlParts = explode('/', trim($url, '/'));

        // var_dump($urlParts);

        // Xác định page và action
        $page = isset($_GET['page']) ? $_GET['page'] : 'home';
        $action = isset($_GET['action']) ? $_GET['action'] : 'index';

        // print_r($page);
        // print_r($action);

        switch ($page) {
            case 'account':
                $controller = new AccountController();
                break;

            case 'product':
                $controller = new ProductController();
                break;

            default:
                $controller = new HomeController();
                break;
        }

        switch ($action) {
            case 'register':   
                $controller->registerAjax();
                break;
            case 'login':
                $controller->loginAjax();
                break;
            case 'logout':
                $controller->logout();
                break;
            case 'show_page':
                $controller->pagingHandleAjax();
                break;
            case 'render_by_category':
                $controller->showCategoryAjax();
                break;
            case 'render_by_author':
                $controller->showAuthorAjax();
                break;
            case 'filter':
                $controller->filterPriceRangeAjax();
                break;
            default:
                $controller->index();
                break;
        }
    }
}
?>
