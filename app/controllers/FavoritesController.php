<?php
class FavoritesController extends Controller {
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

        $favoriteModel = $this->model('Favorite');

        $data = [
            'title' => 'Favoritos - ' . APP_NAME,
            'favorites' => $favoriteModel->getFavoritesByUser($_SESSION['user_id'])
        ];

        $this->view('favorites/index', $data);
    }

    public function add($product_id) {
        if (!$this->requireLogin()) {
            return;
        }

        $favoriteModel = $this->model('Favorite');

        if ($favoriteModel->addFavorite($_SESSION['user_id'], (int)$product_id)) {
            $_SESSION['message'] = 'Producto agregado a favoritos.';
        } else {
            $_SESSION['error'] = 'No se pudo agregar a favoritos.';
        }

        header('Location: ' . app_url('favorites'));
    }

    public function remove($product_id) {
        if (!$this->requireLogin()) {
            return;
        }

        $favoriteModel = $this->model('Favorite');
        $favoriteModel->removeFavorite($_SESSION['user_id'], (int)$product_id);

        $_SESSION['message'] = 'Producto removido de favoritos.';
        header('Location: ' . app_url('favorites'));
    }
}
