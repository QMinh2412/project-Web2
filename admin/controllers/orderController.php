<?php
    require_once __DIR__ . '/../../common/core/BaseController.php';
    require_once __DIR__ . '/../../common/models/Order.php';

    class OrderController extends BaseController {

        public function index($currentPage) {
            $orderModel = new Order();
            $accountModel = new Account();
            $userModel = new User();
            $users = $userModel->getAllUsers();

            $userMap = [];
            foreach ($users as $us) {
                $userMap[$us['MaND']] = $us['TenND'];
            }

            $this->render('order/index', [
                'title' => 'Order Management',
                'message' => 'Welcome to the Order Management page!'
            ]);
        }
    }
?>
<!-- cần thông tin bên folder user -->