<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once 'includes/db_config.php';
require_once 'includes/check_auth.php';
include 'includes/header.php';
include 'includes/sidebar.php';

// Fetch all rankings from database
// $stmt = $pdo->query("SELECT * FROM agencydesignrankings ORDER BY points DESC");
// $rankings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!-- <title>Dashboard | Admin Panel</title> -->

<?php


// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $action = $_POST['action'] ?? '';
    $organisation = $_POST['organisation'] ?? '';
    $location = $_POST['location'] ?? '';
    $points = $_POST['points'] ?? 0;
    $awards = $_POST['awards'] ?? 0;
    $firstPlace = $_POST['1st'] ?? 0;
    $secondPlace = $_POST['2nd'] ?? 0;
    $thirdPlace = $_POST['3rd'] ?? 0;
    $blackMedals = $_POST['black'] ?? 0;
    $goldMedals = $_POST['gold'] ?? 0;
    $silverMedals = $_POST['silver'] ?? 0;
    $bronzeMedals = $_POST['bronze'] ?? 0;
    $commendations = $_POST['comm'] ?? 0;
    $previousRank = $_POST['prev'] ?? null;

    // Handle file upload (Logo)
    // if (isset($_FILES['logo'])) {
    //     $logo = $_FILES['logo'];
    //     // Save logo to server (e.g., move to a folder)
    //     $logoPath = 'uploads/' . basename($logo['name']);
    //     move_uploaded_file($logo['tmp_name'], $logoPath);
    // }

    // Insert data into the database
    try {
        // Example database insert query (assuming PDO connection)
        $sql = "INSERT INTO agency_design_rankings (
            previous_rank, organisation, location, points, awards,
            first_place, second_place, third_place,
            black_medals, gold_medals, silver_medals, bronze_medals, commendations
        ) VALUES (
            :previous_rank, :organisation, :location, :points, :awards,
            :first_place, :second_place, :third_place,
            :black_medals, :gold_medals, :silver_medals, :bronze_medals, :commendations
        )";
        $logoPath = "assets";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':previous_rank' => $previousRank,
            ':organisation' => $organisation,
            ':location' => $location,
            ':points' => $points,
            ':awards' => $awards,
            ':first_place' => $firstPlace,
            ':second_place' => $secondPlace,
            ':third_place' => $thirdPlace,
            ':black_medals' => $blackMedals,
            ':gold_medals' => $goldMedals,
            ':silver_medals' => $silverMedals,
            ':bronze_medals' => $bronzeMedals,
            ':commendations' => $commendations,
            // ':logo_path' => $logoPath,
        ]);

        echo "Ranking added successfully!";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}










?>

<!-- Start Page Content -->
<div class="flex items-center md:justify-between flex-wrap gap-2 mb-6">
    <h4 class="text-default-900 text-lg font-medium mb-2">Dashboard</h4>
    <div class="md:flex hidden items-center gap-3 text-sm font-semibold">
        <a href="#" class="text-sm font-medium text-default-700">Dashboard</a>
    </div>
</div>

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
                    <label class="form-label font-semibold mb-1">Organisation URL</label>
                    <input type="text" name="organisation" class="form-control border rounded p-1.5">
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
                    <!-- <table class="min-w-full">
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
                                <tr class="border-b border-gray-200">
                                    <td class="px-6 py-3">
                                        <?php if ($ranking['logo']): ?>
                                            <img src="<?php echo htmlspecialchars($ranking['logo']); ?>" alt="logo"
                                                class="h-10 w-auto">
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-3"><?php echo htmlspecialchars($ranking['prev']); ?></td>
                                    <td class="px-6 py-3"><?php echo htmlspecialchars($ranking['organisation']); ?></td>
                                    <td class="px-6 py-3"><?php echo htmlspecialchars($ranking['location']); ?></td>
                                    <td class="px-6 py-3"><?php echo htmlspecialchars($ranking['points']); ?></td>
                                    <td class="px-6 py-3"><?php echo htmlspecialchars($ranking['awards']); ?></td>
                                    <td class="px-6 py-3"><?php echo htmlspecialchars($ranking['1st']); ?></td>
                                    <td class="px-6 py-3"><?php echo htmlspecialchars($ranking['2nd']); ?></td>
                                    <td class="px-6 py-3"><?php echo htmlspecialchars($ranking['3rd']); ?></td>
                                    <td class="px-6 py-3"><?php echo htmlspecialchars($ranking['black']); ?></td>
                                    <td class="px-6 py-3"><?php echo htmlspecialchars($ranking['gold']); ?></td>
                                    <td class="px-6 py-3"><?php echo htmlspecialchars($ranking['silver']); ?></td>
                                    <td class="px-6 py-3"><?php echo htmlspecialchars($ranking['bronze']); ?></td>
                                    <td class="px-6 py-3"><?php echo htmlspecialchars($ranking['comm']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                        <div class="flex justify-end gap-2">
                                            <button
                                                class="edit-ranking inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-black text-white"
                                                data-id="<?php echo htmlspecialchars($ranking['id']); ?>">
                                                Edit
                                            </button>
                                            <button
                                                class="delete-ranking inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-red-500 text-white"
                                                data-id="<?php echo htmlspecialchars($ranking['id']); ?>">
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table> -->
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
        const $rankingForm = $('#rankingForm2');
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
        $prevRankingField.val(generateRandomRank());

        // Show the form when "Add New Ranking" is clicked
        $addRankingBtn.on('click', function () {
            $newRankingForm.show();
        });

        // Hide the form and reset fields when "Cancel" is clicked
        $cancelBtn.on('click', function () {
            $newRankingForm.hide();
            $rankingForm[0].reset();
            $prevRankingField.val(generateRandomRank());
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

        // Handle form submission
        $rankingForm.on('submit', function (e) {
            e.preventDefault();

            // Collect form data without logo field
            const formData = {
                action: 'create',
                prev: $prevRankingField.val(),
                organisation: $('[name="organisation"]').val(),
                location: $('[name="location"]').val(),
                points: $pointsField.val(),
                awards: $awardsField.val(),
                first_place: $('#firstPlace').val(),
                second_place: $('#secondPlace').val(),
                third_place: $('#thirdPlace').val(),
                black_medals: $('#blackMedal').val(),
                gold_medals: $('#goldMedal').val(),
                silver_medals: $('#silverMedal').val(),
                bronze_medals: $('#bronzeMedal').val(),
                commendations: $('#commendations').val(),
            };

            console.log('formData :>> ', formData);
            // console.log('formData :>> ', $('#rankingForm').serialize()); // Optional debug line for form serialization

            // Perform AJAX submission
            $.ajax({
                url: 'saveRanking.php',  // URL of your PHP script that handles the form submission
                type: 'POST',
                data: formData,  // Send form data as plain data (no file upload)
                dataType: 'json',  // Expect a JSON response from the server
                success: function (data) {
                    console.log('Response:', data);  // For debugging
                    if (data.success) {
                        alert('Ranking added successfully!');
                        // You can reload the page or hide the form if needed
                        // location.reload();
                    } else {
                        alert('Error: ' + (data.error || 'Unknown error'));
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error: ' + status + ' - ' + error);  // For debugging
                    alert('An error occurred. Please try again later.');
                }
            });
        });
    });







    // document.addEventListener('DOMContentLoaded', function () {
    //     const addRankingBtn = document.getElementById('addRankingBtn');
    //     const newRankingForm = document.getElementById('newRankingForm');
    //     const cancelBtn = document.getElementById('cancelBtn');
    //     const rankingForm = document.getElementById('rankingForm');

    //     const pointsField = document.getElementById('points');
    //     const awardsField = document.getElementById('awards');
    //     const prevRankingField = document.getElementById('prevRanking');

    //     const fields = {
    //         first_place: document.getElementById('firstPlace'),
    //         second_place: document.getElementById('secondPlace'),
    //         third_place: document.getElementById('thirdPlace'),
    //         black_medals: document.getElementById('blackMedal'),
    //         gold_medals: document.getElementById('goldMedal'),
    //         silver_medals: document.getElementById('silverMedal'),
    //         bronze_medals: document.getElementById('bronzeMedal'),
    //         commendations: document.getElementById('commendations'),
    //         action: 'create',
    //     };


    //     const pointValues = {
    //         first: 5,
    //         second: 4,
    //         third: 3,
    //         black: 5,
    //         gold: 4,
    //         silver: 3,
    //         bronze: 2,
    //         comm: 1,
    //     };

    //     // Initialize random number in Previous Ranking
    //     prevRankingField.value = Math.floor(Math.random() * 100) + 1;

    //     // Toggle form visibility
    //     addRankingBtn.addEventListener('click', function () {
    //         newRankingForm.style.display = 'block';
    //     });

    //     cancelBtn.addEventListener('click', function () {
    //         newRankingForm.style.display = 'none';
    //         rankingForm.reset();
    //         prevRankingField.value = Math.floor(Math.random() * 100) + 1; // Regenerate random number
    //     });

    //     // Recalculate Points and Awards
    //     function recalculate() {
    //         let totalAwards = 0;
    //         let totalPoints = 0;

    //         for (const key in fields) {
    //             const value = parseInt(fields[key].value, 10) || 0;
    //             totalAwards += value;
    //             totalPoints += value * pointValues[key];
    //         }

    //         awardsField.value = totalAwards;
    //         pointsField.value = totalPoints;
    //     }

    //     // Add event listeners for recalculation
    //     for (const key in fields) {
    //         fields[key].addEventListener('input', recalculate);
    //     }

    //     // Handle form submission
    //     rankingForm.addEventListener('submit', async function (e) {
    //         e.preventDefault();

    //         try {
    //             const formData = new FormData(rankingForm);
    //             // formData.append('action', 'create'); // Specify the action for backend
    //             console.log('formData :>> ', formData);
    //             return;

    //             // Debugging: Log form data
    //             for (let [key, value] of formData.entries()) {
    //                 console.log(key, value);
    //             }

    //             const response = await fetch('saveRanking.php', {
    //                 method: 'POST',
    //                 body: formData,
    //             });

    //             const data = await response.json();

    //             if (data.success) {
    //                 alert('Ranking added successfully!');
    //                 // location.reload();
    //             } else {
    //                 alert('Error: ' + (data.error || 'Unknown error occurred'));
    //                 console.error('Server error:', data);
    //             }
    //         } catch (error) {
    //             console.error('Submission error:', error);
    //             alert('An error occurred: ' + error.message);
    //         }
    //     });
    // });

</script>

<?php include 'includes/footer.php'; ?>