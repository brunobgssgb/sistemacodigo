<?php
header('Content-Type: application/json');
require_once "../../config/database.php";
require_once "../../models/RechargeCode.php";

$database = new Database();
$db = $database->getConnection();
$code = new RechargeCode($db);

$app_id = isset($_GET['app_id']) ? $_GET['app_id'] : 0;

$stmt = $code->getAvailableByApp($app_id);
$codes = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $codes[] = $row;
}

echo json_encode($codes);