<?php
    require_once __DIR__ . '/../../common/models/Account.php';

    class HomeController {
        public function getAccountData() {
            session_start();
            if (isset($_SESSION['account_id'])) {
                $accountModel = new Account();
                $name  = $accountModel->getNameById($_SESSION['account_id']);
                $image = $accountModel->getImage($_SESSION['account_id']);
                return [$name, $image];
            }
            return null;
        }

        public function index() {
            // $accountData = $this->getAccountData();
            // if ($accountData) {
            //     $name  = $accountData[0];
            //     $image = $accountData[1];
            //     require_once __DIR__ . '/../views/home.php';
            // } else {
            //     header('Location: /user/account/login');
            // }
        }
    }
    
?>