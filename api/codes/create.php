<?php
header('Content-Type: application/json');
require_once "../../config/database.php";
require_once "../../models/RechargeCode.php";

$database = new Database();
$db = $database->getConnection();
$code = new RechargeCode($db);

$code->app_id = $_POST['app_id'];
$code->code = $_POST['code'];
$code->is_used = 0;

try {
    if($code->create()) {
        echo json_encode([
            "success" => true,
            "message" => "Recharge code created successfully"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Unable to create recharge code"
        ]);
    }
} catch(PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}