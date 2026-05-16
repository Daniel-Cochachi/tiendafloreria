<?php
class PagesController extends Controller {
    public function about() {
        $data = ['title' => 'Nosotros'];
        $this->view('pages/about', $data);
    }

    public function services() {
        $serviceModel = $this->model('Service');

        $data = [
            'title' => 'Servicios',
            'services' => $serviceModel->getActiveServices()
        ];

        $this->view('pages/services', $data);
    }

    public function promotions() {
        $productModel = $this->model('Product');
        $settingModel = $this->model('Setting');

        $activeCampaign = $settingModel->getActiveCampaign();
        $discountedProducts = $productModel->getFeaturedProducts(12);

        $data = [
            'title' => 'Promociones - ' . APP_NAME,
            'campaign' => $activeCampaign,
            'products' => $discountedProducts
        ];

        $this->view('pages/promotions', $data);
    }

    public function contact() {
        $data = ['title' => 'Contacto'];
        $this->view('pages/contact', $data);
    }

    public function faq() {
        $data = ['title' => 'FAQ'];
        $this->view('pages/faq', $data);
    }

    public function send() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . app_url('contact'));
            return;
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $subject = trim($_POST['subject'] ?? 'Consulta General');
        $message = trim($_POST['message'] ?? '');

        if (!$name || !$email || !$message) {
            $_SESSION['error'] = 'Todos los campos obligatorios deben llenarse.';
            header('Location: ' . app_url('contact'));
            return;
        }

        $db = (new Database())->connect();
        $query = "INSERT INTO notificaciones (usuario_id, titulo, mensaje, tipo)
                  VALUES (NULL, :titulo, :mensaje, 'contacto')";
        $result = $db->prepare($query);
        $result->execute([
            ':titulo' => 'Contacto: ' . $subject . ' - ' . $name . ' (' . $email . ')',
            ':mensaje' => "Nombre: $name\nEmail: $email\nAsunto: $subject\nMensaje: $message"
        ]);

        $_SESSION['message'] = 'Mensaje enviado exitosamente. Te responderemos pronto.';
        header('Location: ' . app_url('contact'));
    }
}
