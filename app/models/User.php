<?php
class User {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function register($data) {
        $query = "INSERT INTO usuarios
                  (nombre, apellido, email, password, telefono, documento_tipo, documento_numero, rol, estado)
                  VALUES
                  (:nombre, :apellido, :email, :password, :telefono, :documento_tipo, :documento_numero, 'cliente', 'activo')";

        $result = $this->db->prepare($query);

        return $result->execute([
            ':nombre' => trim($data['nombre']),
            ':apellido' => trim($data['apellido'] ?? ''),
            ':email' => trim($data['email']),
            ':password' => password_hash($data['password'], PASSWORD_BCRYPT),
            ':telefono' => $data['telefono'] ?? null,
            ':documento_tipo' => $data['documento_tipo'] ?? null,
            ':documento_numero' => $data['documento_numero'] ?? null
        ]);
    }

    public function getUserByEmail($email) {
        $query = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        $result = $this->db->prepare($query);
        $result->bindValue(':email', trim($email));
        $result->execute();
        return $result->fetch();
    }

    public function getUserById($id) {
        $query = "SELECT * FROM usuarios WHERE id = :id";
        $result = $this->db->prepare($query);
        $result->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $result->execute();
        return $result->fetch();
    }

    public function login($email, $password) {
        $user = $this->getUserByEmail($email);

        if (!$user || $user['estado'] !== 'activo') {
            return false;
        }

        if (password_verify($password, $user['password'])) {
            return $user;
        }

        // Compatibilidad con el admin sembrado en database.sql usando SHA2.
        if (hash_equals((string)$user['password'], hash('sha256', $password))) {
            $this->updatePasswordHash($user['id'], $password);
            return $this->getUserById($user['id']);
        }

        return false;
    }

    public function updateProfile($id, $data) {
        $query = "UPDATE usuarios SET
                  nombre = :nombre,
                  apellido = :apellido,
                  telefono = :telefono,
                  genero = :genero,
                  documento_tipo = :documento_tipo,
                  documento_numero = :documento_numero
                  WHERE id = :id";

        $result = $this->db->prepare($query);

        return $result->execute([
            ':id' => (int)$id,
            ':nombre' => trim($data['nombre']),
            ':apellido' => trim($data['apellido']),
            ':telefono' => $data['telefono'] ?? null,
            ':genero' => $data['genero'] ?? null,
            ':documento_tipo' => $data['documento_tipo'] ?? null,
            ':documento_numero' => $data['documento_numero'] ?? null
        ]);
    }

    public function changePassword($id, $old_password, $new_password) {
        $user = $this->getUserById($id);

        if ($user && password_verify($old_password, $user['password'])) {
            return $this->updatePasswordHash($id, $new_password);
        }

        return false;
    }

    public function getAllUsers($rol = null, $limit = null, $offset = 0) {
        $query = "SELECT * FROM usuarios WHERE 1=1";

        if ($rol) {
            $query .= " AND rol = :rol";
        }

        $query .= " ORDER BY created_at DESC";

        if ($limit !== null) {
            $query .= " LIMIT :limit OFFSET :offset";
        }

        $result = $this->db->prepare($query);

        if ($rol) {
            $result->bindValue(':rol', $rol);
        }

        if ($limit !== null) {
            $result->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $result->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        }

        $result->execute();
        return $result->fetchAll();
    }

    public function countUsers($rol = null) {
        $query = "SELECT COUNT(*) AS total FROM usuarios WHERE estado = 'activo'";

        if ($rol) {
            $query .= " AND rol = :rol";
        }

        $result = $this->db->prepare($query);

        if ($rol) {
            $result->bindValue(':rol', $rol);
        }

        $result->execute();
        $row = $result->fetch();
        return (int)($row['total'] ?? 0);
    }

    private function updatePasswordHash($id, $password) {
        $query = "UPDATE usuarios SET password = :password WHERE id = :id";
        $result = $this->db->prepare($query);

        return $result->execute([
            ':id' => (int)$id,
            ':password' => password_hash($password, PASSWORD_BCRYPT)
        ]);
    }
}
