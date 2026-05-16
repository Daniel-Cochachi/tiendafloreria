<?php
class Category {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function getAllCategories() {
        $query = "SELECT * FROM categorias WHERE estado = 'activo' ORDER BY nombre ASC";
        
        $result = $this->db->prepare($query);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategoryById($id) {
        $query = "SELECT * FROM categorias WHERE id = :id AND estado = 'activo'";
        
        $result = $this->db->prepare($query);
        $result->bindParam(':id', $id);
        $result->execute();
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function addCategory($data) {
        $query = "INSERT INTO categorias (nombre, descripcion, imagen, estado) 
                  VALUES (:nombre, :descripcion, :imagen, 'activo')";
        
        $result = $this->db->prepare($query);
        
        return $result->execute([
            ':nombre' => $data['nombre'],
            ':descripcion' => $data['descripcion'] ?? NULL,
            ':imagen' => $data['imagen'] ?? NULL
        ]);
    }

    public function updateCategory($id, $data) {
        $query = "UPDATE categorias SET 
                  nombre = :nombre,
                  descripcion = :descripcion,
                  imagen = :imagen
                  WHERE id = :id";
        
        $result = $this->db->prepare($query);
        
        return $result->execute([
            ':id' => $id,
            ':nombre' => $data['nombre'],
            ':descripcion' => $data['descripcion'] ?? NULL,
            ':imagen' => $data['imagen'] ?? NULL
        ]);
    }

    public function deleteCategory($id) {
        $query = "UPDATE categorias SET estado = 'inactivo' WHERE id = :id";
        
        $result = $this->db->prepare($query);
        return $result->execute([':id' => $id]);
    }

    public function getCategoryWithProductCount($id) {
        $query = "SELECT c.*, COUNT(p.id) as producto_count 
                  FROM categorias c 
                  LEFT JOIN productos p ON c.id = p.categoria_id AND p.estado = 'activo'
                  WHERE c.id = :id
                  GROUP BY c.id";
        
        $result = $this->db->prepare($query);
        $result->bindParam(':id', $id);
        $result->execute();
        return $result->fetch(PDO::FETCH_ASSOC);
    }
}
