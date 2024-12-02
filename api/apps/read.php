<?php
header('Content-Type: application/json');
require_once "../../config/database.php";
require_once "../../models/App.php";

$database = new Database();
$db = $database->getConnection();
$app = new App($db);

$stmt = $app->read();
$apps = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $apps[] = $row;
}

echo json_encode($apps);