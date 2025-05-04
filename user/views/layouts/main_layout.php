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
    <div style="background-color: #f1f1f1; min-height: 600px;">
        <?php 
            echo $main_content; 
            // include __DIR__ . '/../product/product.php'; // Include the main content dynamically
            // include __DIR__ . '/../product/detail.php';
        ?>
    </div>
    <?php
        require __DIR__ . '/footer.php';
    ?>
    <button class="scroll-to-top" onclick="scrollToTop()">
        <i class="fa-solid fa-arrow-up"></i>
    </button>
</body>
<script>
        window.addEventListener("scroll", function () {
            // Nếu cuộn xuống quá 300px, hiển thị nút
            if (window.scrollY > 100) {
                document.querySelector('.scroll-to-top').classList.add("show");
            } else {
                document.querySelector('.scroll-to-top').classList.remove("show");
            }
        });

        function scrollToTop(){
            window.scrollTo({ top: 0, behavior: "smooth" });
        }
</script>
</html>