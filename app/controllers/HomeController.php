<?php
class HomeController extends Controller {
    public function index() {
        $productModel = $this->model('Product');
        $categoryModel = $this->model('Category');
        $settingModel = $this->model('Setting');

        $latest = $productModel->getAllProducts(8);
        $bestSelling = $productModel->getBestSelling(8);
        $featured = $productModel->getFeaturedProducts(8);
        $categories = $categoryModel->getAllCategories();
        $activeCampaign = $settingModel->getActiveCampaign();

        // If no featured (discounted) products, use latest as fallback
        if (empty($featured)) {
            $featured = $latest;
        }

        $cartCount = 0;
        if (isset($_SESSION['user_id'])) {
            $cartModel = $this->model('Cart');
            $cartCount = $cartModel->getCartItemCount($_SESSION['user_id']);
        }

        $data = [
            'title' => 'Inicio - ' . APP_NAME,
            'description' => 'Bienvenido a nuestra tienda de flores',
            'featured_products' => $latest,
            'best_selling' => $bestSelling,
            'on_sale' => $featured,
            'categories' => $categories,
            'cartCount' => $cartCount,
            'campaign' => $activeCampaign
        ];
        $this->view('home', $data);
    }
}
