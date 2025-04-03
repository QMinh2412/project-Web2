<?php
    require_once __DIR__ . '/../../common/core/BaseController.php';

    class OrderController extends BaseController {
        public function index() {
            // Gọi view tương ứng với action index
            $this->render('order/index', [
                'title' => 'Order Management',
                'message' => 'Welcome to the Order Management page!'
            ]);
        }
    }
?>