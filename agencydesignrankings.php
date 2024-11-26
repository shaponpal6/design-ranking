<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once 'includes/db_config.php';
require_once 'includes/check_auth.php';
include 'includes/header.php';
include 'includes/sidebar.php';

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

<div class="grid xl:grid-cols-1 gap-6">
    <div class="card overflow-hidden">
        <div class="card-header flex justify-between items-center">
            <h4 class="card-title">Agency Design Rankings</h4>
            <button id="addRankingBtn" class="btn btn-sm bg-primary text-white !text-sm">Add New Ranking</button>
        </div>

        <!-- Add New Ranking Form -->
        <div id="newRankingForm" class="p-4 border-b border-gray-200" style="display: none;">
            <form id="rankingForm" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="form-group">
                    <label class="form-label">Logo</label>
                    <input type="file" name="logo" class="form-control" accept="image/*">
                </div>
                <div class="form-group">
                    <label class="form-label">Previous Ranking</label>
                    <input type="number" name="prev" class="form-control" required min="0">
                </div>
                <div class="form-group">
                    <label class="form-label">Organisation</label>
                    <input type="text" name="organisation" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Points</label>
                    <input type="number" name="points" class="form-control" required min="0">
                </div>
                <div class="form-group">
                    <label class="form-label">Awards</label>
                    <input type="number" name="awards" class="form-control" required min="0">
                </div>
                <div class="form-group">
                    <label class="form-label">1st Place</label>
                    <input type="number" name="1st" class="form-control" required min="0">
                </div>
                <div class="form-group">
                    <label class="form-label">2nd Place</label>
                    <input type="number" name="2nd" class="form-control" required min="0">
                </div>
                <div class="form-group">
                    <label class="form-label">3rd Place</label>
                    <input type="number" name="3rd" class="form-control" required min="0">
                </div>
                <div class="form-group">
                    <label class="form-label">Black Medal</label>
                    <input type="number" name="black" class="form-control" required min="0">
                </div>
                <div class="form-group">
                    <label class="form-label">Gold Medal</label>
                    <input type="number" name="gold" class="form-control" required min="0">
                </div>
                <div class="form-group">
                    <label class="form-label">Silver Medal</label>
                    <input type="number" name="silver" class="form-control" required min="0">
                </div>
                <div class="form-group">
                    <label class="form-label">Bronze Medal</label>
                    <input type="number" name="bronze" class="form-control" required min="0">
                </div>
                <div class="form-group">
                    <label class="form-label">Commendations</label>
                    <input type="number" name="comm" class="form-control" required min="0">
                </div>
                <div class="col-span-full flex justify-end gap-2">
                    <button type="submit" class="btn btn-primary">Save Ranking</button>
                    <button type="button" id="cancelBtn" class="btn btn-light">Cancel</button>
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
                            <tr class="border-b border-gray-200">
                                <td class="px-6 py-3">
                                    <?php if ($ranking['logo']): ?>
                                        <img src="<?php echo htmlspecialchars($ranking['logo']); ?>" alt="logo" class="h-10 w-auto">
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
                                        <button class="edit-ranking inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-black text-white" 
                                                data-id="<?php echo htmlspecialchars($ranking['id']); ?>">
                                            Edit
                                        </button>
                                        <button class="delete-ranking inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-red-500 text-white"
                                                data-id="<?php echo htmlspecialchars($ranking['id']); ?>">
                                            Delete
                                        </button>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const addRankingBtn = document.getElementById('addRankingBtn');
    const newRankingForm = document.getElementById('newRankingForm');
    const cancelBtn = document.getElementById('cancelBtn');
    const rankingForm = document.getElementById('rankingForm');

    // Toggle form visibility
    addRankingBtn.addEventListener('click', function() {
        newRankingForm.style.display = 'block';
    });

    cancelBtn.addEventListener('click', function() {
        newRankingForm.style.display = 'none';
        rankingForm.reset();
    });

    // Handle form submission
    rankingForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        try {
            const formData = new FormData(this);
            
            // Log form data for debugging
            for (let [key, value] of formData.entries()) {
                console.log(`${key}: ${value}`);
            }

            const response = await fetch('saveRanking.php', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();
            
            if (data.success) {
                alert('Ranking added successfully!');
                location.reload();
            } else {
                alert('Error: ' + (data.error || 'Unknown error occurred'));
                console.error('Server error:', data);
            }
        } catch (error) {
            console.error('Submission error:', error);
            alert('An error occurred: ' + error.message);
        }
    });
});
</script>

<?php include 'includes/footer.php'; ?>
