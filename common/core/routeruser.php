<?php
require_once __DIR__ . '../../user/controllers/HomeController.php';
require_once __DIR__ . '../../user/controllers/AccountController.php';
require_once __DIR__ . '../models/User.php';
require_once __DIR__ .'../models/Account.php';
class Route {
    public function router($url) {
        // Phân tách URL thành các phần
        $urlParts = explode('/', trim($url, '/'));

        // Xác định page và action
        $page = isset($urlParts[0]) && $urlParts[0] !== '' ? $urlParts[0] : 'home';
        $action = isset($urlParts[1]) && $urlParts[1] !== '' ? $urlParts[1] : 'index';

        // Sử dụng switch case để xác định controller
        switch ($page) {
            case 'user':
                $controller = new AccountController();
                break;

            case 'home':
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