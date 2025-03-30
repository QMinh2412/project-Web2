<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

require_once './AccountController.php';

$accountController = new AccountController();
$accountController->loginAjax(); // Gọi trực tiếp, không cần echo json_encode()
?>
