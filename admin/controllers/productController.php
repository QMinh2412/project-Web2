<?php
    require_once __DIR__ . '/../../common/core/BaseController.php';
    require_once __DIR__ . '/../../common/models/Product.php';
    require_once __DIR__ . '/../../common/models/Image.php';
    require_once __DIR__ . '/../../common/models/Author.php';
    require_once __DIR__ . '/../../common/models/Category.php';
    require_once __DIR__ . '/../../common/models/Publisher.php';
    require_once __DIR__ . '/../../common/models/Provider.php';

    class ProductController extends BaseController {

        public function index($currentPage) {
            $productModel  = new Product();
            $categoryModel = new Category();

            $booksPerPage = 10;

            $products   = $productModel->getAllProducts($currentPage, $booksPerPage);
            $pagination = $productModel->getPagination($currentPage, $booksPerPage);

            $categories = $categoryModel->getAllCategories();
  
            $categoryMap = [];
            foreach ($categories as $cat) {
                $categoryMap[$cat['MaLoai']] = $cat['TenLoai'];
            }

            // Render view, truyền cả products, categoryMap và pagination
            $this->render('product/index', [
                'products'    => $products,
                'categoryMap' => $categoryMap,
                'pagination'  => $pagination
            ]);
        }


        public function create() {
            $productModel = new Product();
            $imageModel = new Image();

            $categoryModel = new Category();
            $categories = $categoryModel->getAllCategories(); 
            $categoryMap = [];
            foreach ($categories as $cat) {
                $categoryMap[$cat['MaLoai']] = $cat['TenLoai'];
            } 

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
                $productPage = filter_var(filter_var($_POST['product_page'], FILTER_SANITIZE_NUMBER_INT), FILTER_VALIDATE_INT) ?? null;
                $productSize = trim(strip_tags($_POST['product_size'])) ?? null;
                $productDescription = trim(strip_tags($_POST['product_description'])) ?? null;

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
                
                $array = $productModel->createProduct($productData);
                $isAdded = $array[0];
                $createdProductId = $array[1];
                
                $categoryName = $categoryMap[$categoryId];
                $projectRoot = realpath(__DIR__ . '/../../'); 
                $targetDir   = $projectRoot . '/common/images/' . $categoryName . '/' . $productName;
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }
                $counter = 1;
                foreach ($_FILES['product_image']['tmp_name'] as $index => $tmpName) {
                    if ($_FILES['product_image']['error'][$index] === UPLOAD_ERR_OK) {
                        $ext = pathinfo($_FILES['product_image']['name'][$index], PATHINFO_EXTENSION);
                        $fileName = $productName . '_' . $counter . '.' . $ext;
                        $targetFile = $targetDir . '/' . $fileName;
                        if (move_uploaded_file($tmpName, $targetFile)) {
                            $relativePath = "/project-Web2/common/images/$categoryName/$productName/$fileName";
                            $imageModel->addImageToProduct($createdProductId, $relativePath);
                            $counter++;
                        }
                        else {
                            echo "<script>
                                alert('Lỗi khi tải lên hình ảnh!');
                            </script>";
                        }
                    }
                }

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
        

        public function edit ($productId) {

            $currentPage = $_GET['current_page'] ?? 1;

            $productModel = new Product();
            // $productId = $_GET['id'] ?? null;

            $categoryModel = new Category();
            $categories = $categoryModel->getAllCategories(); 
            $categoryMap = [];
            foreach ($categories as $cat) {
                $categoryMap[$cat['MaLoai']] = $cat['TenLoai'];
            } 

            $authorModel = new Author();
            $authors = $authorModel->getAllAuthors(); 

            $publisherModel = new Publisher();
            $publishers = $publisherModel->getAllPublishers();

            $providerModel = new Provider();
            $providers = $providerModel->getAllProviders();

            $imageModel = new Image();
            $oldImages = $imageModel->getImgProduct($productId);

            if ($productId) {
                $product = $productModel->getProductById($productId);

                if (!$product) {
                    echo "<script>alert('Sản phẩm không tồn tại!');</script>";
                    return;
                }

                $this->render('product/edit', [
                    'product' => $product,
                    'categories' => $categories,
                    'authors' => $authors,
                    'publishers' => $publishers,
                    'providers' => $providers,
                    'currentPage' => $currentPage,
                    'oldImages' => $oldImages
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

                    if (!empty($_POST['delete_images'])) {
                        foreach ($_POST['delete_images'] as $deleteImageId) {
                            $img = $imageModel->getImageById($deleteImageId);
                            $absolutePath = $_SERVER['DOCUMENT_ROOT'] . $img['DgDanAnh'];
                            if (file_exists($absolutePath)) {
                                unlink($absolutePath);
                            }
                            $imageModel->deleteImageById($deleteImageId);
                        }
                    }

                    $categoryName = $categoryMap[$categoryId];
                    $projectRoot = realpath(__DIR__ . '/../../'); 
                    $targetDir   = $projectRoot . '/common/images/' . $categoryName . '/' . $productName;
                    if (!is_dir($targetDir)) {
                        mkdir($targetDir, 0777, true);
                    }
                    foreach ($_FILES['product_image']['tmp_name'] as $index => $tmpName) {

                        if ($_FILES['product_image']['error'][$index] === UPLOAD_ERR_OK) {
                            $uniqueId = uniqid();
                            $ext = pathinfo($_FILES['product_image']['name'][$index], PATHINFO_EXTENSION);
                            $fileName = $productName . '_' . $uniqueId . '.' . $ext;
                            $targetFile = $targetDir . '/' . $fileName;
                            if (move_uploaded_file($tmpName, $targetFile)) {
                                $relativePath = "/project-Web2/common/images/$categoryName/$productName/$fileName";
                                $imageModel->addImageToProduct($productId, $relativePath);
                            }
                            else {
                                echo "<script>
                                    alert('Lỗi khi tải lên hình ảnh!');
                                </script>";
                            }
                        }
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
                        'MoTaChiTiet' => $productDescription
                    ];
                    
                    $isUpdated = $productModel->updateProduct($productId, $productData);

                    if ($isUpdated) {
                        echo "<script>
                            alert('Cập nhật sản phẩm thành công!');
                            window.location.href = '?page=product&action=index&current_page=$currentPage'
                        </script>";
                        exit;
                    }
                    else {
                        echo "<script>
                            alert('Cập nhật sản phẩm thất bại!');
                            document.getElementById('product-name-input').focus();
                        </script>";
                    }
                }
            }
            else {
                echo "<script>
                    alert('ID sản phẩm không hợp lệ!');
                    window.location.href = '?page=product&action=index&current_page=$currentPage';
                </script>";
            }
        }

        public function allow() {

            $currentPage = $_GET['current_page'] ?? 1;

            $productModel = new Product();
            $productId = $_GET['id'] ?? null;

            if ($productId) {
                $product = $productModel->getProductById($productId);

                if(!$product) {
                    echo "<script>alert('Sản phẩm không tồn tại!');</script>";
                    return;
                }
                elseif ($product['TinhTrang'] == 1) {

                    $isUpdated = $productModel->updateProductStatus($productId, 0);

                    if ($isUpdated) {
                        echo "<script>
                            window.location.href = '?page=product&action=index&current_page=$currentPage';
                        </script>";
                    }
                    else {
                        echo "<script>
                            window.location.href = '?page=product&action=index&current_page=$currentPage';
                        </script>";
                    }
                }
                else {

                    $isUpdated = $productModel->updateProductStatus($productId, 1);

                    if ($isUpdated) {
                        echo "<script>
                            window.location.href = '?page=product&action=index&current_page=$currentPage';
                        </script>";
                    }
                    else {
                        echo "<script>
                            window.location.href = '?page=product&action=index&current_page=$currentPage';
                        </script>";
                    }
                }
            }
        }

        public function detail($productId) {
            
            $currentPage = $_GET['current_page'] ?? 1;

            $productModel = new Product();
            $productId = $_GET['id'] ?? null;

            $imageModel = new Image();
            $images = $imageModel->getImgProduct($productId);

            $categoryModel = new Category();
            $categories = $categoryModel->getAllCategories();
            $categoryMap = [];
            foreach ($categories as $cat) {
                $categoryMap[$cat['MaLoai']] = $cat['TenLoai'];
            } 

            $authorModel = new Author();
            $authors = $authorModel->getAllAuthors();
            $authorMap = [];
            foreach ($authors as $auth) {
                $authorMap[$auth['MaTG']] = $auth['TenTG'];
            } 

            $publisherModel = new Publisher();
            $publishers = $publisherModel->getAllPublishers();
            $publisherMap = [];
            foreach ($publishers as $pub) {
                $publisherMap[$pub['MaNXB']] = $pub['TenNXB'];
            }

            if ($productId) {
                $product = $productModel->getProductById($productId);

                if (!$product) {
                    echo "<script>alert('Sản phẩm không tồn tại!');</script>";
                    return;
                }

                $this->render('product/detail', [
                    'product' => $product,
                    'categoryMap' => $categoryMap,
                    'authorMap' => $authorMap,
                    'publisherMap' => $publisherMap,
                    'currentPage' => $currentPage,
                    'images' => $images
                ]);
            }
        }
    }
?>