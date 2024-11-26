<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once 'includes/db_config.php';
require_once 'includes/error_logger.php';

// Initialize response array
$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $remember = isset($_POST['remember']);

        logError("Login attempt for email: " . $email, __FILE__, __LINE__, ['remember' => $remember]);

        // Basic validation
        if (empty($email) || empty($password)) {
            throw new Exception('Please enter both email and password.');
        }

        // Prepare SQL statement
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND user_active = 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user) {
            logError("User not found or inactive: " . $email, __FILE__, __LINE__);
            throw new Exception('Invalid email or password.');
        }

        if (!password_verify($password, $user['password'])) {
            logError("Invalid password for user: " . $email, __FILE__, __LINE__);
            throw new Exception('Invalid email or password.');
        }

        // Update last login time
        $updateStmt = $pdo->prepare("UPDATE users SET last_login = CURRENT_TIMESTAMP WHERE id = ?");
        $updateStmt->execute([$user['id']]);

        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['full_name'];
        $_SESSION['user_type'] = $user['user_type'];
        $_SESSION['logged_in'] = true;

        // Handle Remember Me
        if ($remember) {
            $token = bin2hex(random_bytes(32));
            setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60), '/'); // 30 days
        }

        logError("Successful login for user: " . $email, __FILE__, __LINE__);
        header('Location: index');
        exit();

    } catch(PDOException $e) {
        logError("Database error: " . $e->getMessage(), __FILE__, __LINE__, [
            'trace' => $e->getTraceAsString()
        ]);
        $_SESSION['error'] = 'An error occurred. Please try again later.';
        header('Location: login');
        exit();
    } catch(Exception $e) {
        logError("Login error: " . $e->getMessage(), __FILE__, __LINE__);
        $_SESSION['error'] = $e->getMessage();
        header('Location: login');
        exit();
    }
} else {
    header('Location: login');
    exit();
}
