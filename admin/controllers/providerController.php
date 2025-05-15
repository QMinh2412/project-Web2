<?php
    require_once __DIR__ . '/../../common/core/BaseController.php';
    require_once __DIR__ . '/../../common/models/Provider.php';

    class ProviderController extends BaseController {
        public function index() {
            $currentPage = isset($_GET['current_page']) ? (int)$_GET['current_page'] : 1;

            $providerModel = new Provider();

            $providersPerPage = 10;

            $providers = $providerModel->getAllProvidersWithPagination($currentPage, $providersPerPage);
            $pagination = $providerModel->getPagination($currentPage, $providersPerPage);

            $this->render('provider/index', [
                'providers' => $providers,
                'pagination'  => $pagination
            ]);
        }

        public function create() {
            $providerModel = new Provider();

            $this->render('provider/create', []);

            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $providerName = trim(strip_tags($_POST['provider_name']));
                $providerAddress = trim(strip_tags($_POST['provider_address'])) ?? null;
                $providerEmail = filter_var(filter_var($_POST['provider_email'], FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL) ?? null;

                if ($providerName) {
                    $existingProvider = $providerModel->getProviderByName($providerName);
                    if ($existingProvider) {
                        echo "<script>
                            alert('Nhà cung cấp đã tồn tại, vui lòng thử lại!');
                            document.getElementById('provider_name').focus();
                        </script>";
                    } else {
                        // Add the new provider
                        $providerData = [
                            'TenNCC' => $providerName,
                            'DcNCC' => $providerAddress,
                            'EmailNCC' => $providerEmail
                        ];
                        $isAdded = $providerModel->createProvider($providerData);
                
                        if ($isAdded) {
                            echo "<script>
                                alert('Nhà cung cấp đã được thêm thành công!');
                                window.location.href = '?page=provider&action=index';
                            </script>";
                        } else {
                            echo "<script>
                                alert('Không thể thêm nhà cung cấp, vui lòng thử lại!');
                                document.getElementById('provider_name').focus();
                            </script>";
                        }
                    }
                } else {
                    // If no provider name is provided, alert and focus on the input box
                    echo "<script>
                        alert('Vui lòng nhập tên nhà cung cấp!');
                        document.getElementById('provider_name').focus();
                    </script>";
                }
            }
        }

        public function edit() {
            $providerModel = new Provider();

            $providerId = $_GET['id'] ?? null;

            $currentPage = $_GET['current_page'] ?? 1;

            if ($providerId) {
                $provider = $providerModel->getProviderById($providerId);

                if (!$provider) {
                    echo "<script>alert('Nhà cung cấp không tồn tại!');</script>";
                    return;
                }

                $this->render('provider/edit', [
                    'provider' => $provider,
                    'currentPage' => $currentPage
                ]);

                if($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $providerName = trim(strip_tags($_POST['provider_name']));
                    $providerAddress = trim(strip_tags($_POST['provider_address'])) ?? null;
                    $providerEmail = filter_var(filter_var($_POST['provider_email'], FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL) ?? null;

                    if ($providerName) {
                        $existingProvider = $providerModel->getProviderByName($providerName);
                        if ($existingProvider) {
                            echo "<script>
                                alert('Nhà cung cấp đã tồn tại, vui lòng thử lại!');
                                document.getElementById('provider_name').focus();
                            </script>";
                        } else {
                            // Add the new provider
                            $providerData = [
                                'TenNCC' => $providerName,
                                'DcNCC' => $providerAddress,
                                'EmailNCC' => $providerEmail
                            ];
                            $isAdded = $providerModel->updateProvider($providerId, $providerData);
                    
                            if ($isAdded) {
                                echo "<script>
                                    alert('Nhà cung cấp đã được cập nhật thành công!');
                                    window.location.href = '?page=provider&action=index';
                                </script>";
                            } else {
                                echo "<script>
                                    alert('Không thể cập nhật nhà cung cấp, vui lòng thử lại!');
                                    document.getElementById('provider_name').focus();
                                </script>";
                            }
                        }
                    } else {
                        // If no provider name is provided, alert and focus on the input box
                        echo "<script>
                            alert('Vui lòng nhập tên nhà cung cấp!');
                            document.getElementById('provider_name').focus();
                        </script>";
                    }
                }
            }
            else {
                echo "<script>
                    alert('ID nhà cung cấp không hợp lệ!');
                    window.location.href = '?page=provider&action=index&current_page=$currentPage';
                </script>";
            }
        }

        public function detail() {
            $currentPage = $_GET['current_page'] ?? 1;
            $providerModel = new Provider();
            $providerId = $_GET['id'] ?? null;

            if ($providerId) {
                $provider = $providerModel->getProviderById($providerId);

                if (!$provider) {
                    echo "<script>alert('Nhà cung cấp không tồn tại!');</script>";
                    return;
                }

                $this->render('provider/detail', [
                    'provider' => $provider,
                    'currentPage' => $currentPage
                ]);
            }
        }

        public function delete() {
            $currentPage = $_GET['current_page'] ?? 1;
            $providerModel = new Provider();
            $providerId = $_GET['id'] ?? null;

            $importModel = new Import();

            if ($providerId) {
                $existsProviderInImport = $importModel->checkProviderExistsInImport($providerId);

                if (!$existsProviderInImport) {
                    $isDeleted = $providerModel->deleteProviderFromDatabase($providerId);
                }
                else {
                    $isDeleted = $providerModel->deleteProvider($providerId);
                }


                if ($isDeleted) {
                    echo "<script>
                        alert('Nhà cung cấp đã được xóa thành công!');
                        window.location.href = '?page=provider&action=index&current_page=$currentPage'
                    </script>";
                }
                else {
                    echo "<script>alert('Không thể xóa nhà cung cấp, vui lòng thử lại!');</script>";
                }
            }
            else {
                echo "<script>alert('ID nhà cung cấp không hợp lệ!')</script>";
            }
        }
    }
?>