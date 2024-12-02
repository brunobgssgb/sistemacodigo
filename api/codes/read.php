<?php
header('Content-Type: application/json');
require_once "../../config/database.php";
require_once "../../models/RechargeCode.php";

$database = new Database();
$db = $database->getConnection();
$code = new RechargeCode($db);

$stmt = $code->read();
$codes = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $codes[] = $row;
}

echo json_encode($codes);