<?php
header('Content-Type: application/json');
require_once "../../config/database.php";
require_once "../../models/Customer.php";

$database = new Database();
$db = $database->getConnection();
$customer = new Customer($db);

$customer->name = $_POST['name'];
$customer->email = $_POST['email'];
$customer->phone = $_POST['phone'];

try {
    if($customer->create()) {
        echo json_encode([
            "success" => true,
            "message" => "Customer created successfully"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Unable to create customer"
        ]);
    }
} catch(PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}