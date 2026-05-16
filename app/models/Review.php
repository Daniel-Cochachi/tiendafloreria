<?php
class Review {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function addReview($data) {
        $query = "INSERT INTO resenas 
                  (usuario_id, producto_id, orden_id, calificacion, titulo, comentario, estado) 
                  VALUES 
                  (:usuario_id, :producto_id, :orden_id, :calificacion, :titulo, :comentario, 'aprobada')";
        
        $result = $this->db->prepare($query);
        
        return $result->execute([
            ':usuario_id' => $data['usuario_id'],
            ':producto_id' => $data['producto_id'],
            ':orden_id' => $data['orden_id'] ?? NULL,
            ':calificacion' => $data['calificacion'],
            ':titulo' => $data['titulo'] ?? NULL,
            ':comentario' => $data['comentario'] ?? NULL
        ]);
    }

    public function getReviewsByProduct($producto_id, $approved_only = TRUE) {
        $query = "SELECT r.*, u.nombre, u.apellido 
                  FROM resenas r 
                  LEFT JOIN usuarios u ON r.usuario_id = u.id 
                  WHERE r.producto_id = :producto_id";
        
        if ($approved_only) {
            $query .= " AND r.estado = 'aprobada'";
        }
        
        $query .= " ORDER BY r.created_at DESC";
        
        $result = $this->db->prepare($query);
        $result->execute([':producto_id' => (int)$producto_id]);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReviewsByUser($usuario_id) {
        $query = "SELECT r.*, p.nombre as producto_nombre FROM resenas r 
                  JOIN productos p ON r.producto_id = p.id 
                  WHERE r.usuario_id = :usuario_id 
                  ORDER BY r.created_at DESC";
        
        $result = $this->db->prepare($query);
        $result->bindParam(':usuario_id', $usuario_id);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductRating($producto_id) {
        $query = "SELECT 
                    AVG(calificacion) as promedio,
                    COUNT(*) as total_resenas,
                    SUM(CASE WHEN calificacion = 5 THEN 1 ELSE 0 END) as cinco_estrellas,
                    SUM(CASE WHEN calificacion = 4 THEN 1 ELSE 0 END) as cuatro_estrellas,
                    SUM(CASE WHEN calificacion = 3 THEN 1 ELSE 0 END) as tres_estrellas,
                    SUM(CASE WHEN calificacion = 2 THEN 1 ELSE 0 END) as dos_estrellas,
                    SUM(CASE WHEN calificacion = 1 THEN 1 ELSE 0 END) as una_estrella
                  FROM resenas 
                  WHERE producto_id = :producto_id AND estado = 'aprobada'";
        
        $result = $this->db->prepare($query);
        $result->execute([':producto_id' => (int)$producto_id]);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function approveReview($id) {
        $query = "UPDATE resenas SET estado = 'aprobada' WHERE id = :id";
        
        $result = $this->db->prepare($query);
        return $result->execute([':id' => $id]);
    }

    public function rejectReview($id) {
        $query = "UPDATE resenas SET estado = 'rechazada' WHERE id = :id";
        
        $result = $this->db->prepare($query);
        return $result->execute([':id' => $id]);
    }

    public function getPendingReviews() {
        $query = "SELECT r.*, p.nombre as producto_nombre, u.nombre as usuario_nombre 
                  FROM resenas r 
                  JOIN productos p ON r.producto_id = p.id 
                  JOIN usuarios u ON r.usuario_id = u.id 
                  WHERE r.estado = 'pendiente' 
                  ORDER BY r.created_at ASC";
        
        $result = $this->db->prepare($query);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}
