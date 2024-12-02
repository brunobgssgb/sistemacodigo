<?php
class Order {
    private $conn;
    private $table_name = "orders";

    public $id;
    public $customer_id;
    public $app_id;
    public $code_id;
    public $order_date;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                (customer_id, app_id, code_id, order_date) 
                VALUES 
                (:customer_id, :app_id, :code_id, NOW())";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":customer_id", $this->customer_id);
        $stmt->bindParam(":app_id", $this->app_id);
        $stmt->bindParam(":code_id", $this->code_id);

        return $stmt->execute();
    }

    public function read() {
        $query = "SELECT o.*, c.name as customer_name, a.name as app_name, rc.code 
                 FROM " . $this->table_name . " o
                 LEFT JOIN customers c ON o.customer_id = c.id
                 LEFT JOIN apps a ON o.app_id = a.id
                 LEFT JOIN recharge_codes rc ON o.code_id = rc.id
                 ORDER BY o.order_date DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>