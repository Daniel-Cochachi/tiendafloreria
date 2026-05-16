<?php
class ProductsController extends Controller {
    public function index() {
        $productModel = $this->model('Product');
        $categoryModel = $this->model('Category');

        $page = max(1, isset($_GET['page']) ? (int)$_GET['page'] : 1);
        $per_page = 12;
        $offset = ($page - 1) * $per_page;
        $categoria_id = isset($_GET['category']) ? (int)$_GET['category'] : null;

        if ($categoria_id) {
            $products = $productModel->getProductsByCategory($categoria_id, $per_page, $offset);
        } else {
            $products = $productModel->getAllProducts($per_page, $offset);
        }

        $data = [
            'title' => 'Productos - ' . APP_NAME,
            'products' => $products,
            'categories' => $categoryModel->getAllCategories(),
            'current_category' => $categoria_id,
            'page' => $page
        ];

        $this->view('products/list', $data);
    }

    public function detail($id) {
        $productModel = $this->model('Product');
        $reviewModel = $this->model('Review');
        $favoriteModel = $this->model('Favorite');

        $product = $productModel->getProductById($id);

        if (!$product) {
            http_response_code(404);
            echo "Producto no encontrado";
            return;
        }

        $data = [
            'title' => $product['nombre'] . ' - ' . APP_NAME,
            'product' => $product,
            'reviews' => $reviewModel->getReviewsByProduct($id),
            'rating' => $reviewModel->getProductRating($id),
            'related' => $productModel->getProductsByCategory($product['categoria_id'], 4, 0),
            'is_favorite' => isset($_SESSION['user_id'])
                ? $favoriteModel->isFavorite($_SESSION['user_id'], $id)
                : false
        ];

        $this->view('products/detail', $data);
    }

    public function search() {
        $productModel = $this->model('Product');

        $search = isset($_GET['q']) ? trim($_GET['q']) : '';
        $products = strlen($search) >= 2 ? $productModel->searchProducts($search) : [];

        $data = [
            'title' => 'Busqueda - ' . APP_NAME,
            'products' => $products,
            'search_term' => $search
        ];

        $this->view('products/search', $data);
    }

    public function addReview($product_id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . app_url('user/login'));
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rating = (int)($_POST['calificacion'] ?? 0);

            if ($rating < 1 || $rating > 5) {
                $_SESSION['error'] = 'Selecciona una calificacion valida.';
                header('Location: ' . app_url('products/detail/' . (int)$product_id));
                return;
            }

            $reviewModel = $this->model('Review');

            $data = [
                'usuario_id' => $_SESSION['user_id'],
                'producto_id' => (int)$product_id,
                'calificacion' => $rating,
                'titulo' => trim($_POST['titulo'] ?? ''),
                'comentario' => trim($_POST['comentario'] ?? '')
            ];

            if ($reviewModel->addReview($data)) {
                $_SESSION['message'] = 'Resena agregada, espera aprobacion.';
            } else {
                $_SESSION['error'] = 'Error al agregar la resena.';
            }
        }

        header('Location: ' . app_url('products/detail/' . (int)$product_id));
    }

    public function addToFavorite($product_id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . app_url('user/login'));
            return;
        }

        $favoriteModel = $this->model('Favorite');

        if ($favoriteModel->addFavorite($_SESSION['user_id'], (int)$product_id)) {
            $_SESSION['message'] = 'Producto agregado a favoritos.';
        } else {
            $_SESSION['error'] = 'No se pudo agregar a favoritos.';
        }

        header('Location: ' . app_url('products/detail/' . (int)$product_id));
    }

    public function removeFavorite($product_id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . app_url('user/login'));
            return;
        }

        $favoriteModel = $this->model('Favorite');
        $favoriteModel->removeFavorite($_SESSION['user_id'], (int)$product_id);

        $_SESSION['message'] = 'Producto removido de favoritos.';
        header('Location: ' . app_url('products/detail/' . (int)$product_id));
    }
}
