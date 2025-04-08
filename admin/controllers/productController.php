<?php
    require_once __DIR__ . '/../../common/core/BaseController.php';
    require_once __DIR__ . '/../../common/models/Product.php';
    require_once __DIR__ . '/../../common/models/Image.php';
    require_once __DIR__ . '/../../common/models/Author.php';
    require_once __DIR__ . '/../../common/models/Category.php';
    require_once __DIR__ . '/../../common/models/Publisher.php';
    require_once __DIR__ . '/../../common/models/Provider.php';

    class ProductController extends BaseController {

        public function index() {
            // Gọi view tương ứng với action index
            $productModel = new Product();
            $products = $productModel->getAllProducts(); 
            $categoryModel = new Category();
            $categories = $categoryModel->getAllCategories(); // Lấy danh sách thể loại từ model

            $this->render('product/index', [
                'products' => $products,
                'categories' => $categories
            ]);
        }

        public function create() {
            $productModel = new Product();
            $imageModel = new Image();

            $categoryModel = new Category();
            $categories = $categoryModel->getAllCategories(); 

            $authorModel = new Author();
            $authors = $authorModel->getAllAuthors(); 

            $publisherModel = new Publisher();
            $publishers = $publisherModel->getAllPublishers();

            $providerModel = new Provider();
            $providers = $providerModel->getAllProviders();

            $this->render('product/create', [
                'categories' => $categories,
                'authors' => $authors,
                'publishers' => $publishers,
                'providers' => $providers
            ]);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $productName = trim(strip_tags($_POST['product_name']));
                $categoryId = $_POST['product_category'];
                $authorId = $_POST['product_author'];
                $publisherId = $_POST['product_publisher'];
                $providerId = $_POST['product_provider'];
                $productQuantity  = filter_var(filter_var($_POST['product_quantity'], FILTER_SANITIZE_NUMBER_INT), FILTER_VALIDATE_INT);
                $productPrice = filter_var(filter_var($_POST['product_price'], FILTER_SANITIZE_NUMBER_INT), FILTER_VALIDATE_INT);
                $productYear = $_POST['product_year'];
                $productPage = filter_var(filter_var($_POST['product_page'], FILTER_SANITIZE_NUMBER_INT), FILTER_VALIDATE_INT);
                $productSize = trim(strip_tags($_POST['product_size']));
                $productDescription = trim(strip_tags($_POST['product_description']));

                if ($authorId == 0) {
                    $authorName = trim(strip_tags($_POST['product_author_name']));
                    if (empty($authorName)) {
                        echo "<script>
                            alert('Vui lòng nhập tên tác giả!');
                            document.getElementById('product-author-name-input').focus();
                        </script>";
                        return;
                    }
                    $authorBirthday = $_POST['product_author_birthday'] ?? null;
                    $authorGender = $_POST['product_author_gender'] ?? null;

                    $authorData = [
                        'TenTG' => $authorName,
                        'NgSinhTG' => $authorBirthday,
                        'GioiTinhTG' => $authorGender
                    ];

                    $authorId = $authorModel->createAuthor($authorData);
                }

                if ($publisherId == 0) {
                    $publisherName = trim(strip_tags($_POST['product_publisher_name']));
                    if (empty($publisherName)) {
                        echo "<script>
                            alert('Vui lòng nhập tên nhà xuất bản!');
                            document.getElementById('product-publisher-name-input').focus();
                        </script>";
                        return;
                    }
                    $publisherAddress = trim(strip_tags($_POST['product_publisher_address'])) ?? null;
                    $publisherEmail = filter_var(filter_var($_POST['product_publisher_email'], FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL) ?? null;

                    $publisherData = [
                        'TenNXB' => $publisherName,
                        'DcNXB' => $publisherAddress,
                        'EmailNXB' => $publisherEmail
                    ];

                    $publisherId = $publisherModel->createPublisher($publisherData);
                }

                if ($providerId == 0) {
                    $providerName = trim(strip_tags($_POST['product_provider_name']));
                    if (empty($providerName)) {
                        echo "<script>
                            alert('Vui lòng nhập tên nhà cung cấp!');
                            document.getElementById('product-provider-name-input').focus();
                        </script>";
                        return;
                    }
                    $providerAddress = trim(strip_tags($_POST['product_provider_address'])) ?? null;
                    $providerEmail = filter_var(filter_var($_POST['product_provider_email'], FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL) ?? null;
                
                    $providerData = [
                        'TenNCC' => $providerName,
                        'DcNCC' => $providerAddress,
                        'EmailNCC' => $providerEmail
                    ];

                    $providerId = $providerModel->createProvider($providerData);
                }

                $productData = [
                    'TenSach' => $productName,
                    'MaLoai' => $categoryId,
                    'MaTG' => $authorId,
                    'MaNXB' => $publisherId,
                    'MaNCC' => $providerId,
                    'SoLgTon' => $productQuantity,
                    'GiaBan' => $productPrice,
                    'NamXB' => $productYear,
                    'SoTrang' => $productPage,
                    'KichThuoc' => $productSize,
                    'MoTa' => $productDescription
                ];                
                
                $isAdded = $productModel->createProduct($productData);

                if ($isAdded) {
                    echo "<script>
                        alert('Thêm sản phẩm thành công!');
                        window.location.href = '?page=product&action=index';
                    </script>";
                }
                else {
                    echo "<script>
                        alert('Thêm sản phẩm thất bại!');
                        document.getElementById('product-name-input').focus();
                    </script>";
                }
            }   
        }

        public function edit () {
            $productModel = new Product();
            $productId = $_GET['id'] ?? null;

            $categoryModel = new Category();
            $categories = $categoryModel->getAllCategories(); 

            $authorModel = new Author();
            $authors = $authorModel->getAllAuthors(); 

            $publisherModel = new Publisher();
            $publishers = $publisherModel->getAllPublishers();

            $providerModel = new Provider();
            $providers = $providerModel->getAllProviders();

            if ($productId) {
                $product = $productModel->getProductById($productId);

                if(!$product) {
                    echo "<script>alert('Sản phẩm không tồn tại!');</script>";
                    return;
                }

                $this->render('product/edit', [
                    'product' => $product,
                    'categories' => $categories,
                    'authors' => $authors,
                    'publishers' => $publishers,
                    'providers' => $providers
                ]);

                
            }
        }

    }
?>