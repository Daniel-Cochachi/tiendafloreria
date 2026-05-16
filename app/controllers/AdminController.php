<?php
class AdminController extends Controller {
    private function requireAdmin() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . app_url('user/login'));
            return false;
        }

        if (($_SESSION['user_rol'] ?? '') !== 'admin') {
            http_response_code(403);
            echo "Acceso denegado";
            return false;
        }

        return true;
    }

    public function index() {
        if (!$this->requireAdmin()) {
            return;
        }

        $orderModel = $this->model('Order');
        $productModel = $this->model('Product');
        $reviewModel = $this->model('Review');
        $userModel = $this->model('User');

        $orders = $orderModel->getAllOrders();

        $stats = $orderModel->getDashboardStats();
        $stats['repartidores_activos'] = $userModel->countUsers('repartidor');

        $data = [
            'title' => 'Admin - ' . APP_NAME,
            'stats' => $stats,
            'low_stock' => $productModel->getProductsWithLowStock(),
            'pending_reviews' => $reviewModel->getPendingReviews(),
            'recent_orders' => array_slice($orders, 0, 8),
            'total_products' => $productModel->countActiveProducts(),
            'total_clients' => $userModel->countUsers('cliente')
        ];

        $this->view('admin/index', $data);
    }

    public function products() {
        if (!$this->requireAdmin()) {
            return;
        }

        $productModel = $this->model('Product');
        $categoryModel = $this->model('Category');

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $per_page = 10;
        $offset = ($page - 1) * $per_page;

        $total_products = $productModel->countAllProducts();
        $total_pages = ceil($total_products / $per_page);

        $data = [
            'title' => 'Admin Productos - ' . APP_NAME,
            'products' => $productModel->getProductsForAdmin($per_page, $offset),
            'categories' => $categoryModel->getAllCategories(),
            'current_page' => $page,
            'total_pages' => $total_pages,
            'pagination_base_url' => 'admin/products'
        ];

        $this->view('admin/products', $data);
    }

    public function saveProduct($id = null) {
        if (!$this->requireAdmin() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $productModel = $this->model('Product');

        $data = [
            'categoria_id' => $_POST['categoria_id'] ?? 0,
            'nombre' => $_POST['nombre'] ?? '',
            'descripcion' => $_POST['descripcion'] ?? '',
            'precio_unitario' => $_POST['precio_unitario'] ?? 0,
            'descuento_porcentaje' => $_POST['descuento_porcentaje'] ?? 0,
            'precio_final' => $_POST['precio_final'] ?? '',
            'imagen_principal' => $_POST['imagen_principal'] ?? '',
            'stock' => $_POST['stock'] ?? 0,
            'stock_minimo' => $_POST['stock_minimo'] ?? 10,
            'tipo_producto' => $_POST['tipo_producto'] ?? 'flor_individual',
            'codigo_sku' => $_POST['codigo_sku'] ?? '',
            'duracion_dias' => $_POST['duracion_dias'] ?? 10,
            'cuidados' => $_POST['cuidados'] ?? '',
            'estado' => $_POST['estado'] ?? 'activo'
        ];

        $ok = $id ? $productModel->updateProduct((int)$id, $data) : $productModel->addProduct($data);
        $_SESSION[$ok ? 'message' : 'error'] = $ok ? 'Producto guardado.' : 'No se pudo guardar el producto.';

        header('Location: ' . app_url('admin/products'));
    }

    public function deleteProduct($id) {
        if (!$this->requireAdmin()) {
            return;
        }

        $productModel = $this->model('Product');
        $productModel->deleteProduct((int)$id);
        $_SESSION['message'] = 'Producto desactivado.';
        header('Location: ' . app_url('admin/products'));
    }

    public function orders() {
        if (!$this->requireAdmin()) {
            return;
        }

        $orderModel = $this->model('Order');

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $per_page = 10;
        $offset = ($page - 1) * $per_page;

        $total_orders = $orderModel->countAllOrders();
        $total_pages = ceil($total_orders / $per_page);

        $data = [
            'title' => 'Admin Pedidos - ' . APP_NAME,
            'orders' => $orderModel->getAllOrders($per_page, $offset),
            'current_page' => $page,
            'total_pages' => $total_pages,
            'pagination_base_url' => 'admin/orders'
        ];

        $this->view('admin/orders', $data);
    }

    public function updateOrder($id) {
        if (!$this->requireAdmin() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $orderModel = $this->model('Order');
        $ok = $orderModel->updateOrderAndPayment((int)$id, $_POST['estado_orden'], $_POST['estado_pago']);
        $_SESSION[$ok ? 'message' : 'error'] = $ok ? 'Pedido actualizado.' : 'No se pudo actualizar el pedido.';
        header('Location: ' . app_url('admin/orders'));
    }

    public function reviews() {
        if (!$this->requireAdmin()) {
            return;
        }

        $reviewModel = $this->model('Review');

        $data = [
            'title' => 'Admin Resenas - ' . APP_NAME,
            'reviews' => $reviewModel->getPendingReviews()
        ];

        $this->view('admin/reviews', $data);
    }

    public function approveReview($id) {
        if (!$this->requireAdmin()) {
            return;
        }

        $reviewModel = $this->model('Review');
        $reviewModel->approveReview((int)$id);
        $_SESSION['message'] = 'Resena aprobada.';
        header('Location: ' . app_url('admin/reviews'));
    }

    public function rejectReview($id) {
        if (!$this->requireAdmin()) {
            return;
        }

        $reviewModel = $this->model('Review');
        $reviewModel->rejectReview((int)$id);
        $_SESSION['message'] = 'Resena rechazada.';
        header('Location: ' . app_url('admin/reviews'));
    }

    public function coupons() {
        if (!$this->requireAdmin()) {
            return;
        }

        $couponModel = $this->model('Coupon');

        $data = [
            'title' => 'Admin Cupones - ' . APP_NAME,
            'coupons' => $couponModel->getAllCoupons()
        ];

        $this->view('admin/coupons', $data);
    }

    public function saveCoupon() {
        if (!$this->requireAdmin() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $couponModel = $this->model('Coupon');
        $data = $_POST;
        $data['usuario_id_creador'] = $_SESSION['user_id'];

        $ok = $couponModel->addCoupon($data);
        $_SESSION[$ok ? 'message' : 'error'] = $ok ? 'Cupon creado.' : 'No se pudo crear el cupon.';
        header('Location: ' . app_url('admin/coupons'));
    }

    public function deleteCoupon($id) {
        if (!$this->requireAdmin()) return;
        $db = (new Database())->connect();
        $query = "UPDATE cupones SET estado = 'inactivo' WHERE id = :id";
        $stmt = $db->prepare($query);
        $ok = $stmt->execute([':id' => (int)$id]);
        $_SESSION[$ok ? 'message' : 'error'] = $ok ? 'Cupón desactivado.' : 'Error al desactivar.';
        header('Location: ' . app_url('admin/coupons'));
    }

    public function activateCoupon($id) {
        if (!$this->requireAdmin()) return;
        $db = (new Database())->connect();
        $query = "UPDATE cupones SET estado = 'activo' WHERE id = :id";
        $stmt = $db->prepare($query);
        $ok = $stmt->execute([':id' => (int)$id]);
        $_SESSION[$ok ? 'message' : 'error'] = $ok ? 'Cupón activado.' : 'Error al activar.';
        header('Location: ' . app_url('admin/coupons'));
    }

    public function users() {
        if (!$this->requireAdmin()) {
            return;
        }

        $userModel = $this->model('User');

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $per_page = 10;
        $offset = ($page - 1) * $per_page;

        $total_users = $userModel->countUsers();
        $total_pages = ceil($total_users / $per_page);

        $data = [
            'title' => 'Admin Usuarios - ' . APP_NAME,
            'users' => $userModel->getAllUsers(null, $per_page, $offset),
            'current_page' => $page,
            'total_pages' => $total_pages,
            'pagination_base_url' => 'admin/users'
        ];

        $this->view('admin/users', $data);
    }

    public function saveUser() {
        if (!$this->requireAdmin() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $userModel = $this->model('User');

        $register_data = [
            'nombre' => trim($_POST['nombre'] ?? ''),
            'apellido' => trim($_POST['apellido'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'password' => $_POST['password'] ?? 'default123',
            'telefono' => $_POST['telefono'] ?? null,
            'documento_tipo' => $_POST['documento_tipo'] ?? null,
            'documento_numero' => $_POST['documento_numero'] ?? null
        ];

        if ($userModel->register($register_data)) {
            $newUser = $userModel->getUserByEmail($register_data['email']);
            if ($newUser && !empty($_POST['rol'])) {
                $this->updateUserRole($newUser['id'], $_POST['rol']);
            }
            $_SESSION['message'] = 'Usuario creado.';
        } else {
            $_SESSION['error'] = 'No se pudo crear el usuario.';
        }

        header('Location: ' . app_url('admin/users'));
    }

    public function deleteUser($id) {
        if (!$this->requireAdmin()) return;
        $userModel = $this->model('User');
        $db = (new Database())->connect();
        $query = "UPDATE usuarios SET estado = 'inactivo' WHERE id = :id";
        $stmt = $db->prepare($query);
        $ok = $stmt->execute([':id' => (int)$id]);
        $_SESSION[$ok ? 'message' : 'error'] = $ok ? 'Usuario desactivado.' : 'Error al desactivar.';
        header('Location: ' . app_url('admin/users'));
    }

    public function activateUser($id) {
        if (!$this->requireAdmin()) return;
        $db = (new Database())->connect();
        $query = "UPDATE usuarios SET estado = 'activo' WHERE id = :id";
        $stmt = $db->prepare($query);
        $ok = $stmt->execute([':id' => (int)$id]);
        $_SESSION[$ok ? 'message' : 'error'] = $ok ? 'Usuario activado.' : 'Error al activar.';
        header('Location: ' . app_url('admin/users'));
    }

    public function categories() {
        if (!$this->requireAdmin()) {
            return;
        }

        $categoryModel = $this->model('Category');

        $cats = $categoryModel->getAllCategories();
        $cats_with_count = [];
        foreach ($cats as $cat) {
            $cats_with_count[] = $categoryModel->getCategoryWithProductCount($cat['id']);
        }

        $data = [
            'title' => 'Admin Categorias - ' . APP_NAME,
            'categories' => $cats_with_count
        ];

        $this->view('admin/categories', $data);
    }

    public function saveCategory() {
        if (!$this->requireAdmin() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $categoryModel = $this->model('Category');
        $id = $_POST['id'] ?? null;

        $data = [
            'nombre' => trim($_POST['nombre'] ?? ''),
            'descripcion' => $_POST['descripcion'] ?? null,
            'imagen' => $_POST['imagen'] ?? null
        ];

        $ok = $id ? $categoryModel->updateCategory((int)$id, $data) : $categoryModel->addCategory($data);
        $_SESSION[$ok ? 'message' : 'error'] = $ok ? 'Categoria guardada.' : 'No se pudo guardar.';
        header('Location: ' . app_url('admin/categories'));
    }

    public function deleteCategory($id) {
        if (!$this->requireAdmin()) return;
        $db = (new Database())->connect();
        $query = "UPDATE categorias SET estado = 'inactivo' WHERE id = :id";
        $stmt = $db->prepare($query);
        $ok = $stmt->execute([':id' => (int)$id]);
        $_SESSION[$ok ? 'message' : 'error'] = $ok ? 'Categoría desactivada.' : 'Error al desactivar.';
        header('Location: ' . app_url('admin/categories'));
    }

    public function activateCategory($id) {
        if (!$this->requireAdmin()) return;
        $db = (new Database())->connect();
        $query = "UPDATE categorias SET estado = 'activo' WHERE id = :id";
        $stmt = $db->prepare($query);
        $ok = $stmt->execute([':id' => (int)$id]);
        $_SESSION[$ok ? 'message' : 'error'] = $ok ? 'Categoría activada.' : 'Error al activar.';
        header('Location: ' . app_url('admin/categories'));
    }

    public function deliveries() {
        if (!$this->requireAdmin()) {
            return;
        }

        $db = (new Database())->connect();

        $query = "SELECT
                    e.id, e.orden_id, e.repartidor_id, e.estado AS estado_entrega,
                    e.fecha_asignacion, e.fecha_entrega_real, e.evidencia_foto,
                    e.firma_digital, e.observaciones, e.created_at, e.updated_at,
                    o.numero_orden, o.total,
                    CONCAT(u.nombre, ' ', u.apellido) AS cliente_nombre,
                    CONCAT(r.nombre, ' ', r.apellido) AS repartidor_nombre
                  FROM entregas e
                  JOIN ordenes o ON e.orden_id = o.id
                  JOIN usuarios u ON o.usuario_id = u.id
                  LEFT JOIN usuarios r ON e.repartidor_id = r.id
                  ORDER BY e.created_at DESC";
        $result = $db->prepare($query);
        $result->execute();
        $deliveries = $result->fetchAll();

        $repartidores = [];
        $query_repartidores = "SELECT id, nombre, apellido FROM usuarios WHERE rol = 'repartidor' AND estado = 'activo'";
        $result_rep = $db->prepare($query_repartidores);
        $result_rep->execute();
        $repartidores = $result_rep->fetchAll();

        $data = [
            'title' => 'Admin Entregas - ' . APP_NAME,
            'deliveries' => $deliveries,
            'repartidores' => $repartidores
        ];

        $this->view('admin/deliveries', $data);
    }

    public function updateDelivery($id) {
        if (!$this->requireAdmin() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $db = (new Database())->connect();
        $repartidor_id = !empty($_POST['repartidor_id']) ? (int)$_POST['repartidor_id'] : null;
        $estado = $_POST['estado_entrega'] ?? 'pendiente';

        $query = "UPDATE entregas SET
                  repartidor_id = :repartidor_id,
                  estado = :estado_entrega,
                  fecha_asignacion = CASE WHEN :repartidor_id_check IS NOT NULL AND repartidor_id IS NULL THEN NOW() ELSE fecha_asignacion END
                  WHERE id = :id";

        $result = $db->prepare($query);
        $ok = $result->execute([
            ':id' => (int)$id,
            ':repartidor_id' => $repartidor_id,
            ':repartidor_id_check' => $repartidor_id,
            ':estado_entrega' => $estado
        ]);

        $_SESSION[$ok ? 'message' : 'error'] = $ok ? 'Entrega actualizada.' : 'Error al actualizar.';
        header('Location: ' . app_url('admin/deliveries'));
    }

    public function editCategory($id) {
        if (!$this->requireAdmin()) {
            return;
        }

        $categoryModel = $this->model('Category');
        $category = $categoryModel->getCategoryById((int)$id);

        if (!$category) {
            http_response_code(404);
            echo "Categoria no encontrada.";
            return;
        }

        $data = [
            'title' => 'Editar Categoria - ' . APP_NAME,
            'category' => $category
        ];

        $this->view('admin/edit-category', $data);
    }

    private function updateUserRole($user_id, $rol) {
        $db = (new Database())->connect();
        $query = "UPDATE usuarios SET rol = :rol WHERE id = :id";
        $result = $db->prepare($query);
        return $result->execute([':id' => (int)$user_id, ':rol' => $rol]);
    }

    public function settings() {
        if (!$this->requireAdmin()) return;
        
        $settingModel = $this->model('Setting');
        
        $data = [
            'title' => 'Admin Settings - ' . APP_NAME,
            'campaigns' => $settingModel->getAllCampaigns()
        ];
        
        $this->view('admin/settings', $data);
    }

    public function saveSetting() {
        if (!$this->requireAdmin() || $_SERVER['REQUEST_METHOD'] !== 'POST') return;
        
        $db = (new Database())->connect();
        $id = !empty($_POST['id']) ? (int)$_POST['id'] : null;
        
        $campaign_name = $_POST['campaign_name'] ?? '';
        $hero_title = $_POST['hero_title'] ?? '';
        $hero_subtitle = $_POST['hero_subtitle'] ?? '';
        $hero_button_text = $_POST['hero_button_text'] ?? '';
        $hero_image_url = $_POST['hero_image_url'] ?? '';
        $hero_bg_color = $_POST['hero_bg_color'] ?? '#F5E6EB';
        
        if ($id) {
            $stmt = $db->prepare("UPDATE home_settings SET campaign_name=?, hero_title=?, hero_subtitle=?, hero_button_text=?, hero_image_url=?, hero_bg_color=? WHERE id=?");
            $ok = $stmt->execute([$campaign_name, $hero_title, $hero_subtitle, $hero_button_text, $hero_image_url, $hero_bg_color, $id]);
        } else {
            $stmt = $db->prepare("INSERT INTO home_settings (campaign_name, hero_title, hero_subtitle, hero_button_text, hero_image_url, hero_bg_color) VALUES (?, ?, ?, ?, ?, ?)");
            $ok = $stmt->execute([$campaign_name, $hero_title, $hero_subtitle, $hero_button_text, $hero_image_url, $hero_bg_color]);
        }
        
        $_SESSION[$ok ? 'message' : 'error'] = $ok ? 'Campaña guardada exitosamente.' : 'Error al guardar campaña.';
        header('Location: ' . app_url('admin/settings'));
    }

    public function activateSetting($id) {
        if (!$this->requireAdmin()) return;
        
        $settingModel = $this->model('Setting');
        $settingModel->activateCampaign((int)$id);
        
        $_SESSION['message'] = 'Campaña activada.';
        header('Location: ' . app_url('admin/settings'));
    }
}
