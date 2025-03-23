<?php
    require_once __DIR__ . '/../../common/models/Account.php';

    class HomeController{
        public function getAccountData(){
            session_start();
            if( isset($_SESSION['account_id']) ){
                $accountModel = new Account();
                return [$accountModel->getById($_SESSION['account_id']), $accountModel->getImage($_SESSION['account_id'])];
            }
            return null;
        }
    }
?>