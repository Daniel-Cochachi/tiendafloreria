<?php
class Address {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function addAddress($data) {
        try {
            $this->db->beginTransaction();

            if (!empty($data['es_principal']) || count($this->getAddressesByUser($data['usuario_id'])) === 0) {
                $this->clearPrimary($data['usuario_id']);
                $data['es_principal'] = true;
            }

            $query = "INSERT INTO direcciones
                      (usuario_id, tipo, calle, numero, departamento, distrito, provincia, departamento_prov, codigo_postal, referencia, es_principal)
                      VALUES
                      (:usuario_id, :tipo, :calle, :numero, :departamento, :distrito, :provincia, :departamento_prov, :codigo_postal, :referencia, :es_principal)";

            $result = $this->db->prepare($query);

            $success = $result->execute([
                ':usuario_id' => (int)$data['usuario_id'],
                ':tipo' => $data['tipo'] ?? 'domicilio',
                ':calle' => trim($data['calle']),
                ':numero' => $data['numero'] ?? null,
                ':departamento' => $data['departamento'] ?? null,
                ':distrito' => trim($data['distrito']),
                ':provincia' => trim($data['provincia']),
                ':departamento_prov' => trim($data['departamento_prov']),
                ':codigo_postal' => $data['codigo_postal'] ?? null,
                ':referencia' => $data['referencia'] ?? null,
                ':es_principal' => !empty($data['es_principal']) ? 1 : 0
            ]);

            $this->db->commit();
            return $success;
        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            return false;
        }
    }

    public function getAddressesByUser($usuario_id) {
        $query = "SELECT * FROM direcciones
                  WHERE usuario_id = :usuario_id
                  ORDER BY es_principal DESC, created_at DESC";

        $result = $this->db->prepare($query);
        $result->bindValue(':usuario_id', (int)$usuario_id, PDO::PARAM_INT);
        $result->execute();
        return $result->fetchAll();
    }

    public function getAddressById($id) {
        $query = "SELECT * FROM direcciones WHERE id = :id";

        $result = $this->db->prepare($query);
        $result->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $result->execute();
        return $result->fetch();
    }

    public function belongsToUser($id, $usuario_id) {
        $query = "SELECT id FROM direcciones WHERE id = :id AND usuario_id = :usuario_id";
        $result = $this->db->prepare($query);
        $result->execute([
            ':id' => (int)$id,
            ':usuario_id' => (int)$usuario_id
        ]);

        return (bool)$result->fetch();
    }

    public function updateAddress($id, $data) {
        if (!empty($data['es_principal'])) {
            $this->clearPrimary($data['usuario_id']);
        }

        $query = "UPDATE direcciones SET
                  calle = :calle,
                  numero = :numero,
                  departamento = :departamento,
                  distrito = :distrito,
                  provincia = :provincia,
                  departamento_prov = :departamento_prov,
                  codigo_postal = :codigo_postal,
                  referencia = :referencia,
                  tipo = :tipo,
                  es_principal = :es_principal
                  WHERE id = :id AND usuario_id = :usuario_id";

        $result = $this->db->prepare($query);

        return $result->execute([
            ':id' => (int)$id,
            ':usuario_id' => (int)$data['usuario_id'],
            ':calle' => trim($data['calle']),
            ':numero' => $data['numero'] ?? null,
            ':departamento' => $data['departamento'] ?? null,
            ':distrito' => trim($data['distrito']),
            ':provincia' => trim($data['provincia']),
            ':departamento_prov' => trim($data['departamento_prov']),
            ':codigo_postal' => $data['codigo_postal'] ?? null,
            ':referencia' => $data['referencia'] ?? null,
            ':tipo' => $data['tipo'] ?? 'domicilio',
            ':es_principal' => !empty($data['es_principal']) ? 1 : 0
        ]);
    }

    public function deleteAddress($id, $usuario_id = null) {
        $address = $this->getAddressById($id);

        if (!$address || ($usuario_id !== null && (int)$address['usuario_id'] !== (int)$usuario_id)) {
            return false;
        }

        $query = "DELETE FROM direcciones WHERE id = :id";
        $result = $this->db->prepare($query);
        $success = $result->execute([':id' => (int)$id]);

        if ($success && !empty($address['es_principal'])) {
            $this->promoteFirstAddress($address['usuario_id']);
        }

        return $success;
    }

    public function setPrimaryAddress($usuario_id, $address_id) {
        if (!$this->belongsToUser($address_id, $usuario_id)) {
            return false;
        }

        $this->clearPrimary($usuario_id);

        $query = "UPDATE direcciones SET es_principal = TRUE WHERE id = :id";
        $result = $this->db->prepare($query);
        return $result->execute([':id' => (int)$address_id]);
    }

    public function getPrimaryAddress($usuario_id) {
        $query = "SELECT * FROM direcciones
                  WHERE usuario_id = :usuario_id AND es_principal = TRUE
                  LIMIT 1";

        $result = $this->db->prepare($query);
        $result->bindValue(':usuario_id', (int)$usuario_id, PDO::PARAM_INT);
        $result->execute();
        return $result->fetch();
    }

    private function clearPrimary($usuario_id) {
        $query = "UPDATE direcciones SET es_principal = FALSE WHERE usuario_id = :usuario_id";
        $result = $this->db->prepare($query);
        return $result->execute([':usuario_id' => (int)$usuario_id]);
    }

    private function promoteFirstAddress($usuario_id) {
        $query = "UPDATE direcciones
                  SET es_principal = TRUE
                  WHERE usuario_id = :usuario_id
                  ORDER BY created_at DESC
                  LIMIT 1";

        $result = $this->db->prepare($query);
        return $result->execute([':usuario_id' => (int)$usuario_id]);
    }
}
