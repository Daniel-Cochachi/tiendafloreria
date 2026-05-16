<?php
class Notification {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function createNotification($data) {
        $query = "INSERT INTO notificaciones
                  (usuario_id, titulo, mensaje, tipo, leido)
                  VALUES
                  (:usuario_id, :titulo, :mensaje, :tipo, 0)";

        $result = $this->db->prepare($query);

        $success = $result->execute([
            ':usuario_id' => (int)$data['usuario_id'],
            ':titulo' => $data['titulo'],
            ':mensaje' => $data['mensaje'] ?? null,
            ':tipo' => $data['tipo'] ?? 'general'
        ]);

        return $success ? $this->db->lastInsertId() : false;
    }

    public function getNotificationsByUser($user_id) {
        $query = "SELECT *
                  FROM notificaciones
                  WHERE usuario_id = :usuario_id
                  ORDER BY created_at DESC";

        $result = $this->db->prepare($query);
        $result->bindValue(':usuario_id', (int)$user_id, PDO::PARAM_INT);
        $result->execute();
        return $result->fetchAll();
    }

    public function markAsRead($id) {
        $query = "UPDATE notificaciones
                  SET leido = 1
                  WHERE id = :id";

        $result = $this->db->prepare($query);
        return $result->execute([':id' => (int)$id]);
    }

    public function getUnreadCount($user_id) {
        $query = "SELECT COUNT(*) AS total
                  FROM notificaciones
                  WHERE usuario_id = :usuario_id AND leido = 0";

        $result = $this->db->prepare($query);
        $result->bindValue(':usuario_id', (int)$user_id, PDO::PARAM_INT);
        $result->execute();
        $row = $result->fetch();
        return (int)($row['total'] ?? 0);
    }
}
