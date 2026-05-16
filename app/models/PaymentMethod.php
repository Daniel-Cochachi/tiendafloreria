<?php
class PaymentMethod {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function getActiveMethods() {
        $query = "SELECT *
                  FROM metodos_pago
                  WHERE es_activo = TRUE
                  ORDER BY id ASC";

        $result = $this->db->prepare($query);
        $result->execute();
        return $result->fetchAll();
    }

    public function getById($id) {
        $query = "SELECT *
                  FROM metodos_pago
                  WHERE id = :id AND es_activo = TRUE
                  LIMIT 1";

        $result = $this->db->prepare($query);
        $result->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $result->execute();
        return $result->fetch();
    }
}
