<?php
require_once "../../config/database.php";
require_once "../../models/Customer.php";

$database = new Database();
$db = $database->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer = new Customer($db);
    
    $customer->name = $_POST["name"];
    $customer->email = $_POST["email"];
    $customer->phone = $_POST["phone"];
    
    if($customer->create()) {
        header("Location: index.php");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Add New Customer</h2>
        <form method="POST">
            <div class="mb-3">
                <label>Name:</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Phone:</label>
                <input type="tel" name="phone" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Customer</button>
        </form>
    </div>
</body>
</html>