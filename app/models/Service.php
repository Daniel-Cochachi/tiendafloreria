<?php
class Service {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function getActiveServices() {
        $query = "SELECT *
                  FROM servicios_adicionales
                  WHERE estado = 'activo'
                  ORDER BY tipo ASC, precio ASC";

        $result = $this->db->prepare($query);
        $result->execute();
        return $result->fetchAll();
    }

    public function getByIds($ids) {
        $ids = array_values(array_filter(array_map('intval', (array)$ids)));

        if (!$ids) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $query = "SELECT *
                  FROM servicios_adicionales
                  WHERE estado = 'activo' AND id IN ($placeholders)";

        $result = $this->db->prepare($query);
        $result->execute($ids);
        return $result->fetchAll();
    }
}
