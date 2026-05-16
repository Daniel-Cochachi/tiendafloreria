<?php
class Controller {
    public function model($model) {
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }

    public function view($view, $data = []) {
        $view_path = '../app/views/' . $view . '.php';

        if (!file_exists($view_path)) {
            http_response_code(404);
            $data = [
                'title' => '404 - Pagina no encontrada',
                'message' => 'La pagina solicitada no existe.'
            ];
            extract($data);
            require '../app/views/layouts/header.php';
            require '../app/views/pages/404.php';
            require '../app/views/layouts/footer.php';
            return;
        }

        extract($data);

        $isAdmin = strpos($view, 'admin/') === 0;

        if ($isAdmin) {
            require '../app/views/layouts/admin_header.php';
            require $view_path;
            require '../app/views/layouts/admin_footer.php';
        } else {
            require '../app/views/layouts/header.php';
            require $view_path;
            require '../app/views/layouts/footer.php';
        }
    }
}
