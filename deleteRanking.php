<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once 'includes/db_config.php';
require_once 'includes/check_auth.php';

$response = [
    'success' => false,
    'error' => null
];

try {
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        throw new Exception('Invalid ranking ID');
    }

    $id = (int)$_GET['id'];

    // First get the logo path to delete the file
    $stmt = $pdo->prepare("SELECT logo FROM agencydesignrankings WHERE id = ?");
    $stmt->execute([$id]);
    $ranking = $stmt->fetch(PDO::FETCH_ASSOC);

    // Delete the record
    $stmt = $pdo->prepare("DELETE FROM agencydesignrankings WHERE id = ?");
    if (!$stmt->execute([$id])) {
        throw new Exception('Failed to delete ranking');
    }

    // If record was deleted and there was a logo, delete the file
    if ($stmt->rowCount() > 0 && $ranking && $ranking['logo']) {
        if (file_exists($ranking['logo'])) {
            unlink($ranking['logo']);
        }
    }

    $response['success'] = true;
    $response['message'] = 'Ranking deleted successfully';

} catch (Exception $e) {
    error_log('Error in deleteRanking.php: ' . $e->getMessage());
    $response['error'] = $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);
