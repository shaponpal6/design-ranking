<?php
// saveRanking.php
if (!isset($_SESSION)) {
    session_start();
}
require_once 'includes/db_config.php';
require_once 'includes/check_auth.php';

header('Content-Type: application/json');

try {
    // Debug logging
    error_log('Received POST data: ' . print_r($_POST, true));
    error_log('Received FILES data: ' . print_r($_FILES, true));

    // Verify all required fields are present and not empty
    $requiredFields = [
        'organisation',
        'location',
        'points',
        'prev',
        'awards',
        '1st',
        '2nd',
        '3rd',
        'black',
        'gold',
        'silver',
        'bronze',
        'comm'
    ];

    $missingFields = [];
    foreach ($requiredFields as $field) {
        if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
            $missingFields[] = $field;
        }
    }

    if (!empty($missingFields)) {
        throw new Exception("Missing required fields: " . implode(', ', $missingFields));
    }

    // Handle logo upload
    $logoPath = 'default-logo.png'; // Default value
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $uploadedFileType = $_FILES['logo']['type'];

        if (!in_array($uploadedFileType, $allowedTypes)) {
            throw new Exception('Invalid file type. Only JPEG, PNG, and GIF are allowed.');
        }

        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $extension = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
        $filename = uniqid('logo_') . '.' . $extension;
        $logoPath = $uploadDir . $filename;

        if (!move_uploaded_file($_FILES['logo']['tmp_name'], $logoPath)) {
            throw new Exception('Failed to upload logo file.');
        }
    }

    // Prepare SQL statement
    $sql = "INSERT INTO agencydesignrankings (
        logo, prev, organisation, location, points, awards,
        `1st`, `2nd`, `3rd`, black, gold, silver, bronze, comm
    ) VALUES (
        :logo, :prev, :organisation, :location, :points, :awards,
        :first, :second, :third, :black, :gold, :silver, :bronze, :comm
    )";

    $stmt = $pdo->prepare($sql);

    // Bind parameters with validation
    $params = [
        ':logo' => $logoPath,
        ':prev' => filter_var($_POST['prev'], FILTER_VALIDATE_INT),
        ':organisation' => trim($_POST['organisation']),
        ':location' => trim($_POST['location']),
        ':points' => filter_var($_POST['points'], FILTER_VALIDATE_INT),
        ':awards' => filter_var($_POST['awards'], FILTER_VALIDATE_INT),
        ':first' => filter_var($_POST['1st'], FILTER_VALIDATE_INT),
        ':second' => filter_var($_POST['2nd'], FILTER_VALIDATE_INT),
        ':third' => filter_var($_POST['3rd'], FILTER_VALIDATE_INT),
        ':black' => filter_var($_POST['black'], FILTER_VALIDATE_INT),
        ':gold' => filter_var($_POST['gold'], FILTER_VALIDATE_INT),
        ':silver' => filter_var($_POST['silver'], FILTER_VALIDATE_INT),
        ':bronze' => filter_var($_POST['bronze'], FILTER_VALIDATE_INT),
        ':comm' => filter_var($_POST['comm'], FILTER_VALIDATE_INT)
    ];

    // Execute the statement
    if (!$stmt->execute($params)) {
        throw new Exception('Database error: ' . implode(', ', $stmt->errorInfo()));
    }

    echo json_encode([
        'success' => true,
        'message' => 'Ranking added successfully'
    ]);

} catch (Exception $e) {
    error_log('Error in saveRanking.php: ' . $e->getMessage());

    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'debug' => [
            'post' => $_POST,
            'files' => $_FILES
        ]
    ]);
}
?>