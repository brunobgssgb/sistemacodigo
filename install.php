<?php
class Installer {
    private $host;
    private $username;
    private $password;
    private $dbname;
    private $conn;
    private $config_template = "<?php
class Database {
    private \$host = '[HOST]';
    private \$db_name = '[DBNAME]';
    private \$username = '[USERNAME]';
    private \$password = '[PASSWORD]';
    public \$conn;

    public function getConnection() {
        \$this->conn = null;

        try {
            \$this->conn = new PDO(
                'mysql:host=' . \$this->host . ';dbname=' . \$this->db_name,
                \$this->username,
                \$this->password
            );
            \$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException \$e) {
            echo 'Connection Error: ' . \$e->getMessage();
        }

        return \$this->conn;
    }
}
?>";

    public function __construct() {
        session_start();
    }

    public function showForm() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->handleInstallation();
        }

        return '
        <!DOCTYPE html>
        <html>
        <head>
            <title>System Installer</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body>
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="text-center">Recharge System Installer</h3>
                            </div>
                            <div class="card-body">
                                <form method="POST">
                                    <div class="mb-3">
                                        <label>Database Host:</label>
                                        <input type="text" name="host" class="form-control" value="localhost" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Database Name:</label>
                                        <input type="text" name="dbname" class="form-control" value="recharge_system" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Database Username:</label>
                                        <input type="text" name="username" class="form-control" value="root" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Database Password:</label>
                                        <input type="password" name="password" class="form-control">
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Install System</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
        </html>';
    }

    private function handleInstallation() {
        $this->host = $_POST['host'];
        $this->username = $_POST['username'];
        $this->password = $_POST['password'];
        $this->dbname = $_POST['dbname'];

        try {
            // Test connection
            $this->conn = new PDO(
                "mysql:host=$this->host",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Create database
            $this->createDatabase();
            
            // Create tables
            $this->createTables();
            
            // Create config file
            $this->createConfigFile();
            
            // Create necessary directories
            $this->createDirectories();

            return $this->showSuccess();

        } catch(PDOException $e) {
            return $this->showError($e->getMessage());
        }
    }

    private function createDatabase() {
        $this->conn->exec("CREATE DATABASE IF NOT EXISTS `$this->dbname`");
        $this->conn->exec("USE `$this->dbname`");
    }

    private function createTables() {
        $sql = "
        CREATE TABLE IF NOT EXISTS customers (
            id INT PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            phone VARCHAR(20) NOT NULL
        );

        CREATE TABLE IF NOT EXISTS apps (
            id INT PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(100) NOT NULL,
            price DECIMAL(10,2) NOT NULL
        );

        CREATE TABLE IF NOT EXISTS recharge_codes (
            id INT PRIMARY KEY AUTO_INCREMENT,
            app_id INT NOT NULL,
            code VARCHAR(50) NOT NULL UNIQUE,
            is_used BOOLEAN DEFAULT 0,
            FOREIGN KEY (app_id) REFERENCES apps(id)
        );

        CREATE TABLE IF NOT EXISTS orders (
            id INT PRIMARY KEY AUTO_INCREMENT,
            customer_id INT NOT NULL,
            app_id INT NOT NULL,
            code_id INT NOT NULL,
            order_date DATETIME NOT NULL,
            FOREIGN KEY (customer_id) REFERENCES customers(id),
            FOREIGN KEY (app_id) REFERENCES apps(id),
            FOREIGN KEY (code_id) REFERENCES recharge_codes(id)
        );";

        $this->conn->exec($sql);
    }

    private function createConfigFile() {
        if (!is_dir('config')) {
            mkdir('config', 0755, true);
        }

        $config_content = str_replace(
            ['[HOST]', '[DBNAME]', '[USERNAME]', '[PASSWORD]'],
            [$this->host, $this->dbname, $this->username, $this->password],
            $this->config_template
        );

        file_put_contents('config/database.php', $config_content);
    }

    private function createDirectories() {
        $directories = [
            'models',
            'views/customers',
            'views/apps',
            'views/codes',
            'views/orders'
        ];

        foreach ($directories as $dir) {
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
        }
    }

    private function showSuccess() {
        return '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Installation Complete</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body>
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h3 class="text-center">Installation Successful!</h3>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-success">
                                    <p>The system has been successfully installed!</p>
                                    <p>Please delete this installer file (install.php) for security reasons.</p>
                                </div>
                                <a href="index.php" class="btn btn-primary w-100">Go to System</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
        </html>';
    }

    private function showError($message) {
        return '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Installation Error</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body>
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-danger text-white">
                                <h3 class="text-center">Installation Failed</h3>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-danger">
                                    <p>Error: ' . htmlspecialchars($message) . '</p>
                                </div>
                                <a href="install.php" class="btn btn-primary w-100">Try Again</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
        </html>';
    }
}

$installer = new Installer();
echo $installer->showForm();
?>