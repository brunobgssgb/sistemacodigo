<?php
require_once "config/database.php";
require_once "models/Order.php";

$database = new Database();
$db = $database->getConnection();

$order = new Order($db);
$orders = $order->read();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Recharge Code System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Recharge Code System</h1>
        
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Customers</h5>
                        <a href="views/customers/create.php" class="btn btn-primary">Add Customer</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Apps</h5>
                        <a href="views/apps/create.php" class="btn btn-primary">Add App</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Recharge Codes</h5>
                        <a href="views/codes/create.php" class="btn btn-primary">Add Code</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Orders</h5>
                        <a href="views/orders/create.php" class="btn btn-primary">Create Order</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <h2>Recent Orders</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>App</th>
                        <th>Code</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $orders->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['customer_name'] ?></td>
                            <td><?= $row['app_name'] ?></td>
                            <td><?= $row['code'] ?></td>
                            <td><?= $row['order_date'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>