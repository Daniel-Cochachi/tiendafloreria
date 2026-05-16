<?php
class Cart {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    private function priceExpression() {
        return "COALESCE(NULLIF(precio_final, 0), ROUND(precio_unitario * (1 - COALESCE(descuento_porcentaje, 0) / 100), 2), precio_unitario)";
    }

    public function addToCart($usuario_id, $producto_id, $cantidad = 1) {
        $cantidad = max(1, (int)$cantidad);

        $query_producto = "SELECT id, stock, " . $this->priceExpression() . " AS precio_actual
                           FROM productos
                           WHERE id = :producto_id AND estado = 'activo'";
        $result = $this->db->prepare($query_producto);
        $result->bindValue(':producto_id', (int)$producto_id, PDO::PARAM_INT);
        $result->execute();
        $producto = $result->fetch();

        if (!$producto || (int)$producto['stock'] <= 0) {
            return false;
        }

        $query_check = "SELECT id, cantidad
                        FROM carrito
                        WHERE usuario_id = :usuario_id AND producto_id = :producto_id";
        $result = $this->db->prepare($query_check);
        $result->execute([
            ':usuario_id' => (int)$usuario_id,
            ':producto_id' => (int)$producto_id
        ]);

        $item_existe = $result->fetch();
        $cantidad_actual = $item_existe ? (int)$item_existe['cantidad'] : 0;
        $cantidad_nueva = $cantidad_actual + $cantidad;

        if ($cantidad_nueva > (int)$producto['stock']) {
            return false;
        }

        if ($item_existe) {
            $query = "UPDATE carrito
                      SET cantidad = :cantidad, precio_unitario = :precio_unitario
                      WHERE usuario_id = :usuario_id AND producto_id = :producto_id";
            $result = $this->db->prepare($query);
            return $result->execute([
                ':usuario_id' => (int)$usuario_id,
                ':producto_id' => (int)$producto_id,
                ':cantidad' => $cantidad_nueva,
                ':precio_unitario' => (float)$producto['precio_actual']
            ]);
        }

        $query = "INSERT INTO carrito
                  (usuario_id, producto_id, cantidad, precio_unitario)
                  VALUES
                  (:usuario_id, :producto_id, :cantidad, :precio_unitario)";

        $result = $this->db->prepare($query);
        return $result->execute([
            ':usuario_id' => (int)$usuario_id,
            ':producto_id' => (int)$producto_id,
            ':cantidad' => $cantidad,
            ':precio_unitario' => (float)$producto['precio_actual']
        ]);
    }

    public function getCartByUser($usuario_id) {
        $query = "SELECT c.*, p.nombre, p.imagen_principal, p.tipo_producto, p.stock, p.estado
                  FROM carrito c
                  JOIN productos p ON c.producto_id = p.id
                  WHERE c.usuario_id = :usuario_id
                  ORDER BY c.fecha_agregado DESC";

        $result = $this->db->prepare($query);
        $result->bindValue(':usuario_id', (int)$usuario_id, PDO::PARAM_INT);
        $result->execute();
        return $result->fetchAll();
    }

    public function updateCartItem($usuario_id, $producto_id, $cantidad) {
        $cantidad = (int)$cantidad;

        if ($cantidad <= 0) {
            return $this->removeFromCart($usuario_id, $producto_id);
        }

        $stock_query = "SELECT stock FROM productos WHERE id = :producto_id AND estado = 'activo'";
        $stock_result = $this->db->prepare($stock_query);
        $stock_result->bindValue(':producto_id', (int)$producto_id, PDO::PARAM_INT);
        $stock_result->execute();
        $product = $stock_result->fetch();

        if (!$product || $cantidad > (int)$product['stock']) {
            return false;
        }

        $query = "UPDATE carrito
                  SET cantidad = :cantidad
                  WHERE usuario_id = :usuario_id AND producto_id = :producto_id";

        $result = $this->db->prepare($query);
        return $result->execute([
            ':usuario_id' => (int)$usuario_id,
            ':producto_id' => (int)$producto_id,
            ':cantidad' => $cantidad
        ]);
    }

    public function removeFromCart($usuario_id, $producto_id) {
        $query = "DELETE FROM carrito
                  WHERE usuario_id = :usuario_id AND producto_id = :producto_id";

        $result = $this->db->prepare($query);
        return $result->execute([
            ':usuario_id' => (int)$usuario_id,
            ':producto_id' => (int)$producto_id
        ]);
    }

    public function clearCart($usuario_id) {
        $query = "DELETE FROM carrito WHERE usuario_id = :usuario_id";
        $result = $this->db->prepare($query);
        return $result->execute([':usuario_id' => (int)$usuario_id]);
    }

    public function getCartTotal($usuario_id) {
        $query = "SELECT COALESCE(SUM(cantidad * precio_unitario), 0) AS total
                  FROM carrito
                  WHERE usuario_id = :usuario_id";

        $result = $this->db->prepare($query);
        $result->bindValue(':usuario_id', (int)$usuario_id, PDO::PARAM_INT);
        $result->execute();
        $row = $result->fetch();
        return (float)($row['total'] ?? 0);
    }

    public function getCartItemCount($usuario_id) {
        $query = "SELECT COALESCE(SUM(cantidad), 0) AS count
                  FROM carrito
                  WHERE usuario_id = :usuario_id";

        $result = $this->db->prepare($query);
        $result->bindValue(':usuario_id', (int)$usuario_id, PDO::PARAM_INT);
        $result->execute();
        $row = $result->fetch();
        return (int)($row['count'] ?? 0);
    }

    public function validateStock($usuario_id) {
        $items = $this->getCartByUser($usuario_id);
        $errors = [];

        foreach ($items as $item) {
            if ($item['estado'] !== 'activo') {
                $errors[] = $item['nombre'] . ' ya no esta disponible.';
                continue;
            }

            if ((int)$item['cantidad'] > (int)$item['stock']) {
                $errors[] = $item['nombre'] . ' solo tiene ' . (int)$item['stock'] . ' unidades disponibles.';
            }
        }

        return $errors;
    }
}
