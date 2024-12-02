<?php
header('Content-Type: application/json');
require_once "../../config/database.php";
require_once "../../models/Order.php";
require_once "../../models/RechargeCode.php";

$database = new Database();
$db = $database->getConnection();

$order = new Order($db);
$code = new RechargeCode($db);

$order->customer_id = $_POST['customer_id'];
$order->app_id = $_POST['app_id'];
$order->code_id = $_POST['code_id'];

try {
    if($order->create()) {
        // Mark the code as used
        $code->markAsUsed($_POST['code_id']);
        
        echo json_encode([
            "success" => true,
            "message" => "Order created successfully"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Unable to create order"
        ]);
    }
} catch(PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}