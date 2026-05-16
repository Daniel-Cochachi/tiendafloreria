<?php
class NewsletterController extends Controller {
    public function subscribe() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . app_url());
            return;
        }

        $email = trim($_POST['email'] ?? '');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Correo electronico invalido.';
            header('Location: ' . app_url());
            return;
        }

        $db = (new Database())->connect();

        $query = "SELECT id FROM notificaciones WHERE tipo = 'newsletter' AND mensaje = :email LIMIT 1";
        $result = $db->prepare($query);
        $result->execute([':email' => $email]);

        if ($result->fetch()) {
            $_SESSION['message'] = 'Ya estas suscrito a nuestro newsletter.';
        } else {
            $query = "INSERT INTO notificaciones (usuario_id, titulo, mensaje, tipo, leida)
                      VALUES (NULL, 'Nuevo suscriptor newsletter', :email, 'newsletter', 1)";
            $result = $db->prepare($query);
            $result->execute([':email' => $email]);
            $_SESSION['message'] = 'Suscripcion exitosa. Bienvenido a nuestro newsletter.';
        }

        header('Location: ' . app_url());
    }
}
