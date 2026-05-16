<?php
class DashboardController extends Controller {
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

        $userModel = $this->model('User');
        $orderModel = $this->model('Order');
        $favoriteModel = $this->model('Favorite');

        $favorites = $favoriteModel->getFavoritesByUser($_SESSION['user_id']);

        $data = [
            'title' => 'Mi Cuenta - ' . APP_NAME,
            'user' => $userModel->getUserById($_SESSION['user_id']),
            'recent_orders' => $orderModel->getOrdersByUser($_SESSION['user_id']),
            'favorites_count' => count($favorites)
        ];

        $this->view('dashboard/index', $data);
    }
}
