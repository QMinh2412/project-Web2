<?php
require_once __DIR__ . '/../common/core/routeruser.php'; 

$currentUrl = $_SERVER['REQUEST_URI'];
echo $currentUrl;

$route = new Route();
$route->router($currentUrl);
?>