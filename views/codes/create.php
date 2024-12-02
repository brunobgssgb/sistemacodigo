<?php
require_once "../../config/database.php";
require_once "../../models/RechargeCode.php";
require_once "../../models/App.php";

$database = new Database();
$db = $database->getConnection();

$app = new App($db);
$apps = $app->read();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $code = new RechargeCode($db);
    
    $code->app_id = $_POST["app_id"];
    $code->code = $_POST["code"];
    $code->is_used = 0;
    
    if($code->create()) {
        header("Location: index.php");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Recharge Code</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Add New Recharge Code</h2>
        <form method="POST">
            <div class="mb-3">
                <label>App:</label>
                <select name="app_id" class="form-control" required>
                    <?php while ($row = $apps->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Code:</label>
                <input type="text" name="code" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Code</button>
        </form>
    </div>
</body>
</html>