<?php
    require_once __DIR__ . '/../../common/core/BaseController.php';
    require_once __DIR__ . '/../../common/models/Order.php';

    class OrderController extends BaseController {

        public function index($currentPage) {
            $orderModel = new Order();
            $userModel = new User();
            $users = $userModel->getAllUsers();

            $ordersPerPage = 10;
            $firstOrder = $ordersPerPage * $currentPage - 9;

            $orderId = $_GET['order_id'] ?? '';
            $status = $_GET['order_status'] ?? '';
            $fromDate = $_GET['order_from_date'] ?? '';
            $toDate = $_GET['order_to_date'] ?? '';

            $orders = $orderModel->getFilteredOrders($currentPage, $ordersPerPage, $orderId, $status, $fromDate, $toDate);
            $pagination = $orderModel->getOrderPaginationFiltered($currentPage, $ordersPerPage, $orderId, $status, $fromDate, $toDate);

            $userMap = [];
            foreach ($users as $us) {
                $userMap[$us['MaND']] = $us['TenND'];
            }

            $this->render('order/index', [
                'firstOrder' => $firstOrder,
                'orders' => $orders,
                'userMap' => $userMap,
                'pagination' => $pagination
            ]);
        }

        public function detail($orderId) {
            $orderModel = new Order();
            $userModel = new User();

            $currentPage = $_GET['current_page'] ?? 1;

            $order = $orderModel->getOrderById($orderId);
            $userId = $order['MaKH'];
            $user = $userModel->getById($userId);

            $orderDetailModel = new OrderDetail();
            $details = $orderDetailModel->getOrderDetailsByOrderId($orderId);

            $this->render('order/detail', [
                'order' => $order,
                'details' => $details,
                'user' => $user,
                'currentPage' => $currentPage
            ]);
        }

        public function changeStatus() {
            $currentPage = $_GET['current_page'] ?? 1;
            $orderId = $_GET['id'] ?? null;
            $newStatus = $_GET['status'] ?? 1;

            $orderModel = new Order();

            if ($orderId) {
                $order = $orderModel->getOrderById($orderId);

                if(!$order) {
                    echo "<script>alert('Đơn hàng không tồn tại!');</script>";
                    return;
                }

                $isUpdated = $orderModel->changeOrderStatusById($orderId, $newStatus);

                if ($isUpdated) {
                    echo "<script>
                        alert('Đã cập nhật thành công trạng thái đơn hàng');
                        window.location.href = '?page=order&action=index&current_page=$currentPage';
                    </script>";
                }
                else {
                    echo "<script>
                        alert('Cập nhật không thành công');
                        window.location.href = '?page=order&action=index&current_page=$currentPage';
                    </script>"; 
                }
            }
        }
    }
?>