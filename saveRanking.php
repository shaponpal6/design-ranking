<?php
// saveRanking.php
if (!isset($_SESSION)) {
    session_start();
}
require_once 'includes/db_config.php';
require_once 'includes/check_auth.php';

header('Content-Type: application/json');

function updatePrevRankingsSave($pdo)
{
    try {
        // Fetch all records sorted by points in descending order
        $query = "SELECT id FROM agencydesignrankings ORDER BY points DESC";
        $rankings = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);

        // Update the `prev` column
        $rank = 1;
        foreach ($rankings as $ranking) {
            $updateQuery = "UPDATE agencydesignrankings SET prev = :prev WHERE id = :id";
            $stmt = $pdo->prepare($updateQuery);
            $stmt->execute([
                ':prev' => $rank,
                ':id' => $ranking['id']
            ]);
            $rank++;
        }

        // echo "Previous rankings updated successfully!";
    } catch (Exception $e) {
        // echo "Error updating rankings: " . $e->getMessage();
    }
}

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
            updatePrevRankingsSave($pdo);
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


// Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'delete') {
    $id = $_POST['id'] ?? null;

    if ($id) {
        try {
            $sql = "DELETE FROM agencydesignrankings WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            updatePrevRankingsSave($pdo);

            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid ID provided.']);
    }
}
