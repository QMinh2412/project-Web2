<?php
// index.php - Entry point of the web application

require_once __DIR__ . '/../common/core/routeruser.php'; // Sửa đường dẫn

// Get the current URL
$currentUrl = $_SERVER['REQUEST_URI'];
echo $currentUrl;

// Initialize the router and handle the request
$route = new Route();
$route->router($currentUrl);
?>