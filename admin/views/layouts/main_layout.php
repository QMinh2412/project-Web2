<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="./assets/css/admin.css">
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/leftmenu.css">
    <link rel="stylesheet" href="./assets/css/user.css">
    <link rel="stylesheet" href="./assets/css/category.css">
    <link rel="stylesheet" href="./assets/css/product.css">
    <link rel="stylesheet" href="./assets/css/dashboard.css">
    <link rel="stylesheet" href="./assets/css/order.css">
    <link rel="stylesheet" href="./assets/css/review.css">
    <link rel="stylesheet" href="./assets/css/import.css">
    <link rel="stylesheet" href="./assets/css/provider.css">
</head>
<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: /project-Web2/admin/views/layouts/login.php");
    exit;
}
?>
<body>
    <div class="wrapper">
        <?php
            include "./views/layouts/header.php";
        ?>
        <div class="container">
            <?php
                include "./views/layouts/leftmenu.php";
            ?>
            <div class="content">
                <?php
                    echo $content;
                ?>
            </div>     
        </div>
    </div>
</body>
</html>

<script src="/project-Web2/admin/assets/js/script.js"></script>