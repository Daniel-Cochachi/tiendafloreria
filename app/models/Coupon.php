<?php
class Coupon {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function getActiveByCode($code) {
        $query = "SELECT *
                  FROM cupones
                  WHERE codigo = :codigo
                  AND estado = 'activo'
                  AND NOW() BETWEEN fecha_inicio AND fecha_fin
                  AND (usos_maximos IS NULL OR usos_actuales < usos_maximos)
                  LIMIT 1";

        $result = $this->db->prepare($query);
        $result->bindValue(':codigo', strtoupper(trim($code)));
        $result->execute();
        return $result->fetch();
    }

    public function calculateDiscount($coupon, $subtotal) {
        if (!$coupon) {
            return ['valid' => false, 'discount' => 0, 'message' => 'Cupon no encontrado o vencido.'];
        }

        $subtotal = (float)$subtotal;
        $minimum = $coupon['valor_minimo_compra'] !== null ? (float)$coupon['valor_minimo_compra'] : 0;

        if ($minimum > 0 && $subtotal < $minimum) {
            return [
                'valid' => false,
                'discount' => 0,
                'message' => 'Este cupon requiere una compra minima de ' . money($minimum) . '.'
            ];
        }

        if ($coupon['tipo'] === 'porcentaje') {
            $discount = $subtotal * ((float)$coupon['valor'] / 100);
        } else {
            $discount = (float)$coupon['valor'];
        }

        $discount = min(round($discount, 2), $subtotal);

        return [
            'valid' => true,
            'discount' => $discount,
            'message' => 'Cupon aplicado: -' . money($discount)
        ];
    }

    public function getAllCoupons() {
        $query = "SELECT c.*, u.email AS creador_email
                  FROM cupones c
                  LEFT JOIN usuarios u ON c.usuario_id_creador = u.id
                  ORDER BY c.created_at DESC";

        $result = $this->db->prepare($query);
        $result->execute();
        return $result->fetchAll();
    }

    public function addCoupon($data) {
        $query = "INSERT INTO cupones
                  (codigo, descripcion, tipo, valor, valor_minimo_compra, usos_maximos,
                   fecha_inicio, fecha_fin, usuario_id_creador, estado)
                  VALUES
                  (:codigo, :descripcion, :tipo, :valor, :valor_minimo_compra, :usos_maximos,
                   :fecha_inicio, :fecha_fin, :usuario_id_creador, :estado)";

        $result = $this->db->prepare($query);
        return $result->execute([
            ':codigo' => strtoupper(trim($data['codigo'])),
            ':descripcion' => $data['descripcion'] ?? null,
            ':tipo' => $data['tipo'] ?? 'porcentaje',
            ':valor' => (float)$data['valor'],
            ':valor_minimo_compra' => $data['valor_minimo_compra'] !== '' ? (float)$data['valor_minimo_compra'] : null,
            ':usos_maximos' => $data['usos_maximos'] !== '' ? (int)$data['usos_maximos'] : null,
            ':fecha_inicio' => $this->normalizeDateTime($data['fecha_inicio']),
            ':fecha_fin' => $this->normalizeDateTime($data['fecha_fin']),
            ':usuario_id_creador' => $data['usuario_id_creador'] ?? null,
            ':estado' => $data['estado'] ?? 'activo'
        ]);
    }

    public function deleteCoupon($id) {
        $query = "UPDATE cupones SET estado = 'inactivo' WHERE id = :id";
        $result = $this->db->prepare($query);
        return $result->execute([':id' => (int)$id]);
    }

    private function normalizeDateTime($value) {
        $value = str_replace('T', ' ', trim($value));
        return strlen($value) === 16 ? $value . ':00' : $value;
    }
}
