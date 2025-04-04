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
</head>
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