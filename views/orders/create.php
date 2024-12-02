<?php
require_once "../../config/database.php";
require_once "../../models/Order.php";
require_once "../../models/Customer.php";
require_once "../../models/App.php";
require_once "../../models/RechargeCode.php";

$database = new Database();
$db = $database->getConnection();

$customer = new Customer($db);
$customers = $customer->read();

$app = new App($db);
$apps = $app->read();

$code = new RechargeCode($db);
$codes = $code->read();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order = new Order($db);
    
    $order->customer_id = $_POST["customer_id"];
    $order->app_id = $_POST["app_id"];
    $order->code_id = $_POST["code_id"];
    
    if($order->create()) {
        $code->markAsUsed($_POST["code_id"]);
        header("Location: index.php");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Create New Order</h2>
        <form method="POST">
            <div class="mb-3">
                <label>Customer:</label>
                <select name="customer_id" class="form-control" required>
                    <?php while ($row = $customers->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label>App:</label>
                <select name="app_id" class="form-control" required>
                    <?php while ($row = $apps->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?= $row['id'] ?>"><?= $row['name'] ?> - $<?= $row['price'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Recharge Code:</label>
                <select name="code_id" class="form-control" required>
                    <?php while ($row = $codes->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?= $row['id'] ?>"><?= $row['code'] ?> (<?= $row['app_name'] ?>)</option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Create Order</button>
        </form>
    </div>
</body>
</html>