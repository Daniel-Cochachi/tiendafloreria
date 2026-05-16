<?php
class Product {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    private function priceExpression() {
        return "COALESCE(NULLIF(p.precio_final, 0), ROUND(p.precio_unitario * (1 - COALESCE(p.descuento_porcentaje, 0) / 100), 2), p.precio_unitario)";
    }

    public function getAllProducts($limit = null, $offset = 0) {
        $query = "SELECT p.*, c.nombre AS categoria_nombre, " . $this->priceExpression() . " AS precio_actual
                  FROM productos p
                  JOIN categorias c ON p.categoria_id = c.id
                  WHERE p.estado = 'activo' AND c.estado = 'activo'
                  ORDER BY p.created_at DESC";

        if ($limit) {
            $query .= " LIMIT :limit OFFSET :offset";
        }

        $result = $this->db->prepare($query);

        if ($limit) {
            $result->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $result->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        }

        $result->execute();
        return $result->fetchAll();
    }

    public function getProductsForAdmin($limit = null, $offset = 0) {
        $query = "SELECT p.*, c.nombre AS categoria_nombre, " . $this->priceExpression() . " AS precio_actual
                  FROM productos p
                  JOIN categorias c ON p.categoria_id = c.id
                  ORDER BY p.created_at DESC";

        if ($limit) {
            $query .= " LIMIT :limit OFFSET :offset";
        }

        $result = $this->db->prepare($query);

        if ($limit) {
            $result->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $result->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        }

        $result->execute();
        return $result->fetchAll();
    }

    public function countAllProducts() {
        $query = "SELECT COUNT(*) AS total FROM productos";
        $result = $this->db->prepare($query);
        $result->execute();
        $row = $result->fetch();
        return (int)($row['total'] ?? 0);
    }

    public function getProductById($id, $active_only = true) {
        $query = "SELECT p.*, c.nombre AS categoria_nombre,
                         " . $this->priceExpression() . " AS precio_actual,
                         rating.promedio_calificacion,
                         rating.total_resenas
                  FROM productos p
                  JOIN categorias c ON p.categoria_id = c.id
                  LEFT JOIN (
                      SELECT producto_id,
                             AVG(calificacion) AS promedio_calificacion,
                             COUNT(*) AS total_resenas
                      FROM resenas
                      WHERE estado = 'aprobada'
                      GROUP BY producto_id
                  ) rating ON rating.producto_id = p.id
                  WHERE p.id = :id";

        if ($active_only) {
            $query .= " AND p.estado = 'activo'";
        }

        $result = $this->db->prepare($query);
        $result->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $result->execute();
        return $result->fetch();
    }

    public function getProductsByCategory($categoria_id, $limit = null, $offset = 0) {
        $query = "SELECT p.*, c.nombre AS categoria_nombre, " . $this->priceExpression() . " AS precio_actual
                  FROM productos p
                  JOIN categorias c ON p.categoria_id = c.id
                  WHERE p.categoria_id = :categoria_id 
                  AND p.estado = 'activo' 
                  AND c.estado = 'activo'
                  ORDER BY p.created_at DESC";

        if ($limit) {
            $query .= " LIMIT :limit OFFSET :offset";
        }

        $result = $this->db->prepare($query);
        $result->bindValue(':categoria_id', (int)$categoria_id, PDO::PARAM_INT);

        if ($limit) {
            $result->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $result->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        }

        $result->execute();
        return $result->fetchAll();
    }

    public function searchProducts($search) {
        $query = "SELECT p.*, c.nombre AS categoria_nombre, " . $this->priceExpression() . " AS precio_actual
                  FROM productos p
                  JOIN categorias c ON p.categoria_id = c.id
                  WHERE (p.nombre LIKE :search1 OR p.descripcion LIKE :search2 OR p.codigo_sku LIKE :search3)
                  AND p.estado = 'activo' AND c.estado = 'activo'
                  ORDER BY p.nombre ASC";

        $result = $this->db->prepare($query);
        $searchTerm = '%' . $search . '%';
        $result->bindValue(':search1', $searchTerm);
        $result->bindValue(':search2', $searchTerm);
        $result->bindValue(':search3', $searchTerm);
        $result->execute();
        return $result->fetchAll();
    }

    public function addProduct($data) {
        $query = "INSERT INTO productos
                  (categoria_id, nombre, descripcion, precio_unitario, descuento_porcentaje,
                   precio_final, imagen_principal, stock, stock_minimo, tipo_producto,
                   codigo_sku, duracion_dias, cuidados, estado)
                  VALUES
                  (:categoria_id, :nombre, :descripcion, :precio_unitario, :descuento_porcentaje,
                   :precio_final, :imagen_principal, :stock, :stock_minimo, :tipo_producto,
                   :codigo_sku, :duracion_dias, :cuidados, :estado)";

        $result = $this->db->prepare($query);

        return $result->execute([
            ':categoria_id' => (int)$data['categoria_id'],
            ':nombre' => trim($data['nombre']),
            ':descripcion' => $data['descripcion'] ?? null,
            ':precio_unitario' => (float)$data['precio_unitario'],
            ':descuento_porcentaje' => (float)($data['descuento_porcentaje'] ?? 0),
            ':precio_final' => $this->calculateFinalPrice($data),
            ':imagen_principal' => $data['imagen_principal'] ?? null,
            ':stock' => (int)($data['stock'] ?? 0),
            ':stock_minimo' => (int)($data['stock_minimo'] ?? 10),
            ':tipo_producto' => $data['tipo_producto'] ?? 'flor_individual',
            ':codigo_sku' => trim($data['codigo_sku']),
            ':duracion_dias' => (int)($data['duracion_dias'] ?? 10),
            ':cuidados' => $data['cuidados'] ?? null,
            ':estado' => $data['estado'] ?? 'activo'
        ]);
    }

    public function updateProduct($id, $data) {
        $query = "UPDATE productos SET
                  categoria_id = :categoria_id,
                  nombre = :nombre,
                  descripcion = :descripcion,
                  precio_unitario = :precio_unitario,
                  descuento_porcentaje = :descuento_porcentaje,
                  precio_final = :precio_final,
                  imagen_principal = :imagen_principal,
                  stock = :stock,
                  stock_minimo = :stock_minimo,
                  tipo_producto = :tipo_producto,
                  codigo_sku = :codigo_sku,
                  duracion_dias = :duracion_dias,
                  cuidados = :cuidados,
                  estado = :estado
                  WHERE id = :id";

        $result = $this->db->prepare($query);

        return $result->execute([
            ':id' => (int)$id,
            ':categoria_id' => (int)$data['categoria_id'],
            ':nombre' => trim($data['nombre']),
            ':descripcion' => $data['descripcion'] ?? null,
            ':precio_unitario' => (float)$data['precio_unitario'],
            ':descuento_porcentaje' => (float)($data['descuento_porcentaje'] ?? 0),
            ':precio_final' => $this->calculateFinalPrice($data),
            ':imagen_principal' => $data['imagen_principal'] ?? null,
            ':stock' => (int)($data['stock'] ?? 0),
            ':stock_minimo' => (int)($data['stock_minimo'] ?? 10),
            ':tipo_producto' => $data['tipo_producto'] ?? 'flor_individual',
            ':codigo_sku' => trim($data['codigo_sku']),
            ':duracion_dias' => (int)($data['duracion_dias'] ?? 10),
            ':cuidados' => $data['cuidados'] ?? null,
            ':estado' => $data['estado'] ?? 'activo'
        ]);
    }

    public function deleteProduct($id) {
        $query = "UPDATE productos SET estado = 'inactivo' WHERE id = :id";
        $result = $this->db->prepare($query);
        return $result->execute([':id' => (int)$id]);
    }

    public function getStockProduct($id) {
        $query = "SELECT stock FROM productos WHERE id = :id";
        $result = $this->db->prepare($query);
        $result->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $result->execute();
        $row = $result->fetch();
        return $row ? (int)$row['stock'] : 0;
    }

    public function getProductsWithLowStock($minimo = null) {
        $query = "SELECT p.*, c.nombre AS categoria_nombre
                  FROM productos p
                  JOIN categorias c ON p.categoria_id = c.id
                  WHERE p.stock <= COALESCE(:minimo, p.stock_minimo) AND p.estado = 'activo'
                  ORDER BY p.stock ASC";

        $result = $this->db->prepare($query);
        $result->bindValue(':minimo', $minimo, $minimo === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
        $result->execute();
        return $result->fetchAll();
    }

    public function countActiveProducts() {
        $query = "SELECT COUNT(*) AS total FROM productos WHERE estado = 'activo'";
        $result = $this->db->prepare($query);
        $result->execute();
        $row = $result->fetch();
        return (int)($row['total'] ?? 0);
    }

    private function calculateFinalPrice($data) {
        if (isset($data['precio_final']) && $data['precio_final'] !== '') {
            return (float)$data['precio_final'];
        }

        $base = (float)$data['precio_unitario'];
        $discount = (float)($data['descuento_porcentaje'] ?? 0);

        if ($discount <= 0) {
            return null;
        }

        return round($base * (1 - $discount / 100), 2);
    }

    public function getBestSelling($limit = 8) {
        $query = "SELECT p.*, c.nombre AS categoria_nombre, " . $this->priceExpression() . " AS precio_actual,
                         COALESCE(sales.total_sold, 0) AS total_vendido
                  FROM productos p
                  JOIN categorias c ON p.categoria_id = c.id
                  LEFT JOIN (
                      SELECT producto_id, SUM(cantidad) AS total_sold
                      FROM orden_detalles
                      GROUP BY producto_id
                  ) sales ON sales.producto_id = p.id
                  WHERE p.estado = 'activo' AND c.estado = 'activo'
                  ORDER BY total_vendido DESC, p.created_at DESC
                  LIMIT :limit";

        $result = $this->db->prepare($query);
        $result->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $result->execute();
        return $result->fetchAll();
    }

    public function getFeaturedProducts($limit = 8) {
        $query = "SELECT p.*, c.nombre AS categoria_nombre, " . $this->priceExpression() . " AS precio_actual
                  FROM productos p
                  JOIN categorias c ON p.categoria_id = c.id
                  WHERE p.estado = 'activo' AND c.estado = 'activo' AND p.descuento_porcentaje > 0
                  ORDER BY p.descuento_porcentaje DESC, p.created_at DESC
                  LIMIT :limit";

        $result = $this->db->prepare($query);
        $result->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $result->execute();
        return $result->fetchAll();
    }
}
