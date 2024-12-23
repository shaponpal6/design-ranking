<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once 'includes/db_config.php';
require_once 'includes/check_auth.php';
include 'includes/header.php';
include 'includes/sidebar.php';
function updatePrevRankingsHome($pdo)
{
    try {
        // Start a transaction to ensure data consistency
        $pdo->beginTransaction();

        // Step 1: Retrieve all rows sorted by points in descending order
        $query = "SELECT id FROM agencydesignrankings ORDER BY points DESC";
        $stmt = $pdo->query($query);
        $rankings = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Step 2: Update the `prev` column based on sorted order
        $rank = 1;
        $updateQuery = "UPDATE agencydesignrankings SET prev = :prev WHERE id = :id";
        $updateStmt = $pdo->prepare($updateQuery);

        foreach ($rankings as $ranking) {
            $updateStmt->execute([
                ':prev' => $rank,
                ':id' => $ranking['id']
            ]);
            $rank++;
        }

        // Commit the transaction
        $pdo->commit();
        // echo "Previous rankings updated successfully!";
    } catch (Exception $e) {
        // Rollback the transaction in case of an error
        $pdo->rollBack();
        // echo "Error updating rankings: " . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;
    if ($action == 'create') {
        try {
            // Retrieve form data with default values for missing fields
            $organisation = trim($_POST['organisation'] ?? '') ?: '';
            $organisation_url = trim($_POST['organisation_url'] ?? '') ?: '';
            $location = trim($_POST['location'] ?? '') ?: '';
            $points = is_numeric($_POST['points'] ?? null) ? (int) $_POST['points'] : 0;
            $awards = is_numeric($_POST['awards'] ?? null) ? (int) $_POST['awards'] : 0;
            $firstPlace = is_numeric($_POST['1st'] ?? null) ? (int) $_POST['1st'] : 0;
            $secondPlace = is_numeric($_POST['2nd'] ?? null) ? (int) $_POST['2nd'] : 0;
            $thirdPlace = is_numeric($_POST['3rd'] ?? null) ? (int) $_POST['3rd'] : 0;
            $blackMedals = is_numeric($_POST['black'] ?? null) ? (int) $_POST['black'] : 0;
            $goldMedals = is_numeric($_POST['gold'] ?? null) ? (int) $_POST['gold'] : 0;
            $silverMedals = is_numeric($_POST['silver'] ?? null) ? (int) $_POST['silver'] : 0;
            $bronzeMedals = is_numeric($_POST['bronze'] ?? null) ? (int) $_POST['bronze'] : 0;
            $commendations = is_numeric($_POST['comm'] ?? null) ? (int) $_POST['comm'] : 0;
            $previousRank = is_numeric($_POST['prev'] ?? null) ? (int) $_POST['prev'] : 0;

            // Handle file upload for logo
            $logoPath = '';
            if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
                $logo = $_FILES['logo'];
                $uploadDir = 'uploads/';
                $logoPath = $uploadDir . basename($logo['name']);
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                move_uploaded_file($logo['tmp_name'], $logoPath);
            }

            // Establish a database connection (PDO)
            // $pdo = new PDO('mysql:host=localhost;dbname=your_database', 'username', 'password');

            // Insert data into the `agencydesignrankings` table
            $sql = "INSERT INTO agencydesignrankings (
            logo, prev, organisation, organisation_url, location, points, awards,
            `1st`, `2nd`, `3rd`, black, gold, silver, bronze, comm
        ) VALUES (
            :logo, :prev, :organisation, :organisation_url, :location, :points, :awards,
            :firstPlace, :secondPlace, :thirdPlace, :blackMedals, :goldMedals, :silverMedals, :bronzeMedals, :commendations
        )";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':logo' => $logoPath,
                ':prev' => $previousRank,
                ':organisation' => $organisation,
                ':organisation_url' => $organisation_url,
                ':location' => $location,
                ':points' => $points,
                ':awards' => $awards,
                ':firstPlace' => $firstPlace,
                ':secondPlace' => $secondPlace,
                ':thirdPlace' => $thirdPlace,
                ':blackMedals' => $blackMedals,
                ':goldMedals' => $goldMedals,
                ':silverMedals' => $silverMedals,
                ':bronzeMedals' => $bronzeMedals,
                ':commendations' => $commendations,
            ]);
            updatePrevRankingsHome($pdo);
            // Set a success message
            $_SESSION['message'] = "Ranking added successfully!";
            $_SESSION['message_type'] = 'success';
        } catch (Exception $e) {
            // Set an error message
            $_SESSION['message'] = "Error: " . $e->getMessage();
            $_SESSION['message_type'] = 'error';
        }
    }

    // Refresh the page
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}




// Fetch all rankings from database
$stmt = $pdo->query("SELECT * FROM agencydesignrankings ORDER BY points DESC");
$rankings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<title>Dashboard | Admin Panel</title>

<!-- Start Page Content -->
<div class="flex items-center md:justify-between flex-wrap gap-2 mb-6">
    <h4 class="text-default-900 text-lg font-medium mb-2">Dashboard</h4>
    <div class="md:flex hidden items-center gap-3 text-sm font-semibold">
        <a href="#" class="text-sm font-medium text-default-700">Dashboard</a>
    </div>
</div>

<!-- Display Messages -->
<?php if (!empty($_SESSION['message'])): ?>
    <div class="alert <?= $_SESSION['message_type'] === 'success' ? 'alert-success' : 'alert-danger'; ?>">
        <?= htmlspecialchars($_SESSION['message']); ?>
    </div>
    <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
<?php endif; ?>

<div class="grid xl:grid-cols-1 gap-6">
    <div class="card overflow-hidden">
        <div class="card-header flex justify-between items-center">
            <h4 class="card-title">Agency Design Rankings</h4>
            <button id="addRankingBtn" class="btn btn-sm bg-primary text-white !text-sm">Add New Ranking</button>
        </div>

        <!-- Add New Ranking Form -->
        <div id="newRankingForm" class="p-4 border rounded-lg bg-white shadow-lg" style="display: none;">
            <form action="http://localhost/wdr/agencydesignrankings" method="post" id="rankingForm"
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" enctype="multipart/form-data">
                <input type="hidden" name="action" value="create">
                <div class="form-group flex flex-col">
                    <label class="form-label font-semibold mb-1">Logo</label>
                    <input type="file" name="logo" class="form-control border rounded p-1.5" accept="image/*">
                </div>
                <div class="form-group flex flex-col">
                    <label class="form-label font-semibold mb-1">Previous Ranking</label>
                    <input type="number" name="prev" id="prevRanking"
                        class="form-control border rounded p-1.5 bg-gray-200" readonly>
                </div>
                <div class="form-group flex flex-col">
                    <label class="form-label font-semibold mb-1">Organisation Name</label>
                    <input type="text" name="organisation" class="form-control border rounded p-1.5" required>
                </div>
                <div class="form-group flex flex-col">
                    <label class="form-label font-semibold mb-1">Organisation URL</label>
                    <input type="text" name="organisation_url" class="form-control border rounded p-1.5" required>
                </div>
                <div class="form-group flex flex-col">
                    <label class="form-label font-semibold mb-1">Location</label>
                    <input type="text" name="location" class="form-control border rounded p-1.5">
                </div>
                <div class="form-group flex flex-col">
                    <label class="form-label font-semibold mb-1">Points</label>
                    <input type="number" name="points" id="points" class="form-control border rounded p-1.5 bg-gray-200"
                        readonly>
                </div>
                <div class="form-group flex flex-col">
                    <label class="form-label font-semibold mb-1">Awards</label>
                    <input type="number" name="awards" id="awards" class="form-control border rounded p-1.5 bg-gray-200"
                        readonly>
                </div>
                <div class="form-group flex flex-col">
                    <label class="form-label font-semibold mb-1">1st Place</label>
                    <input type="number" name="1st" id="firstPlace" class="form-control border rounded p-1.5" value="0"
                        min="0">
                </div>
                <div class="form-group flex flex-col">
                    <label class="form-label font-semibold mb-1">2nd Place</label>
                    <input type="number" name="2nd" id="secondPlace" class="form-control border rounded p-1.5" value="0"
                        min="0">
                </div>
                <div class="form-group flex flex-col">
                    <label class="form-label font-semibold mb-1">3rd Place</label>
                    <input type="number" name="3rd" id="thirdPlace" class="form-control border rounded p-1.5" value="0"
                        min="0">
                </div>
                <div class="form-group flex flex-col">
                    <label class="form-label font-semibold mb-1">Black Medal</label>
                    <input type="number" name="black" id="blackMedal" class="form-control border rounded p-1.5"
                        value="0" min="0">
                </div>
                <div class="form-group flex flex-col">
                    <label class="form-label font-semibold mb-1">Gold Medal</label>
                    <input type="number" name="gold" id="goldMedal" class="form-control border rounded p-1.5" value="0"
                        min="0">
                </div>
                <div class="form-group flex flex-col">
                    <label class="form-label font-semibold mb-1">Silver Medal</label>
                    <input type="number" name="silver" id="silverMedal" class="form-control border rounded p-1.5"
                        value="0" min="0">
                </div>
                <div class="form-group flex flex-col">
                    <label class="form-label font-semibold mb-1">Bronze Medal</label>
                    <input type="number" name="bronze" id="bronzeMedal" class="form-control border rounded p-1.5"
                        value="0" min="0">
                </div>
                <div class="form-group flex flex-col">
                    <label class="form-label font-semibold mb-1">Commendations</label>
                    <input type="number" name="comm" id="commendations" class="form-control border rounded p-1.5"
                        value="0" min="0">
                </div>
                <div class="col-span-full flex justify-end gap-4 mt-4">
                    <button type="submit" class="btn bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Save
                        Ranking</button>
                    <button type="button" id="cancelBtn"
                        class="btn bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">Cancel</button>
                </div>
            </form>
        </div>



        <div class="overflow-x-auto custom-scroll">
            <div class="min-w-full inline-block align-middle">
                <div class="overflow-hidden">
                    <table class="min-w-full">
                        <thead class="bg-light/40 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-start">LOGO</th>
                                <th class="px-6 py-3 text-start">PREV</th>
                                <th class="px-6 py-3 text-start">ORGANISATION</th>
                                <th class="px-6 py-3 text-start">LOCATION</th>
                                <th class="px-6 py-3 text-start">POINTS</th>
                                <th class="px-6 py-3 text-start">AWARDS</th>
                                <th class="px-6 py-3 text-start">1ST</th>
                                <th class="px-6 py-3 text-start">2ND</th>
                                <th class="px-6 py-3 text-start">3RD</th>
                                <th class="px-6 py-3 text-start">BLACK</th>
                                <th class="px-6 py-3 text-start">GOLD</th>
                                <th class="px-6 py-3 text-start">SILVER</th>
                                <th class="px-6 py-3 text-start">BRONZE</th>
                                <th class="px-6 py-3 text-start">COMM</th>
                                <th class="px-6 py-3 text-start">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rankings as $ranking): ?>
                                <tr class="border-b border-gray-200" data-id="<?php echo $ranking['id']; ?>">
                                    <td class="px-6 py-3">
                                        <?php if ($ranking['logo']): ?>
                                            <img src="<?php echo htmlspecialchars($ranking['logo']); ?>" alt="logo"
                                                class="h-10 w-auto">
                                        <?php endif; ?>
                                        <div class="edit-logo"></div>
                                    </td>
                                    <td id="prev-<?php echo $ranking['id']; ?>" class="editable px-6 py-3">
                                        <?php echo htmlspecialchars($ranking['prev']); ?>
                                    </td>
                                    <td id="organisation-<?php echo $ranking['id']; ?>" class="editable px-6 py-3">
                                        <a href="<?php echo htmlspecialchars($ranking['organisation_url']); ?>"
                                            target="_blank">
                                            <?php echo htmlspecialchars($ranking['organisation']); ?>
                                        </a>
                                    </td>
                                    <td id="location-<?php echo $ranking['id']; ?>" class="editable px-6 py-3">
                                        <?php echo htmlspecialchars($ranking['location']); ?>
                                    </td>
                                    <td id="points-<?php echo $ranking['id']; ?>" class="px-6 py-3 text-gray-500">
                                        <?php echo htmlspecialchars($ranking['points']); ?>
                                    </td>
                                    <td id="awards-<?php echo $ranking['id']; ?>" class="px-6 py-3 text-gray-500">
                                        <?php echo htmlspecialchars($ranking['awards']); ?>
                                    </td>
                                    <td id="1st-<?php echo $ranking['id']; ?>" class="editable medal-field px-6 py-3">
                                        <?php echo htmlspecialchars($ranking['1st']); ?>
                                    </td>
                                    <td id="2nd-<?php echo $ranking['id']; ?>" class="editable medal-field px-6 py-3">
                                        <?php echo htmlspecialchars($ranking['2nd']); ?>
                                    </td>
                                    <td id="3rd-<?php echo $ranking['id']; ?>" class="editable medal-field px-6 py-3">
                                        <?php echo htmlspecialchars($ranking['3rd']); ?>
                                    </td>
                                    <td id="black-<?php echo $ranking['id']; ?>" class="editable medal-field px-6 py-3">
                                        <?php echo htmlspecialchars($ranking['black']); ?>
                                    </td>
                                    <td id="gold-<?php echo $ranking['id']; ?>" class="editable medal-field px-6 py-3">
                                        <?php echo htmlspecialchars($ranking['gold']); ?>
                                    </td>
                                    <td id="silver-<?php echo $ranking['id']; ?>" class="editable medal-field px-6 py-3">
                                        <?php echo htmlspecialchars($ranking['silver']); ?>
                                    </td>
                                    <td id="bronze-<?php echo $ranking['id']; ?>" class="editable medal-field px-6 py-3">
                                        <?php echo htmlspecialchars($ranking['bronze']); ?>
                                    </td>
                                    <td id="comm-<?php echo $ranking['id']; ?>" class="editable medal-field px-6 py-3">
                                        <?php echo htmlspecialchars($ranking['comm']); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                        <div class="flex justify-end gap-2">
                                            <button
                                                class="edit-ranking inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-black text-white">Edit</button>
                                            <button
                                                class="delete-ranking inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-red-500 text-white">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>




                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>



    $(document).ready(function () {
        const $addRankingBtn = $('#addRankingBtn');
        const $newRankingForm = $('#newRankingForm');
        const $cancelBtn = $('#cancelBtn');
        const $rankingForm = $('#rankingForm');
        const $prevRankingField = $('#prevRanking');
        const $pointsField = $('#points');
        const $awardsField = $('#awards');

        const fields = {
            first_place: $('#firstPlace'),
            second_place: $('#secondPlace'),
            third_place: $('#thirdPlace'),
            black_medals: $('#blackMedal'),
            gold_medals: $('#goldMedal'),
            silver_medals: $('#silverMedal'),
            bronze_medals: $('#bronzeMedal'),
            commendations: $('#commendations'),
        };

        const pointValues = {
            first_place: 5,
            second_place: 4,
            third_place: 3,
            black_medals: 5,
            gold_medals: 4,
            silver_medals: 3,
            bronze_medals: 2,
            commendations: 1,
        };

        // Generate a random previous rank
        function generateRandomRank() {
            return Math.floor(Math.random() * 100) + 1;
        }
        //$prevRankingField.val(generateRandomRank());

        // Show the form when "Add New Ranking" is clicked
        $addRankingBtn.on('click', function () {
            $newRankingForm.show();
        });

        // Hide the form and reset fields when "Cancel" is clicked
        $cancelBtn.on('click', function () {
            $newRankingForm.hide();
            $rankingForm[0].reset();
            //$prevRankingField.val(generateRandomRank());
        });

        // Recalculate Points and Awards dynamically
        function recalculate() {
            let totalAwards = 0;
            let totalPoints = 0;

            $.each(fields, function (key, $field) {
                const value = parseInt($field.val(), 10) || 0;
                totalAwards += value;
                totalPoints += value * pointValues[key];
            });

            $awardsField.val(totalAwards);
            $pointsField.val(totalPoints);
        }

        // Attach event listeners to medal fields for recalculation
        $.each(fields, function (key, $field) {
            $field.on('input', recalculate);
        });
    });














    $(document).ready(function () {
        const pointValues = {
            '1st': 5,
            '2nd': 4,
            '3rd': 3,
            black: 5,
            gold: 4,
            silver: 3,
            bronze: 2,
            comm: 1,
        };

        // Function to recalculate points and awards
        function recalculate(row) {
            let totalPoints = 0;
            let totalAwards = 0;

            row.find('.medal-field').each(function () {
                const field = $(this).attr('id').split('-')[0];
                const value = parseInt($(this).text().trim(), 10) || 0;
                totalAwards += value;
                totalPoints += value * (pointValues[field] || 0);
            });

            const id = row.data('id');
            $(`#points-${id}`).text(totalPoints);
            $(`#awards-${id}`).text(totalAwards);
        }

        // Handle "Edit" button click
        $('tbody').on('click', '.edit-ranking', function () {
            const row = $(this).closest('tr');
            const isEditing = $(this).text() === 'Save';

            if (isEditing) {
                // Save changes
                const id = row.data('id');
                const points = $('#points-' + id).text();
                const awards = $('#awards-' + id).text();
                const updatedData = { id: id, action: 'update', points, awards };

                row.find('.editable').each(function () {
                    const field = $(this).attr('id').split('-')[0];
                    const value = $(this).text().trim();
                    updatedData[field] = value || '';
                    $(this).attr('contenteditable', false);
                });

                // Simulate a form submission or AJAX request
                console.log('Saving changes for ID:', id, updatedData);

                $(this).text('Edit').removeClass('bg-green-500').addClass('bg-black');








                const data = { action: 'update', id: id };
                let hasChanges = true;


                if (hasChanges) {
                    $.ajax({
                        url: 'http://localhost/wdr/saveRanking',
                        type: 'POST',
                        data: (updatedData),
                        success: function (response) {
                            console.log('response :>> ', response);
                            if (response.success) {
                                // alert('Data saved successfully!');
                                // Optionally, reload the row or page
                                location.reload();
                            } else {
                                alert('Error: ' + (response.error || 'Unknown error occurred.'));
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('AJAX Error:', status, error);
                            alert('An error occurred. Please try again.');
                        }
                    });
                } else {
                    alert('No changes made.');
                }










            } else {
                // Enable editing
                row.find('.editable').each(function () {
                    $(this).attr('contenteditable', true).css('border', 'none');
                });

                $(this).text('Save').removeClass('bg-black').addClass('bg-green-500');
            }
        });

        // Recalculate points and awards dynamically
        $('tbody').on('input', '.editable', function () {
            const value = parseInt($(this).text().trim(), 10);
            if (isNaN(value) || value < 0) {
                $(this).text(0); // Reset invalid values to 0
            }
            const row = $(this).closest('tr');
            recalculate(row);
        });
    });









    //delete
    $(document).ready(function () {
        $('.delete-ranking').on('click', function () {
            const row = $(this).closest('tr');
            const id = row.data('id');
            // const id = $(this).data('id'); // Assuming the `data-id` contains the ID of the ranking

            console.log('id :>> ', id);
            // Confirm deletion
            if (confirm('Are you sure you want to delete this ranking?')) {
                $.ajax({
                    url: 'http://localhost/wdr/saveRanking',
                    type: 'POST',
                    data: {
                        action: 'delete',
                        id: id
                    },
                    success: function (response) {
                        if (response.success) {
                            alert('Ranking deleted successfully!');
                            row.remove(); // Remove the row from the table
                        } else {
                            alert('Error: ' + (response.error || 'Unable to delete the ranking.'));
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                        alert('An error occurred while deleting the ranking. Please try again.');
                    }
                });
            }
        });
    });



</script>

<?php include 'includes/footer.php'; ?>