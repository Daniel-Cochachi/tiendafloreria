<?php
class OrdersController extends Controller {
    private function requireLogin() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . app_url('user/login'));
            return false;
        }

        return true;
    }

    public function index() {
        if (!$this->requireLogin()) {
            return;
        }

        $orderModel = $this->model('Order');

        $data = [
            'title' => 'Mis Pedidos - ' . APP_NAME,
            'orders' => $orderModel->getOrdersByUser($_SESSION['user_id'])
        ];

        $this->view('orders/index', $data);
    }

    public function detail($id) {
        if (!$this->requireLogin()) {
            return;
        }

        $orderModel = $this->model('Order');
        $order = $orderModel->getOrderById($id);

        if (!$order || ((int)$order['usuario_id'] !== (int)$_SESSION['user_id'] && ($_SESSION['user_rol'] ?? '') !== 'admin')) {
            http_response_code(404);
            echo "Orden no encontrada";
            return;
        }

        $data = [
            'title' => 'Orden #' . $order['numero_orden'] . ' - ' . APP_NAME,
            'order' => $order,
            'details' => $orderModel->getOrderDetails($id),
            'services' => $orderModel->getOrderServices($id)
        ];

        $this->view('orders/detail', $data);
    }

    public function cancel($id) {
        if (!$this->requireLogin()) {
            return;
        }

        $orderModel = $this->model('Order');

        if ($orderModel->cancelOrder((int)$id, $_SESSION['user_id'])) {
            $_SESSION['message'] = 'Orden cancelada exitosamente.';
        } else {
            $_SESSION['error'] = $orderModel->getLastError() ?: 'No se pudo cancelar esta orden.';
        }

        header('Location: ' . app_url('orders/detail/' . (int)$id));
    }
}
