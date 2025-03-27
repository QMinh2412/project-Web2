<?php
    require_once './AccountController.php';

    $accountController = new AccountController();

    // Call the registerAjax method
    $response = $accountController->registerAjax();

    // Return the response as JSON
    // header('Content-Type: application/json');

?>