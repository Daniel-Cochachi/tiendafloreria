<?php
class Order {
    private $db;
    private $last_error;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function getLastError() {
        return $this->last_error;
    }

    public function createOrder($data) {
        $numero_orden = $this->generateOrderNumber();

        $query = "INSERT INTO ordenes
                  (numero_orden, usuario_id, subtotal, descuento_total,
                   costo_envio, total, direccion_id, fecha_entrega_solicitada,
                   metodo_pago_id, notas_especiales, estado_orden, estado_pago)
                  VALUES
                  (:numero_orden, :usuario_id, :subtotal, :descuento_total,
                   :costo_envio, :total, :direccion_id, :fecha_entrega_solicitada,
                   :metodo_pago_id, :notas_especiales, 'pendiente', 'pendiente')";

        $result = $this->db->prepare($query);

        $success = $result->execute([
            ':numero_orden' => $numero_orden,
            ':usuario_id' => (int)$data['usuario_id'],
            ':subtotal' => (float)$data['subtotal'],
            ':descuento_total' => (float)($data['descuento_total'] ?? 0),
            ':costo_envio' => (float)($data['costo_envio'] ?? 0),
            ':total' => (float)$data['total'],
            ':direccion_id' => (int)$data['direccion_id'],
            ':fecha_entrega_solicitada' => $data['fecha_entrega_solicitada'] ?: null,
            ':metodo_pago_id' => $data['metodo_pago_id'] ? (int)$data['metodo_pago_id'] : null,
            ':notas_especiales' => $data['notas_especiales'] ?? null
        ]);

        return $success ? $this->db->lastInsertId() : false;
    }

    public function createOrderFromCart($data, $items, $services = [], $coupon = null) {
        $this->last_error = null;

        try {
            $this->db->beginTransaction();

            $orden_id = $this->createOrder($data);

            if (!$orden_id) {
                throw new Exception('No se pudo crear la orden.');
            }

            foreach ($items as $item) {
                $product = $this->lockProduct($item['producto_id']);

                if (!$product || $product['estado'] !== 'activo') {
                    throw new Exception('Un producto del carrito ya no esta disponible.');
                }

                if ((int)$product['stock'] < (int)$item['cantidad']) {
                    throw new Exception($item['nombre'] . ' no tiene stock suficiente.');
                }

                $this->addOrderDetail($orden_id, $item['producto_id'], $item['cantidad'], $item['precio_unitario']);
                $this->discountStock($item['producto_id'], $item['cantidad']);
            }

            foreach ($services as $service) {
                $this->addOrderService($orden_id, $service['id'], $service['precio']);
            }

            if ($coupon) {
                $this->registerCouponUse($coupon['id'], $data['usuario_id'], $orden_id);
            }

            if (!empty($data['metodo_pago_id'])) {
                $this->createTransaction($orden_id, $data['metodo_pago_id'], $data['total']);
            }

            $this->createDelivery($orden_id);

            $this->db->commit();
            return $orden_id;
        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            $this->last_error = $e->getMessage();
            return false;
        }
    }

    public function addOrderDetail($orden_id, $producto_id, $cantidad, $precio_unitario) {
        $subtotal = (int)$cantidad * (float)$precio_unitario;

        $query = "INSERT INTO orden_detalles
                  (orden_id, producto_id, cantidad, precio_unitario, subtotal)
                  VALUES
                  (:orden_id, :producto_id, :cantidad, :precio_unitario, :subtotal)";

        $result = $this->db->prepare($query);

        return $result->execute([
            ':orden_id' => (int)$orden_id,
            ':producto_id' => (int)$producto_id,
            ':cantidad' => (int)$cantidad,
            ':precio_unitario' => (float)$precio_unitario,
            ':subtotal' => $subtotal
        ]);
    }

    public function addOrderService($orden_id, $servicio_id, $precio) {
        $query = "INSERT INTO orden_servicios (orden_id, servicio_id, precio)
                  VALUES (:orden_id, :servicio_id, :precio)";

        $result = $this->db->prepare($query);
        return $result->execute([
            ':orden_id' => (int)$orden_id,
            ':servicio_id' => (int)$servicio_id,
            ':precio' => (float)$precio
        ]);
    }

    public function getOrderById($id) {
        $query = "SELECT o.*,
                         u.nombre, u.apellido, u.email, u.telefono,
                         d.calle, d.numero, d.departamento, d.distrito, d.provincia, d.departamento_prov, d.referencia,
                         mp.nombre AS metodo_pago_nombre,
                         e.estado AS estado_entrega
                  FROM ordenes o
                  JOIN usuarios u ON o.usuario_id = u.id
                  JOIN direcciones d ON o.direccion_id = d.id
                  LEFT JOIN metodos_pago mp ON o.metodo_pago_id = mp.id
                  LEFT JOIN entregas e ON e.orden_id = o.id
                  WHERE o.id = :id";

        $result = $this->db->prepare($query);
        $result->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $result->execute();
        return $result->fetch();
    }

    public function getOrdersByUser($usuario_id) {
        $query = "SELECT o.*, mp.nombre AS metodo_pago_nombre
                  FROM ordenes o
                  LEFT JOIN metodos_pago mp ON o.metodo_pago_id = mp.id
                  WHERE o.usuario_id = :usuario_id
                  ORDER BY o.created_at DESC";

        $result = $this->db->prepare($query);
        $result->bindValue(':usuario_id', (int)$usuario_id, PDO::PARAM_INT);
        $result->execute();
        return $result->fetchAll();
    }

    public function getOrderDetails($orden_id) {
        $query = "SELECT od.*, p.nombre, p.imagen_principal, p.tipo_producto
                  FROM orden_detalles od
                  JOIN productos p ON od.producto_id = p.id
                  WHERE od.orden_id = :orden_id";

        $result = $this->db->prepare($query);
        $result->bindValue(':orden_id', (int)$orden_id, PDO::PARAM_INT);
        $result->execute();
        return $result->fetchAll();
    }

    public function getOrderServices($orden_id) {
        $query = "SELECT os.*, s.nombre, s.tipo
                  FROM orden_servicios os
                  JOIN servicios_adicionales s ON os.servicio_id = s.id
                  WHERE os.orden_id = :orden_id";

        $result = $this->db->prepare($query);
        $result->bindValue(':orden_id', (int)$orden_id, PDO::PARAM_INT);
        $result->execute();
        return $result->fetchAll();
    }

    public function updateOrderStatus($id, $estado) {
        $query = "UPDATE ordenes SET estado_orden = :estado WHERE id = :id";

        $result = $this->db->prepare($query);
        return $result->execute([
            ':id' => (int)$id,
            ':estado' => $estado
        ]);
    }

    public function updatePaymentStatus($id, $estado) {
        $query = "UPDATE ordenes SET estado_pago = :estado WHERE id = :id";

        $result = $this->db->prepare($query);
        return $result->execute([
            ':id' => (int)$id,
            ':estado' => $estado
        ]);
    }

    public function updateOrderAndPayment($id, $estado_orden, $estado_pago) {
        try {
            $this->db->beginTransaction();

            $current_query = "SELECT estado_orden FROM ordenes WHERE id = :id FOR UPDATE";
            $current_result = $this->db->prepare($current_query);
            $current_result->bindValue(':id', (int)$id, PDO::PARAM_INT);
            $current_result->execute();
            $current = $current_result->fetch();

            if (!$current) {
                throw new Exception('Orden no encontrada.');
            }

            $query = "UPDATE ordenes
                      SET estado_orden = :estado_orden, estado_pago = :estado_pago
                      WHERE id = :id";

            $result = $this->db->prepare($query);
            $ok = $result->execute([
                ':id' => (int)$id,
                ':estado_orden' => $estado_orden,
                ':estado_pago' => $estado_pago
            ]);

            if ($ok && $estado_orden === 'cancelada' && $current['estado_orden'] !== 'cancelada') {
                foreach ($this->getOrderDetails($id) as $detail) {
                    $restore = "UPDATE productos SET stock = stock + :cantidad WHERE id = :producto_id";
                    $restore_result = $this->db->prepare($restore);
                    $restore_result->execute([
                        ':cantidad' => (int)$detail['cantidad'],
                        ':producto_id' => (int)$detail['producto_id']
                    ]);
                }
            }

            if ($ok) {
                $this->syncDeliveryStatus($id, $estado_orden);
            }

            $this->db->commit();
            return $ok;
        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            $this->last_error = $e->getMessage();
            return false;
        }
    }

    public function cancelOrder($id, $usuario_id = null) {
        $this->last_error = null;

        try {
            $this->db->beginTransaction();

            $query = "SELECT * FROM ordenes WHERE id = :id FOR UPDATE";
            $result = $this->db->prepare($query);
            $result->bindValue(':id', (int)$id, PDO::PARAM_INT);
            $result->execute();
            $order = $result->fetch();

            if (!$order) {
                throw new Exception('Orden no encontrada.');
            }

            if ($usuario_id !== null && (int)$order['usuario_id'] !== (int)$usuario_id) {
                throw new Exception('No tienes permiso para cancelar esta orden.');
            }

            if ($order['estado_orden'] !== 'pendiente') {
                throw new Exception('Solo se pueden cancelar ordenes pendientes.');
            }

            foreach ($this->getOrderDetails($id) as $detail) {
                $restore = "UPDATE productos SET stock = stock + :cantidad WHERE id = :producto_id";
                $restore_result = $this->db->prepare($restore);
                $restore_result->execute([
                    ':cantidad' => (int)$detail['cantidad'],
                    ':producto_id' => (int)$detail['producto_id']
                ]);
            }

            $this->updateOrderStatus($id, 'cancelada');

            $transaction = "UPDATE transacciones SET estado = 'cancelada' WHERE orden_id = :orden_id";
            $transaction_result = $this->db->prepare($transaction);
            $transaction_result->execute([':orden_id' => (int)$id]);

            $delivery = "UPDATE entregas SET estado = 'fallida' WHERE orden_id = :orden_id";
            $delivery_result = $this->db->prepare($delivery);
            $delivery_result->execute([':orden_id' => (int)$id]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            $this->last_error = $e->getMessage();
            return false;
        }
    }

    public function getAllOrders($limit = null, $offset = 0) {
        $query = "SELECT o.*, u.nombre, u.apellido, u.email, mp.nombre AS metodo_pago_nombre
                  FROM ordenes o
                  JOIN usuarios u ON o.usuario_id = u.id
                  LEFT JOIN metodos_pago mp ON o.metodo_pago_id = mp.id
                  ORDER BY o.created_at DESC";

        if ($limit !== null) {
            $query .= " LIMIT :limit OFFSET :offset";
        }

        $result = $this->db->prepare($query);

        if ($limit !== null) {
            $result->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $result->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        }

        $result->execute();
        return $result->fetchAll();
    }

    public function countAllOrders() {
        $query = "SELECT COUNT(*) AS total FROM ordenes";
        $result = $this->db->prepare($query);
        $result->execute();
        $row = $result->fetch();
        return (int)($row['total'] ?? 0);
    }

    public function getTotalSales() {
        $query = "SELECT COALESCE(SUM(total), 0) AS total_ventas, COUNT(*) AS total_ordenes
                  FROM ordenes
                  WHERE estado_pago = 'pagado'";

        $result = $this->db->prepare($query);
        $result->execute();
        return $result->fetch();
    }

    public function getDashboardStats() {
        $query = "SELECT
                    COUNT(*) AS total_ordenes,
                    SUM(CASE WHEN estado_orden = 'pendiente' THEN 1 ELSE 0 END) AS ordenes_pendientes,
                    COALESCE(SUM(CASE WHEN estado_pago = 'pagado' THEN total ELSE 0 END), 0) AS ventas_pagadas,
                    COALESCE(SUM(total), 0) AS ventas_brutas
                  FROM ordenes";

        $result = $this->db->prepare($query);
        $result->execute();
        return $result->fetch();
    }

    private function lockProduct($producto_id) {
        $query = "SELECT id, nombre, stock, estado
                  FROM productos
                  WHERE id = :id
                  FOR UPDATE";

        $result = $this->db->prepare($query);
        $result->bindValue(':id', (int)$producto_id, PDO::PARAM_INT);
        $result->execute();
        return $result->fetch();
    }

    private function discountStock($producto_id, $cantidad) {
        $query = "UPDATE productos
                  SET stock = stock - :cantidad
                  WHERE id = :producto_id";

        $result = $this->db->prepare($query);
        return $result->execute([
            ':producto_id' => (int)$producto_id,
            ':cantidad' => (int)$cantidad
        ]);
    }

    private function registerCouponUse($cupon_id, $usuario_id, $orden_id) {
        $insert = "INSERT INTO cupones_usados (cupon_id, usuario_id, orden_id)
                   VALUES (:cupon_id, :usuario_id, :orden_id)";
        $insert_result = $this->db->prepare($insert);
        $insert_result->execute([
            ':cupon_id' => (int)$cupon_id,
            ':usuario_id' => (int)$usuario_id,
            ':orden_id' => (int)$orden_id
        ]);

        $update = "UPDATE cupones SET usos_actuales = usos_actuales + 1 WHERE id = :cupon_id";
        $update_result = $this->db->prepare($update);
        return $update_result->execute([':cupon_id' => (int)$cupon_id]);
    }

    private function createTransaction($orden_id, $metodo_pago_id, $monto) {
        $query = "INSERT INTO transacciones
                  (orden_id, metodo_pago_id, monto, estado, descripcion)
                  VALUES
                  (:orden_id, :metodo_pago_id, :monto, 'pendiente', 'Transaccion creada desde checkout')";

        $result = $this->db->prepare($query);
        return $result->execute([
            ':orden_id' => (int)$orden_id,
            ':metodo_pago_id' => (int)$metodo_pago_id,
            ':monto' => (float)$monto
        ]);
    }

    private function createDelivery($orden_id) {
        $query = "INSERT INTO entregas (orden_id, estado)
                  VALUES (:orden_id, 'pendiente')";

        $result = $this->db->prepare($query);
        return $result->execute([':orden_id' => (int)$orden_id]);
    }

    private function syncDeliveryStatus($orden_id, $estado_orden) {
        $map = [
            'enviada' => 'en_camino',
            'entregada' => 'entregado',
            'cancelada' => 'fallido',
            'devuelto' => 'fallido'
        ];

        if (!isset($map[$estado_orden])) {
            return true;
        }

        $query = "UPDATE entregas SET estado = :estado WHERE orden_id = :orden_id";
        $result = $this->db->prepare($query);
        return $result->execute([
            ':estado' => $map[$estado_orden],
            ':orden_id' => (int)$orden_id
        ]);
    }

    private function generateOrderNumber() {
        return 'ORD-' . date('Ymd') . '-' . strtoupper(substr(bin2hex(random_bytes(4)), 0, 8));
    }
}
