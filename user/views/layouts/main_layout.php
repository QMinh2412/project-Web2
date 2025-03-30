<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/project-Web2/user/assets/css/main_layout.css">
    <title>Bookstore Student</title>
</head>
<body>
    <?php
        require __DIR__ . '/header.php';
    ?>
    <div style="height: 500px; border: 1px solid black;">
        <?php echo $main_content; ?>
    </div>
    <?php
        require __DIR__ . '/footer.php';
    ?>
</body>
</html>