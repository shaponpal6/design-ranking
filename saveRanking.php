<?php
// saveRanking.php
if (!isset($_SESSION)) {
    session_start();
}
require_once 'includes/db_config.php';
// require_once 'includes/check_auth.php';

header('Content-Type: application/json');

try {
    // print_r($_POST);
    $rawData = file_get_contents("php://input");

    // Decode the raw JSON or form data, depending on the content type
    $data = json_decode($rawData, true); // If it's JSON

    // OR if it's not JSON and form-encoded, you can parse it manually
    parse_str($rawData, $data); // For standard form-urlencoded data

    // Now you can access the POST fields like this:
    if (isset($data['organisation'])) {
        $organisation = $data['organisation'];
        // Process other fields similarly...
    }

    echo json_encode(['success' => true, 'data' => $data]);
    return;
    // Validate action
    $action = 'create';
    if ($action !== 'create') {
        throw new Exception('Invalid action specified.');
    }

    // Check required fields
    $requiredFields = [
        'organisation',
        'location',
        'points',
        'previous_rank',
        'awards',
        'first_place',
        'second_place',
        'third_place',
        'black_medals',
        'gold_medals',
        'silver_medals',
        'bronze_medals',
        'commendations'
    ];

    $missingFields = [];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $missingFields[] = $field;
        }
    }

    if (!empty($missingFields)) {
        throw new Exception('Missing required fields: ' . implode(', ', $missingFields));
    }

    // Handle logo upload (optional field)
    $logoPath = null; // Initially set to null for optional field
    if (!empty($_FILES['logo']['tmp_name'])) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $filename = uniqid('logo_') . '.' . pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
        $logoPath = $uploadDir . $filename;
        if (!move_uploaded_file($_FILES['logo']['tmp_name'], $logoPath)) {
            throw new Exception('Failed to upload logo.');
        }
    }

    // Prepare the SQL query to insert data into the database
    $sql = "INSERT INTO agency_design_rankings (
        logo, previous_rank, organisation, location, points, awards,
        first_place, second_place, third_place,
        black_medals, gold_medals, silver_medals, bronze_medals, commendations
    ) VALUES (
        :logo, :previous_rank, :organisation, :location, :points, :awards,
        :first_place, :second_place, :third_place,
        :black_medals, :gold_medals, :silver_medals, :bronze_medals, :commendations
    )";

    // Prepare the statement
    $stmt = $pdo->prepare($sql);

    // Bind values to the statement
    $stmt->execute([
        ':logo' => $logoPath, // Can be null if no logo is uploaded
        ':previous_rank' => $_POST['previous_rank'] ?? null, // Can be null if no previous rank is provided
        ':organisation' => $_POST['organisation'],
        ':location' => $_POST['location'],
        ':points' => $_POST['points'],
        ':awards' => $_POST['awards'],
        ':first_place' => $_POST['first_place'] ?? 0, // Default to 0 if empty
        ':second_place' => $_POST['second_place'] ?? 0, // Default to 0 if empty
        ':third_place' => $_POST['third_place'] ?? 0, // Default to 0 if empty
        ':black_medals' => $_POST['black_medals'] ?? 0, // Default to 0 if empty
        ':gold_medals' => $_POST['gold_medals'] ?? 0, // Default to 0 if empty
        ':silver_medals' => $_POST['silver_medals'] ?? 0, // Default to 0 if empty
        ':bronze_medals' => $_POST['bronze_medals'] ?? 0, // Default to 0 if empty
        ':commendations' => $_POST['commendations'] ?? 0, // Default to 0 if empty
    ]);

    // Return success response
    echo json_encode(['success' => true, 'message' => 'Ranking added successfully']);
} catch (Exception $e) {
    // Return error response in JSON format
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}