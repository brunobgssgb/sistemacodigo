<?php
class RechargeCode {
    private $conn;
    private $table_name = "recharge_codes";

    public $id;
    public $app_id;
    public $code;
    public $is_used;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (app_id, code, is_used) VALUES (:app_id, :code, :is_used)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":app_id", $this->app_id);
        $stmt->bindParam(":code", $this->code);
        $stmt->bindParam(":is_used", $this->is_used);

        return $stmt->execute();
    }

    public function read() {
        $query = "SELECT r.*, a.name as app_name FROM " . $this->table_name . " r 
                 LEFT JOIN apps a ON r.app_id = a.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function markAsUsed($id) {
        $query = "UPDATE " . $this->table_name . " SET is_used = 1 WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function getAvailableByApp($app_id) {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE app_id = :app_id AND is_used = 0";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":app_id", $app_id);
        $stmt->execute();
        return $stmt;
    }
}
?>