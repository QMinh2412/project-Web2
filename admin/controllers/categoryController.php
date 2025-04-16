<?php
    require_once __DIR__ . '/../../common/core/BaseController.php';
    require_once __DIR__ . '/../../common/models/Category.php';

    class CategoryController extends BaseController {
        public function index() {
            // Gọi view tương ứng với action index
            $categoryModel = new Category();
            $categories = $categoryModel->getAllCategories(); // Giả sử bạn có phương thức này trong model

            $this->render('category/index', [
                'categories' => $categories
            ]);
        }

        public function create() {
            $categoryModel = new Category();

            $this->render('category/create', []);

            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $newCategoryName = $_POST['category_name'] ?? null;

                if ($newCategoryName) {
                    $existingCategory = $categoryModel->getCategoryByName($newCategoryName);
                    if ($existingCategory) {
                        echo "<script>
                            alert('Thể loại đã tồn tại, vui lòng thử lại!');
                            document.getElementById('category_name').focus();
                        </script>";
                    } else {
                        // Add the new category
                        $isAdded = $categoryModel->addCategory($newCategoryName);
                
                        if ($isAdded) {
                            echo "<script>
                                alert('Thể loại đã được thêm thành công!');
                                window.location.href = '?page=category&action=index';
                            </script>";
                        } else {
                            echo "<script>
                                alert('Không thể thêm thể loại, vui lòng thử lại!');
                                document.getElementById('category_name').focus();
                            </script>";
                        }
                    }
                } else {
                    // If no category name is provided, alert and focus on the input box
                    echo "<script>
                        alert('Vui lòng nhập tên thể loại!');
                        document.getElementById('category_name').focus();
                    </script>";
                }
            }
        }

        public function edit() {
            $categoryModel = new Category();
            $categoryId = $_GET['id'] ?? null;

            if ($categoryId) {
                $category = $categoryModel->getCategoryById($categoryId);

                if (!$category) {
                    echo "<script>alert('Danh mục không tồn tại!');</script>";
                    return;
                }

                $this->render('category/edit', [
                    'category' => $category
                ]);

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $newCategoryName = $_POST['category_name'] ?? null;

                    if ($newCategoryName) {
                        // Update the category name
                        $isUpdated = $categoryModel->updateCategory($categoryId, $newCategoryName);
                
                        if ($isUpdated) {
                            echo "<script>
                                alert('Thể loại đã được cập nhật thành công!');
                                window.location.href = '?page=category&action=index';
                            </script>";
                        } else {
                            echo "<script>
                                alert('Không thể cập nhật thể loại, vui lòng thử lại!');
                                document.getElementById('category_name').focus();
                            </script>";
                        }
                    } else {
                        // If no category name is provided, alert and focus on the input box
                        echo "<script>
                            alert('Vui lòng nhập tên thể loại!');
                            document.getElementById('category_name').focus();
                        </script>";
                    }
                }
            } else {
                echo "<script>
                    alert('ID danh mục không hợp lệ!');
                    window.location.href = '?page=category&action=index';
                </script>";
            }
        }

        public function delete() {
            $categoryModel = new Category();
            $categoryId = $_GET['id'] ?? null;

            if ($categoryId) {
                $isDeleted = $categoryModel->deleteCategory($categoryId);

                if ($isDeleted) {
                    echo "<script>
                        alert('Thể loại đã được xóa thành công!');
                        window.location.href = '?page=category&action=index';
                    </script>";
                } else {
                    echo "<script>alert('Không thể xóa thể loại, vui lòng thử lại!');</script>";
                }
            } else {
                echo "<script>alert('ID danh mục không hợp lệ!');</script>";
            }
        }

       
    }
?>