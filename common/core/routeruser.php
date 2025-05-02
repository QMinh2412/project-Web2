<?php
require_once __DIR__ . '/../../user/controllers/HomeController.php';
require_once __DIR__ . '/../../user/controllers/AccountController.php';
require_once __DIR__ . '/../../user/controllers/ProductController.php';
require_once __DIR__ . '/../../user/controllers/CartController.php';
require_once __DIR__ . '/../../user/controllers/OrderController.php';
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

            case 'detail':
                $controller = new ProductController();
                break;

            case 'cart':
                $controller = new CartController();
                break;

            case 'checkout': 
                $controller = new OrderController();
                break;

            case 'order':
                $controller = new OrderController();
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
            case 'search':
                $controller->search();
                break;
            case 'updateAccount':
                $controller->updateAccount();
                break;
            case 'updateAccountAjax':
                $controller->updateAccountAjax();
                break;
            case 'changePassword':
                $controller->changepassword();
                break;
            case 'changepasswordAjax':
                $controller->changepasswordAjax();
                break;
            case 'show_detail':
                $controller->showDetail();
                break;
            case 'writeComment':
                $controller->writeComment();
                break;
            case 'replyComment':
                $controller->replyComment();
                break;
            case 'addToCart':
                $controller->addToCart();
                break;
            case 'showCheckout':
                $controller->showCheckout();
                break;
            case 'placeOrder': 
                $controller->placeOrder();
                break;
            case 'updateStatus':
                $controller->updateStatus();
                break;
            case 'remove':
                $controller->remove();
                break;
            case 'updateQuantity':
                $controller->updateQuantity();
                break;
            case 'buynow':
                $controller->buyNow();
                break;
            case 'checkout':
                $controller->checkout();
                break;
            case "calculateFeeShip":
                $controller->calculateFeeShip();
                break;
            case 'showOrderHistory':
                $controller->showOrderHistory();
                break;
            case 'showOrderHistoryAjax':
                $controller->showOrderHistoryAjax();
                break;
            case 'showOrderDetail':
                $controller->showOrderDetail();
                break;
            case 'cancelOrder':
                $controller->cancelOrder();
                break;
            case 'filterOrders':
                $controller->filterOrders();
                break;
            default:
                $controller->index();
                break;
        }
    }
}
?>