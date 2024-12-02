<?php
header('Content-Type: application/json');
require_once "../../config/database.php";
require_once "../../models/Customer.php";

$database = new Database();
$db = $database->getConnection();
$customer = new Customer($db);

$stmt = $customer->read();
$customers = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $customers[] = $row;
}

echo json_encode($customers);