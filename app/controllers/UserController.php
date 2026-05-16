<?php
class UserController extends Controller {
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = $this->model('User');

            if (empty($_POST['nombre']) || empty($_POST['email']) || empty($_POST['password'])) {
                $_SESSION['error'] = 'Nombre, email y contrasena son requeridos.';
                header('Location: ' . app_url('user/register'));
                return;
            }

            if ($userModel->getUserByEmail($_POST['email'])) {
                $_SESSION['error'] = 'El email ya esta registrado.';
                header('Location: ' . app_url('user/register'));
                return;
            }

            $data = [
                'nombre' => trim($_POST['nombre']),
                'apellido' => trim($_POST['apellido'] ?? ''),
                'email' => trim($_POST['email']),
                'password' => $_POST['password'],
                'telefono' => $_POST['telefono'] ?? null,
                'documento_tipo' => $_POST['documento_tipo'] ?? null,
                'documento_numero' => $_POST['documento_numero'] ?? null
            ];

            if ($userModel->register($data)) {
                $_SESSION['message'] = 'Registro exitoso, inicia sesion.';
                header('Location: ' . app_url('user/login'));
            } else {
                $_SESSION['error'] = 'Error al registrarse.';
                header('Location: ' . app_url('user/register'));
            }

            return;
        }

        $data = ['title' => 'Registro - ' . APP_NAME];
        $this->view('user/register', $data);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = $this->model('User');

            $user = $userModel->login($_POST['email'] ?? '', $_POST['password'] ?? '');

            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nombre'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_rol'] = $user['rol'];
                $_SESSION['message'] = 'Bienvenido ' . $user['nombre'] . '.';

                header('Location: ' . (($user['rol'] === 'admin') ? app_url('admin') : app_url('user/profile')));
            } else {
                $_SESSION['error'] = 'Email o contrasena incorrectos.';
                header('Location: ' . app_url('user/login'));
            }

            return;
        }

        $data = ['title' => 'Login - ' . APP_NAME];
        $this->view('user/login', $data);
    }

    public function profile() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . app_url('user/login'));
            return;
        }

        $userModel = $this->model('User');
        $addressModel = $this->model('Address');

        $data = [
            'title' => 'Mi Perfil - ' . APP_NAME,
            'user' => $userModel->getUserById($_SESSION['user_id']),
            'addresses' => $addressModel->getAddressesByUser($_SESSION['user_id'])
        ];

        $this->view('user/profile', $data);
    }

    public function updateProfile() {
        if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . app_url('user/profile'));
            return;
        }

        $userModel = $this->model('User');

        $data = [
            'nombre' => trim($_POST['nombre']),
            'apellido' => trim($_POST['apellido']),
            'telefono' => $_POST['telefono'] ?? null,
            'genero' => $_POST['genero'] ?? null,
            'documento_tipo' => $_POST['documento_tipo'] ?? null,
            'documento_numero' => $_POST['documento_numero'] ?? null
        ];

        if ($userModel->updateProfile($_SESSION['user_id'], $data)) {
            $_SESSION['user_name'] = $data['nombre'];
            $_SESSION['message'] = 'Perfil actualizado.';
        } else {
            $_SESSION['error'] = 'Error al actualizar perfil.';
        }

        header('Location: ' . app_url('user/profile'));
    }

    public function logout() {
        $_SESSION = [];
        session_destroy();
        header('Location: ' . app_url());
    }

    public function addAddress() {
        if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . app_url('user/profile'));
            return;
        }

        $addressModel = $this->model('Address');

        $data = [
            'usuario_id' => $_SESSION['user_id'],
            'tipo' => $_POST['tipo'] ?? 'domicilio',
            'calle' => trim($_POST['calle']),
            'numero' => $_POST['numero'] ?? null,
            'departamento' => $_POST['departamento'] ?? null,
            'distrito' => trim($_POST['distrito']),
            'provincia' => trim($_POST['provincia']),
            'departamento_prov' => trim($_POST['departamento_prov']),
            'codigo_postal' => $_POST['codigo_postal'] ?? null,
            'referencia' => $_POST['referencia'] ?? null,
            'es_principal' => isset($_POST['principal'])
        ];

        if ($addressModel->addAddress($data)) {
            $_SESSION['message'] = 'Direccion agregada.';
        } else {
            $_SESSION['error'] = 'Error al agregar direccion.';
        }

        header('Location: ' . app_url('user/profile'));
    }

    public function setPrimaryAddress($address_id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . app_url('user/login'));
            return;
        }

        $addressModel = $this->model('Address');

        if ($addressModel->setPrimaryAddress($_SESSION['user_id'], (int)$address_id)) {
            $_SESSION['message'] = 'Direccion principal actualizada.';
        } else {
            $_SESSION['error'] = 'No se pudo actualizar la direccion principal.';
        }

        header('Location: ' . app_url('user/profile'));
    }

    public function changePassword() {
        if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . app_url('user/profile'));
            return;
        }

        $password_actual = $_POST['password_actual'] ?? '';
        $password_nueva = $_POST['password_nueva'] ?? '';
        $password_confirmar = $_POST['password_confirmar'] ?? '';

        if (!$password_actual || !$password_nueva || !$password_confirmar) {
            $_SESSION['error'] = 'Todos los campos de contrasena son requeridos.';
            header('Location: ' . app_url('user/profile'));
            return;
        }

        if ($password_nueva !== $password_confirmar) {
            $_SESSION['error'] = 'Las contrasenas nuevas no coinciden.';
            header('Location: ' . app_url('user/profile'));
            return;
        }

        if (strlen($password_nueva) < 6) {
            $_SESSION['error'] = 'La contrasena debe tener al menos 6 caracteres.';
            header('Location: ' . app_url('user/profile'));
            return;
        }

        $userModel = $this->model('User');

        if ($userModel->changePassword($_SESSION['user_id'], $password_actual, $password_nueva)) {
            $_SESSION['message'] = 'Contrasena actualizada exitosamente.';
        } else {
            $_SESSION['error'] = 'La contrasena actual es incorrecta.';
        }

        header('Location: ' . app_url('user/profile'));
    }

    public function deleteAddress($address_id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . app_url('user/login'));
            return;
        }

        $addressModel = $this->model('Address');

        if ($addressModel->deleteAddress((int)$address_id, $_SESSION['user_id'])) {
            $_SESSION['message'] = 'Direccion eliminada.';
        }

        header('Location: ' . app_url('user/profile'));
    }
}
