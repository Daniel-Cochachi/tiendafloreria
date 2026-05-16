<?php
class CartController extends Controller {
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

        $cartModel = $this->model('Cart');

        $data = [
            'title' => 'Carrito - ' . APP_NAME,
            'items' => $cartModel->getCartByUser($_SESSION['user_id']),
            'total' => $cartModel->getCartTotal($_SESSION['user_id'])
        ];

        $this->view('cart/index', $data);
    }

    public function add($product_id) {
        if (!$this->requireLogin()) {
            return;
        }

        $cartModel = $this->model('Cart');
        $cantidad = isset($_POST['cantidad']) ? (int)$_POST['cantidad'] : 1;

        if ($cartModel->addToCart($_SESSION['user_id'], (int)$product_id, $cantidad)) {
            $_SESSION['message'] = 'Producto agregado al carrito.';
        } else {
            $_SESSION['error'] = 'No se pudo agregar: revisa stock disponible.';
        }

        header('Location: ' . app_url('cart'));
    }

    public function update($product_id) {
        if (!$this->requireLogin()) {
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cartModel = $this->model('Cart');
            $cantidad = (int)($_POST['cantidad'] ?? 0);

            if ($cartModel->updateCartItem($_SESSION['user_id'], (int)$product_id, $cantidad)) {
                $_SESSION['message'] = 'Carrito actualizado.';
            } else {
                $_SESSION['error'] = 'No se pudo actualizar: cantidad mayor al stock.';
            }
        }

        header('Location: ' . app_url('cart'));
    }

    public function remove($product_id) {
        if (!$this->requireLogin()) {
            return;
        }

        $cartModel = $this->model('Cart');
        $cartModel->removeFromCart($_SESSION['user_id'], (int)$product_id);

        $_SESSION['message'] = 'Producto removido del carrito.';
        header('Location: ' . app_url('cart'));
    }

    public function clear() {
        if (!$this->requireLogin()) {
            return;
        }

        $cartModel = $this->model('Cart');
        $cartModel->clearCart($_SESSION['user_id']);

        $_SESSION['message'] = 'Carrito vaciado.';
        header('Location: ' . app_url('cart'));
    }

    public function checkout() {
        if (!$this->requireLogin()) {
            return;
        }

        $cartModel = $this->model('Cart');
        $userModel = $this->model('User');
        $addressModel = $this->model('Address');
        $paymentModel = $this->model('PaymentMethod');
        $serviceModel = $this->model('Service');

        $items = $cartModel->getCartByUser($_SESSION['user_id']);
        $stock_errors = $cartModel->validateStock($_SESSION['user_id']);

        if (count($items) === 0) {
            $_SESSION['error'] = 'El carrito esta vacio.';
            header('Location: ' . app_url('cart'));
            return;
        }

        if ($stock_errors) {
            $_SESSION['error'] = implode(' ', $stock_errors);
            header('Location: ' . app_url('cart'));
            return;
        }

        $subtotal = $cartModel->getCartTotal($_SESSION['user_id']);
        $shipping = 8.00;

        $data = [
            'title' => 'Checkout - ' . APP_NAME,
            'user' => $userModel->getUserById($_SESSION['user_id']),
            'items' => $items,
            'addresses' => $addressModel->getAddressesByUser($_SESSION['user_id']),
            'payment_methods' => $paymentModel->getActiveMethods(),
            'services' => $serviceModel->getActiveServices(),
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'total' => $subtotal + $shipping
        ];

        $this->view('cart/checkout', $data);
    }

    public function processOrder() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$this->requireLogin()) {
            return;
        }

        $cartModel = $this->model('Cart');
        $orderModel = $this->model('Order');
        $addressModel = $this->model('Address');
        $paymentModel = $this->model('PaymentMethod');
        $serviceModel = $this->model('Service');
        $couponModel = $this->model('Coupon');

        $items = $cartModel->getCartByUser($_SESSION['user_id']);
        $subtotal = $cartModel->getCartTotal($_SESSION['user_id']);

        if (!$items) {
            $_SESSION['error'] = 'El carrito esta vacio.';
            header('Location: ' . app_url('cart'));
            return;
        }

        $stock_errors = $cartModel->validateStock($_SESSION['user_id']);
        if ($stock_errors) {
            $_SESSION['error'] = implode(' ', $stock_errors);
            header('Location: ' . app_url('cart'));
            return;
        }

        $direccion_id = (int)($_POST['direccion_id'] ?? 0);
        if (!$addressModel->belongsToUser($direccion_id, $_SESSION['user_id'])) {
            $_SESSION['error'] = 'Selecciona una direccion valida.';
            header('Location: ' . app_url('cart/checkout'));
            return;
        }

        $metodo_pago_id = (int)($_POST['metodo_pago_id'] ?? 0);
        if (!$paymentModel->getById($metodo_pago_id)) {
            $_SESSION['error'] = 'Selecciona un metodo de pago valido.';
            header('Location: ' . app_url('cart/checkout'));
            return;
        }

        $services = $serviceModel->getByIds($_POST['servicios'] ?? []);
        $services_total = array_reduce($services, function ($total, $service) {
            return $total + (float)$service['precio'];
        }, 0.0);

        $coupon = null;
        $discount = 0;
        $coupon_code = trim($_POST['cupon'] ?? '');

        if ($coupon_code !== '') {
            $coupon = $couponModel->getActiveByCode($coupon_code);
            $coupon_result = $couponModel->calculateDiscount($coupon, $subtotal);

            if (!$coupon_result['valid']) {
                $_SESSION['error'] = $coupon_result['message'];
                header('Location: ' . app_url('cart/checkout'));
                return;
            }

            $discount = $coupon_result['discount'];
        }

        $shipping = 8.00;
        $total = max(0, $subtotal + $services_total + $shipping - $discount);

        $order_data = [
            'usuario_id' => $_SESSION['user_id'],
            'subtotal' => $subtotal,
            'descuento_total' => $discount,
            'costo_envio' => $shipping,
            'total' => $total,
            'direccion_id' => $direccion_id,
            'metodo_pago_id' => $metodo_pago_id,
            'notas_especiales' => trim($_POST['notas'] ?? ''),
            'fecha_entrega_solicitada' => $_POST['fecha_entrega'] ?? null
        ];

        $orden_id = $orderModel->createOrderFromCart($order_data, $items, $services, $coupon);

        if ($orden_id) {
            $cartModel->clearCart($_SESSION['user_id']);
            $_SESSION['message'] = 'Orden creada exitosamente.';
            header('Location: ' . app_url('orders/detail/' . $orden_id));
            return;
        }

        $_SESSION['error'] = $orderModel->getLastError() ?: 'Error al crear la orden.';
        header('Location: ' . app_url('cart/checkout'));
    }
}
