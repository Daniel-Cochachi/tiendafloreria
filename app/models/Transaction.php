<?php
class Transaction {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function createTransaction($data) {
        $query = "INSERT INTO transacciones
                  (orden_id, metodo_pago_id, monto, estado, codigo_transaccion)
                  VALUES
                  (:orden_id, :metodo_pago_id, :monto, :estado, :codigo_transaccion)";

        $result = $this->db->prepare($query);

        $success = $result->execute([
            ':orden_id' => (int)$data['orden_id'],
            ':metodo_pago_id' => (int)$data['metodo_pago_id'],
            ':monto' => (float)$data['monto'],
            ':estado' => $data['estado'] ?? 'pendiente',
            ':codigo_transaccion' => $data['codigo_transaccion'] ?? null
        ]);

        return $success ? $this->db->lastInsertId() : false;
    }

    public function getTransactionByOrder($order_id) {
        $query = "SELECT *
                  FROM transacciones
                  WHERE orden_id = :orden_id
                  LIMIT 1";

        $result = $this->db->prepare($query);
        $result->bindValue(':orden_id', (int)$order_id, PDO::PARAM_INT);
        $result->execute();
        return $result->fetch();
    }

    public function updateTransactionStatus($id, $status) {
        $query = "UPDATE transacciones
                  SET estado = :estado
                  WHERE id = :id";

        $result = $this->db->prepare($query);
        return $result->execute([
            ':id' => (int)$id,
            ':estado' => $status
        ]);
    }
}
