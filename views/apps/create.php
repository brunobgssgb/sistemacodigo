<?php
require_once "../../config/database.php";
require_once "../../models/App.php";

$database = new Database();
$db = $database->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $app = new App($db);
    
    $app->name = $_POST["name"];
    $app->price = $_POST["price"];
    
    if($app->create()) {
        header("Location: index.php");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Add New App</h2>
        <form method="POST">
            <div class="mb-3">
                <label>Name:</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Price:</label>
                <input type="number" step="0.01" name="price" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Save App</button>
        </form>
    </div>
</body>
</html>