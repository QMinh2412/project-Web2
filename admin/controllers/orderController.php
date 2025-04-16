<?php
    require_once __DIR__ . '/../../common/core/BaseController.php';
    require_once __DIR__ . '/../../common/models/Order.php';

    class OrderController extends BaseController {

        public function index($currentPage) {
            $orderModel = new Order();
            $userModel = new User();
            $users = $userModel->getAllUsers();

            $ordersPerPage = 10;
            $firstOrder = $ordersPerPage * $currentPage - 9;

            $orders = $orderModel->getAllOrdersWithTotals($currentPage, $ordersPerPage);
            $pagingation = $orderModel->getOrderPagination($currentPage, $ordersPerPage);

            $userMap = [];
            foreach ($users as $us) {
                $userMap[$us['MaND']] = $us['TenND'];
            }

            $this->render('order/index', [
                'firstOrder' => $firstOrder,
                'orders' => $orders,
                'userMap' => $userMap,
                'pagination' => $pagingation
            ]);
        }

        public function detail($orderId) {
            $orderModel = new Order();
            $userModel = new User();

            $order = $orderModel->getOrderById($orderId);
            $userId = $order['MaKH'];
            $user = $userModel->getById($userId);

            $this->render('order/detail', [
                'order' => $order,
                'user' => $user
            ]);
        }
    }
?>