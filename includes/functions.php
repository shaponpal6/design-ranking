<?php
/**
 * Helper Functions
 */

// Sanitize input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Validate email
function is_valid_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Check if email exists in database
function email_exists($pdo, $email) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetchColumn() > 0;
}

// Generate random token
function generate_token($length = 32) {
    return bin2hex(random_bytes($length));
}

// Format date
function format_date($date, $format = 'M d, Y H:i') {
    return date($format, strtotime($date));
}

// Get user by ID
function get_user_by_id($pdo, $user_id) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    return $stmt->fetch();
}

// Check if user has permission
function has_permission($required_role) {
    if (!isset($_SESSION['user_type'])) {
        return false;
    }
    if ($_SESSION['user_type'] === 'admin') {
        return true;
    }
    return $_SESSION['user_type'] === $required_role;
}

// Log user activity
function log_activity($pdo, $user_id, $action, $details = '') {
    try {
        $stmt = $pdo->prepare("INSERT INTO activity_logs (user_id, action, details, created_at) VALUES (?, ?, ?, NOW())");
        return $stmt->execute([$user_id, $action, $details]);
    } catch (PDOException $e) {
        // If table doesn't exist, just ignore the error
        if ($e->getCode() == '42S02') {
            return true;
        }
        // For other errors, log them but don't break the application
        error_log("Error logging activity: " . $e->getMessage());
        return false;
    }
}
?>
