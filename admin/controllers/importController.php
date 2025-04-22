<?php
    require_once __DIR__ . '/../../common/core/BaseController.php';
    require_once __DIR__ . '/../../common/models/Import.php';
    require_once __DIR__ . '/../../common/models/product.php';

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

            $imports = $importModel->getFilteredImport($currentPage, $importsPerPage, $importId, $status, $fromDate, $toDate);
            $pagination = $importModel->getImportPaginationFiltered($currentPage, $importsPerPage, $importId, $status, $fromDate, $toDate);
            
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

            $providers = $providerModel->getAllProviders();
            $products = $productModel->getAllProductsWithoutPagination();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $importProvider = $_POST['import_provider'] ?? '';
                $importProfit = $_POST['importprofit'] ?? 0;

                exit;
            }

            $this->render('import/create', [
                'providers' => $providers,
                'products' => $products
            ]);
        }
    }
?>