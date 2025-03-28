<?php
require_once __DIR__ . '/../../user/controllers/HomeController.php';
require_once __DIR__ . '/../../user/controllers/AccountController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Account.php';
class Route {
    public function router($url) {
        // Phân tách URL thành các phần
        $urlParts = explode('/', trim($url, '/'));

        var_dump($urlParts);

        // Xác định page và action
        $page = isset($_GET['page']) ? $_GET['page'] : 'home';
        $action = isset($_GET['action']) ? $_GET['page'] : 'index';

        print_r($page);
        print_r($action);

        switch ($page) {
            case 'user':
                $controller = new AccountController();
                break;

            default:
                $controller = new HomeController();
                break;
        }

        switch ($action) {
            case 'profile':
                // $controller->profile();
                // break;
            default:
                $controller->index();
                break;
        }
    }
}
?>