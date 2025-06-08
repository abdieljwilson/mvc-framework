<?php

class Database extends PDO {
    private $host = 'localhost';
    private $dbname = 'mvc';
    private $username = 'root';
    private $password = 'root';
    private $port = 3306;
    
    public function __construct() {
        // Try multiple connection methods
        $connections = [
            // Method 1: Standard localhost
            "mysql:host={$this->host};port={$this->port};dbname={$this->dbname};charset=utf8mb4",
            
            // Method 2: 127.0.0.1 instead of localhost
            "mysql:host=127.0.0.1;port={$this->port};dbname={$this->dbname};charset=utf8mb4",
            
            // Method 3: Unix socket (common on Mac/Linux)
            "mysql:unix_socket=/tmp/mysql.sock;dbname={$this->dbname};charset=utf8mb4",
            
            // Method 4: MAMP default socket
            "mysql:unix_socket=/Applications/MAMP/tmp/mysql/mysql.sock;dbname={$this->dbname};charset=utf8mb4",
            
            // Method 5: XAMPP/Homebrew socket
            "mysql:unix_socket=/usr/local/mysql/mysql.sock;dbname={$this->dbname};charset=utf8mb4",
            
            // Method 6: Alternative socket locations
            "mysql:unix_socket=/var/mysql/mysql.sock;dbname={$this->dbname};charset=utf8mb4"
        ];
        
        $connected = false;
        $lastError = '';
        
        foreach ($connections as $dsn) {
            try {
                parent::__construct($dsn, $this->username, $this->password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_TIMEOUT => 5
                ]);
                $connected = true;
                echo "<!-- Connected using: $dsn -->\n";
                break;
            } catch (PDOException $e) {
                $lastError = $e->getMessage();
                continue;
            }
        }
        
        if (!$connected) {
            $this->showDiagnostics();
            die('Database connection failed. Last error: ' . $lastError);
        }
    }
    
    private function showDiagnostics() {
        echo "<h3>Database Connection Diagnostics</h3>";
        echo "<p><strong>Trying to connect to database:</strong> {$this->dbname}</p>";
        echo "<p><strong>Username:</strong> {$this->username}</p>";
        echo "<p><strong>Host:</strong> {$this->host}</p>";
        echo "<p><strong>Port:</strong> {$this->port}</p>";
        
        // Check if MySQL is running
        echo "<h4>System Checks:</h4>";
        echo "<ul>";
        
        // Check if we can ping the host
        $ping = @fsockopen($this->host, $this->port, $errno, $errstr, 5);
        if ($ping) {
            echo "<li>✅ MySQL server is responding on {$this->host}:{$this->port}</li>";
            fclose($ping);
        } else {
            echo "<li>❌ Cannot connect to MySQL server on {$this->host}:{$this->port}</li>";
            echo "<li>Error: $errstr ($errno)</li>";
        }
        
        // Check common socket locations
        $sockets = [
            '/tmp/mysql.sock',
            '/Applications/MAMP/tmp/mysql/mysql.sock',
            '/usr/local/mysql/mysql.sock',
            '/var/mysql/mysql.sock',
            '/var/run/mysqld/mysqld.sock'
        ];
        
        echo "<li><strong>Checking socket files:</strong></li>";
        foreach ($sockets as $socket) {
            if (file_exists($socket)) {
                echo "<li>✅ Found socket: $socket</li>";
            } else {
                echo "<li>❌ No socket at: $socket</li>";
            }
        }
        
        echo "</ul>";
        
        echo "<h4>Possible Solutions:</h4>";
        echo "<ol>";
        echo "<li>Make sure MySQL/MariaDB is running</li>";
        echo "<li>Check your database credentials</li>";
        echo "<li>Try using 127.0.0.1 instead of localhost</li>";
        echo "<li>If using MAMP: Start MySQL from MAMP control panel</li>";
        echo "<li>If using XAMPP: Start MySQL from XAMPP control panel</li>";
        echo "<li>Check if your database 'mvc' exists</li>";
        echo "</ol>";
    }
}

// Alternative: Simple test connection file
// Save this as test-db.php and run it separately to debug

class DatabaseTest {
    public static function test() {
        echo "<h2>Database Connection Test</h2>";
        
        $configs = [
            'Standard' => [
                'dsn' => 'mysql:host=localhost;port=3306;dbname=mvc;charset=utf8mb4',
                'user' => 'root',
                'pass' => 'root'
            ],
            'IP Address' => [
                'dsn' => 'mysql:host=127.0.0.1;port=3306;dbname=mvc;charset=utf8mb4',
                'user' => 'root',
                'pass' => 'root'
            ],
            'Socket' => [
                'dsn' => 'mysql:unix_socket=/tmp/mysql.sock;dbname=mvc;charset=utf8mb4',
                'user' => 'root',
                'pass' => 'root'
            ],
            'MAMP Socket' => [
                'dsn' => 'mysql:unix_socket=/Applications/MAMP/tmp/mysql/mysql.sock;dbname=mvc;charset=utf8mb4',
                'user' => 'root',
                'pass' => 'root'
            ]
        ];
        
        foreach ($configs as $name => $config) {
            echo "<h3>Testing: $name</h3>";
            try {
                $pdo = new PDO($config['dsn'], $config['user'], $config['pass'], [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_TIMEOUT => 5
                ]);
                echo "✅ <strong>SUCCESS!</strong> Connected with: {$config['dsn']}<br>";
                echo "MySQL Version: " . $pdo->getAttribute(PDO::ATTR_SERVER_VERSION) . "<br>";
                
                // Test if database exists
                $stmt = $pdo->query("SHOW DATABASES LIKE 'mvc'");
                if ($stmt->rowCount() > 0) {
                    echo "✅ Database 'mvc' exists<br>";
                } else {
                    echo "❌ Database 'mvc' does not exist<br>";
                }
                
                echo "<hr>";
                break; // Stop on first success
            } catch (PDOException $e) {
                echo "❌ Failed: " . $e->getMessage() . "<br>";
                echo "<hr>";
            }
        }
        
        // Show system info
        echo "<h3>System Information</h3>";
        echo "PHP Version: " . PHP_VERSION . "<br>";
        echo "PDO MySQL Available: " . (extension_loaded('pdo_mysql') ? 'Yes' : 'No') . "<br>";
        echo "Operating System: " . PHP_OS . "<br>";
    }
}

// Uncomment this line to run the test
// DatabaseTest::test();

?>