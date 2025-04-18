<?php
    require_once __DIR__ . '/../../common/config/init.php';

    class OrderController{
        public function index(){

            ob_start();
            include __DIR__ . '/../views/checkout/checkout.php';
            $main_content = ob_get_clean();
            include __DIR__ . '/../views/layouts/main_layout.php';
        }
    }
?>