<?php
try {
    // Create database connection without selecting a database
    $pdo = new PDO("mysql:host=localhost", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `wdr_admin_dashboard`");
    $pdo->exec("USE `wdr_admin_dashboard`");
    
    // Create users table
    $sql = "CREATE TABLE IF NOT EXISTS `users` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `full_name` varchar(100) NOT NULL,
        `email` varchar(100) NOT NULL,
        `password` varchar(255) NOT NULL,
        `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
        `last_login` datetime DEFAULT NULL,
        `user_type` enum('admin','manager','user') DEFAULT 'user',
        `user_active` tinyint(1) DEFAULT 1,
        PRIMARY KEY (`id`),
        UNIQUE KEY `unique_email` (`email`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql);
    
    // Check if admin user exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = 'admin@example.com'");
    $stmt->execute();
    $adminExists = $stmt->fetchColumn() > 0;
    
    if (!$adminExists) {
        // Create default admin user
        $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password, user_type) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            'Admin User',
            'admin@example.com',
            password_hash('admin123', PASSWORD_DEFAULT),
            'admin'
        ]);
        echo "Default admin user created successfully!<br>";
        echo "Email: admin@example.com<br>";
        echo "Password: admin123<br>";
    } else {
        echo "Admin user already exists<br>";
    }
    
    echo "Database setup completed successfully!";
    
} catch(PDOException $e) {
    die("ERROR: " . $e->getMessage());
}
?>
