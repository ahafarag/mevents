<?php
// db.php - Simple MySQL connection file (no frameworks)

$host = 'localhost';             // or 127.0.0.1
$db   = 'prize_draw';            // your database name
$user = 'your_db_user';          // your MySQL username
$pass = 'your_db_password';      // your MySQL password
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    http_response_code(500);
    echo "Database connection failed: " . $e->getMessage();
    exit;
}
?>
