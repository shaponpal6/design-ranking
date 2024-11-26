<?php
require_once '../includes/db_config.php';

try {
    // Create database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `wdr_admin_dashboard`");
    $pdo->exec("USE `wdr_admin_dashboard`");
    
    // Read and execute the SQL file
    $sql = file_get_contents(__DIR__ . '/create_users_table.sql');
    $pdo->exec($sql);
    
    // Check if admin user exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = 'admin@example.com'");
    $stmt->execute();
    $adminExists = $stmt->fetchColumn() > 0;
    
    if (!$adminExists) {
        // Create default admin user
        $defaultAdmin = [
            'full_name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'user_type' => 'admin'
        ];
        
        $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password, user_type) VALUES (:full_name, :email, :password, :user_type)");
        $stmt->execute($defaultAdmin);
        
        echo "Default admin user created successfully!\n";
        echo "Email: admin@example.com\n";
        echo "Password: admin123\n";
    }
    
    echo "Database and tables created successfully!";
    
} catch(PDOException $e) {
    die("ERROR: Could not set up database. " . $e->getMessage());
}
?>
