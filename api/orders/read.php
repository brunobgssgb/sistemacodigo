<?php
header('Content-Type: application/json');
require_once "../../config/database.php";
require_once "../../models/Order.php";

$database = new Database();
$db = $database->getConnection();
$order = new Order($db);

$stmt = $order->read();
$orders = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $orders[] = $row;
}

echo json_encode($orders);