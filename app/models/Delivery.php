<?php
class Delivery {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function getDeliveryByOrder($order_id) {
        $query = "SELECT *
                  FROM entregas
                  WHERE orden_id = :orden_id
                  LIMIT 1";

        $result = $this->db->prepare($query);
        $result->bindValue(':orden_id', (int)$order_id, PDO::PARAM_INT);
        $result->execute();
        return $result->fetch();
    }

    public function assignRepartidor($delivery_id, $repartidor_id) {
        $query = "UPDATE entregas
                  SET repartidor_id = :repartidor_id, fecha_asignacion = NOW()
                  WHERE id = :id";

        $result = $this->db->prepare($query);
        return $result->execute([
            ':id' => (int)$delivery_id,
            ':repartidor_id' => (int)$repartidor_id
        ]);
    }

    public function updateDeliveryStatus($delivery_id, $status) {
        $fecha = $status === 'entregada' ? ', fecha_entrega = NOW()' : '';

        $query = "UPDATE entregas
                  SET estado_entrega = :estado_entrega$fecha
                  WHERE id = :id";

        $result = $this->db->prepare($query);
        return $result->execute([
            ':id' => (int)$delivery_id,
            ':estado_entrega' => $status
        ]);
    }

    public function getDeliveriesByRepartidor($repartidor_id) {
        $query = "SELECT e.*, o.numero_orden, o.total, u.nombre, u.apellido, u.telefono,
                         d.calle, d.numero, d.distrito, d.departamento_prov, d.referencia
                  FROM entregas e
                  JOIN ordenes o ON e.orden_id = o.id
                  JOIN usuarios u ON o.usuario_id = u.id
                  JOIN direcciones d ON o.direccion_id = d.id
                  WHERE e.repartidor_id = :repartidor_id
                  ORDER BY e.created_at DESC";

        $result = $this->db->prepare($query);
        $result->bindValue(':repartidor_id', (int)$repartidor_id, PDO::PARAM_INT);
        $result->execute();
        return $result->fetchAll();
    }
}
