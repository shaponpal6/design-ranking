<?php
// saveRanking.php
if (!isset($_SESSION)) {
    session_start();
}
require_once 'includes/db_config.php';
require_once 'includes/check_auth.php';

header('Content-Type: application/json');

// echo json_encode([
//     'success' => true,
//     'data' => $_POST['action'],
//     'message' => 'Ranking added successfully'
// ]);
// exit();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'update') {
    $id = $_POST['id'];
    $updatedFields = [];


    // Validate and add fields that changed
    foreach (['prev', 'organisation', 'location', 'points', 'awards', '1st', '2nd', '3rd', 'black', 'gold', 'silver', 'bronze', 'comm'] as $field) {
        if (isset($_POST[$field])) {
            $updatedFields[$field] = $_POST[$field];
        }
    }

    if (!empty($updatedFields)) {
        // Construct SQL for updates
        $updateSQL = 'UPDATE agencydesignrankings SET ';
        $params = [];
        foreach ($updatedFields as $key => $value) {
            $updateSQL .= "$key = :$key, ";
            $params[":$key"] = $value;
        }
        $updateSQL = rtrim($updateSQL, ', ') . ' WHERE id = :id';
        $params[':id'] = $id;

        try {
            $stmt = $pdo->prepare($updateSQL);
            $stmt->execute($params);
            echo json_encode([
                'success' => true,
                'message' => 'Ranking Update successfully'
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => "Error updating record: " . $e->getMessage()
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => "No changes detected."
        ]);
    }
}