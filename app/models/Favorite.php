<?php
class Favorite {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function addFavorite($usuario_id, $producto_id) {
        $query = "INSERT INTO favoritos (usuario_id, producto_id) 
                  VALUES (:usuario_id, :producto_id)
                  ON DUPLICATE KEY UPDATE usuario_id = usuario_id";
        
        $result = $this->db->prepare($query);
        return $result->execute([
            ':usuario_id' => $usuario_id,
            ':producto_id' => $producto_id
        ]);
    }

    public function removeFavorite($usuario_id, $producto_id) {
        $query = "DELETE FROM favoritos 
                  WHERE usuario_id = :usuario_id AND producto_id = :producto_id";
        
        $result = $this->db->prepare($query);
        return $result->execute([
            ':usuario_id' => $usuario_id,
            ':producto_id' => $producto_id
        ]);
    }

    public function getFavoritesByUser($usuario_id) {
        $query = "SELECT f.*, p.nombre, p.precio_unitario, p.imagen_principal, p.stock, p.tipo_producto,
                         COALESCE(NULLIF(p.precio_final, 0), ROUND(p.precio_unitario * (1 - COALESCE(p.descuento_porcentaje, 0) / 100), 2), p.precio_unitario) AS precio_actual
                  FROM favoritos f
                  JOIN productos p ON f.producto_id = p.id
                  WHERE f.usuario_id = :usuario_id AND p.estado = 'activo'
                  ORDER BY f.created_at DESC";
        
        $result = $this->db->prepare($query);
        $result->bindParam(':usuario_id', $usuario_id);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function isFavorite($usuario_id, $producto_id) {
        $query = "SELECT id FROM favoritos 
                  WHERE usuario_id = :usuario_id AND producto_id = :producto_id";
        
        $result = $this->db->prepare($query);
        $result->execute([
            ':usuario_id' => $usuario_id,
            ':producto_id' => $producto_id
        ]);
        
        return $result->fetch(PDO::FETCH_ASSOC) ? TRUE : FALSE;
    }
}
