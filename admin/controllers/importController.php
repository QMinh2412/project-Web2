<?php
    require_once __DIR__ . '/../../common/core/BaseController.php';
    require_once __DIR__ . '/../../common/models/Import.php';
    require_once __DIR__ . '/../../common/models/ImportDetail.php';
    require_once __DIR__ . '/../../common/models/Product.php';

    class ImportController extends BaseController {
        public function index($currentPage) {
            $importModel = new Import();
            $productModel = new Product();
            $providerModel = new Provider();

            $providers = $providerModel->getAllProviders();

            $importsPerPage = 10;
            $importId = $_GET['import_id'] ?? '';
            $status = $_GET['import_status'] ?? '';
            $fromDate = $_GET['import_from_date'] ?? '';
            $toDate = $_GET['import_to_date'] ?? '';
            $importProduct = $_GET['import_product'] ?? '';
            $importProvider = $_GET['import_provider'] ?? '';
            
            $imports = $importModel->getFilteredImport($currentPage, $importsPerPage, $importId, $status, $fromDate, $toDate, $importProduct, $importProvider);

            $pagination = $importModel->getImportPaginationFiltered($currentPage, $importsPerPage, $importId, $status, $fromDate, $toDate, $importProduct, $importProvider);

            
            $providerMap = [];
            foreach ($providers as $prov) {
                $providerMap[$prov['MaNCC']] = $prov['TenNCC']; 
            }

            $this->render('import/index', [
                'imports' => $imports,
                'pagination' => $pagination,
                'providerMap' => $providerMap
            ]);
        }

        public function changeStatus() {
            $currentPage = $_GET['current_page'] ?? 1;
            $importId = $_GET['id'] ?? null;
            $newStatus = $_GET['status'] ?? 1;

            $importModel = new Import();

            if ($importId) {
                $import = $importModel->getImportById($importId);

                if (!$import) {
                    echo "<script>alert('Phiếu nhập không tồn tại!');</script>";
                    return;
                }

                $isUpdated = $importModel->changeImportStatusById($importId, $newStatus);

                if ($isUpdated) {
                    echo "<script>
                        alert('Đã cập nhật thành công trạng thái phiếu nhập');
                        window.location.href = '?page=import&action=index&current_page=$currentPage';
                    </script>";
                }
                else {
                    echo "<script>
                        alert('Cập nhật không thành công');
                        window.location.href = '?page=import&action=index&current_page=$currentPage';
                    </script>"; 
                }
            }
        }

        public function create() {
            $importModel = new Import();
            $productModel = new Product();
            $providerModel = new Provider();
            $categoryModel = new Category();
            $providerId = $_GET['import_provider'] ?? null;
        
            $provider = $providerModel->getProviderById($providerId);
            $products = $productModel->getProductsByProvider($providerId);
            $categories = $categoryModel->getAllCategories();
        
            // Map Category (MaLoai => TenLoai) để hiển thị tên thể loại
            $categoryMap = [];
            foreach ($categories as $cat) {
                $categoryMap[$cat['MaLoai']] = $cat['TenLoai'];
            }
            $profit = $_GET['importprofit'] ?? 0; // lấy lợi nhuận gửi lên từ form trước đó
        
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $providerId = $_POST['import_provider'] ?? null;
                $profit = $_POST['import_profit'] ?? 0;
                $books = $_POST['books'] ?? [];
        
                if ($providerId && !empty($books)) {
                    // 1. Tính tổng tiền
                    $tongTien = 0;
                    foreach ($books as $book) {
                        $tongTien += (int)$book['price'] * (int)$book['quantity'];
                    }
        
                    // 2. Tạo phiếu nhập mới
                    $importId = $importModel->createImport([
                        'MaNCC' => $providerId,
                        'MaTK' => $_SESSION['user_id'] ?? 1, // fallback nếu chưa có session
                        'NgayNhap' => date('Y-m-d'),
                        'TongTien' => $tongTien
                    ]);
        
                    // 3. Lưu chi tiết phiếu nhập + cập nhật sản phẩm
                    foreach ($books as $book) {
                        $bookId = (int)$book['id'];
                        $quantity = (int)$book['quantity'];
                        $price = (int)$book['price'];
        
                        // 3.1. Thêm chi tiết phiếu nhập
                        $importModel->addImportDetail($importId, $bookId, $quantity, $price);
        
                        // 3.2. Lấy thông tin sản phẩm hiện tại
                        $product = $productModel->getProductById($bookId);
        
                        if ($product) {
                            $currentPrice = (int)$product['GiaBan'];
                            $currentQuantity = (int)$product['SoLgTon'];
        
                            $newQuantity = $currentQuantity + $quantity;
        
                            // Tính giá bán mới theo lợi nhuận
                            $discountRate = $profit / 100; // profit là % lợi nhuận
                            $newSellingPrice = (int)($price * (1 / (1 - $discountRate)));
        
                            // Nếu giá bán mới > giá bán cũ thì cập nhật
                            $finalSellingPrice = $newSellingPrice > $currentPrice ? $newSellingPrice : $currentPrice;
        
                            // 3.3. Update sản phẩm
                            $productModel->updateProductAfterImport($bookId, $finalSellingPrice, $newQuantity);
                        }
                    }
        
                    // 4. Chuyển hướng
                    header('Location: index.php?page=import&action=index');
                    exit;
                } else {
                    echo "Thiếu thông tin phiếu nhập.";
                }
                return; // không render view nữa sau khi submit
            }
        
            $this->render('import/create', [
                'provider' => $provider,
                'products' => $products,
                'categoryMap' => $categoryMap,
                'profit' => $profit,
            ]);
        }
        
        
        public function detail() {
            $currentPage = $_GET['current_page'] ?? 1;
            $importId = $_GET['id'] ?? null;

            $importModel = new Import();
            $providerModel = new Provider();
            $importDetailModel = new ImportDetail();
            
            $import = $importModel->getImportById($importId);
            $providerId = $import['MaNCC'];
            $provider = $providerModel->getProviderById($providerId);
            $details = $importDetailModel->getImportDetailById($importId);

            $this->render('import/detail', [
                'import' => $import,
                'details' => $details,
                'provider' => $provider,
                'currentPage' => $currentPage
            ]);
        }
    }
?>