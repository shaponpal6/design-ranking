<?php
// Database configuration
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');     // Default XAMPP/Laragon username
define('DB_PASSWORD', '');         // Default XAMPP/Laragon password
define('DB_NAME', 'wdr_admin_dashboard');

// Attempt to connect to MySQL database
try {
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}
?>
