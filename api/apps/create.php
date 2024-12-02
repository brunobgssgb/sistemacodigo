<?php
header('Content-Type: application/json');
require_once "../../config/database.php";
require_once "../../models/App.php";

$database = new Database();
$db = $database->getConnection();
$app = new App($db);

$app->name = $_POST['name'];
$app->price = $_POST['price'];

try {
    if($app->create()) {
        echo json_encode([
            "success" => true,
            "message" => "App created successfully"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Unable to create app"
        ]);
    }
} catch(PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}