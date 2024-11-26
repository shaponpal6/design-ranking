<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once 'includes/db_config.php';
require_once 'includes/check_auth.php';
include 'includes/header.php';
include 'includes/sidebar.php';
?>
<title>Dashboard | Admin Panel</title>

<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->


<!-- Page Title Start -->
<div class="flex items-center md:justify-between flex-wrap gap-2 mb-6">
    <h4 class="text-default-900 text-lg font-medium mb-2">Dashboard</h4>

    <div class="md:flex hidden items-center gap-3 text-sm font-semibold">
        <a href="#" class="text-sm font-medium text-default-700">Dashboard</a>

    </div>
</div>
<!-- Page Title End -->


<div class="grid xl:grid-cols-3 md:grid-cols-2 gap-6 mb-6">
    <div class="card">
        <div class="card-header flex justify-between items-center">
            <h4 class="card-title">Total Rankings</h4>
        </div>

        <div class="card-body">
            <div id="month-sales-chart" class="apex-charts"></div>
        </div>

        <div class="border-t border-default-200 border-dashed card-body">
            <div class="flex items-center justify-center gap-3">
                <div class="flex items-center gap-1">
                    <div class="size-3 rounded-full bg-green-500"></div>
                    <p class="text-sm text-default-700">Agency</p>
                </div>
                <div class="flex items-center gap-1">
                    <div class="size-3 rounded-full bg-yellow-500"></div>
                    <p class="text-sm text-default-700">In-House</p>
                </div>

                <div class="flex items-center gap-1">
                    <div class="size-3 rounded-full bg-indigo-500"></div>
                    <p class="text-sm text-default-700">Creative</p>
                </div>

                <div class="flex items-center gap-1">
                    <div class="size-3 rounded-full bg-danger"></div>
                    <p class="text-sm text-default-700">Student</p>
                </div>
            </div>
        </div>
    </div>

    <div class="xl:col-span-2">
        <div class="card">
            <div class="card-header">
                <h5 class="text-base">Rankings by Year</h5>
            </div>
            <div class="card-body">
                <div id="revenue-chart" class="apex-charts"></div>
            </div>
        </div>
    </div>


</div>

<div class="grid xl:grid-cols-1 gap-6">

    <div class="card overflow-hidden">
        <div class="card-header flex justify-between items-center">
            <h4 class="card-title">Agency Design Rankings</h4>
            <a href="#" class="btn btn-sm bg-light !text-sm text-gray-800 ">View All</a>
        </div>

        <div class="overflow-x-auto custom-scroll">
            <div class="min-w-full inline-block align-middle whitespace-nowrap">
                <div class="overflow-hidden">
                    <table class="min-w-full">
                        <thead class="bg-light/40 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-start">LOGO</th>
                                <th class="px-6 py-3 text-start">ORGANISATION</th>
                                <th class="px-6 py-3 text-start">LOCATION</th>
                                <th class="px-6 py-3 text-start">POINTS</th>
                                <th class="px-6 py-3 text-start">AWARDS</th>
                                <th class="px-6 py-3 text-start">1ST</th>
                                <th class="px-6 py-3 text-start">2ND</th>
                                <th class="px-6 py-3 text-start">3RD</th>
                                <th class="px-6 py-3 text-start">4TH</th>
                                <th class="px-6 py-3 text-start">BLACK</th>
                                <th class="px-6 py-3 text-start">GOLD</th>
                                <th class="px-6 py-3 text-start">SILVER</th>
                                <th class="px-6 py-3 text-start">BRONZE</th>
                                <th class="px-6 py-3 text-start">COMM</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-200">
                                <td class="px-6 py-3"><img src="assets/images/logos/Kind-logo.png" alt="logo"></td>
                                <td class="px-6 py-3">Kind</td>
                                <td class="px-6 py-3">Norway</td>
                                <td class="px-6 py-3">220</td>
                                <td class="px-6 py-3">90</td>
                                <td class="px-6 py-3">12</td>
                                <td class="px-6 py-3">2</td>
                                <td class="px-6 py-3">1</td>
                                <td class="px-6 py-3">3</td>
                                <td class="px-6 py-3">5</td>
                                <td class="px-6 py-3">6</td>
                                <td class="px-6 py-3">7</td>
                                <td class="px-6 py-3">8</td>
                                <td class="px-6 py-3">7</td>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> <!-- end card-->

    <div class="card overflow-hidden">
        <div class="card-header flex justify-between items-center">
            <h4 class="card-title">In-House Design Rankings</h4>
            <a href="#" class="btn btn-sm bg-light !text-sm text-gray-800 ">View All</a>
        </div>

        <div class="overflow-x-auto custom-scroll">
            <div class="min-w-full inline-block align-middle whitespace-nowrap">
                <div class="overflow-hidden">
                    <table class="min-w-full">
                        <thead class="bg-light/40 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-start">LOGO</th>
                                <th class="px-6 py-3 text-start">ORGANISATION</th>
                                <th class="px-6 py-3 text-start">LOCATION</th>
                                <th class="px-6 py-3 text-start">POINTS</th>
                                <th class="px-6 py-3 text-start">AWARDS</th>
                                <th class="px-6 py-3 text-start">1ST</th>
                                <th class="px-6 py-3 text-start">2ND</th>
                                <th class="px-6 py-3 text-start">3RD</th>
                                <th class="px-6 py-3 text-start">4TH</th>
                                <th class="px-6 py-3 text-start">BLACK</th>
                                <th class="px-6 py-3 text-start">GOLD</th>
                                <th class="px-6 py-3 text-start">SILVER</th>
                                <th class="px-6 py-3 text-start">BRONZE</th>
                                <th class="px-6 py-3 text-start">COMM</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-200">
                                <td class="px-6 py-3"><img src="assets/images/logos/Kind-logo.png" alt="logo"></td>
                                <td class="px-6 py-3">Kind</td>
                                <td class="px-6 py-3">Norway</td>
                                <td class="px-6 py-3">220</td>
                                <td class="px-6 py-3">90</td>
                                <td class="px-6 py-3">12</td>
                                <td class="px-6 py-3">2</td>
                                <td class="px-6 py-3">1</td>
                                <td class="px-6 py-3">3</td>
                                <td class="px-6 py-3">5</td>
                                <td class="px-6 py-3">6</td>
                                <td class="px-6 py-3">7</td>
                                <td class="px-6 py-3">8</td>
                                <td class="px-6 py-3">7</td>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> <!-- end card-->

    <div class="card overflow-hidden">
        <div class="card-header flex justify-between items-center">
            <h4 class="card-title">Creative Design Rankings</h4>
            <a href="#" class="btn btn-sm bg-light !text-sm text-gray-800 ">View All</a>
        </div>

        <div class="overflow-x-auto custom-scroll">
            <div class="min-w-full inline-block align-middle whitespace-nowrap">
                <div class="overflow-hidden">
                    <table class="min-w-full">
                        <thead class="bg-light/40 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-start">LOGO</th>
                                <th class="px-6 py-3 text-start">ORGANISATION</th>
                                <th class="px-6 py-3 text-start">LOCATION</th>
                                <th class="px-6 py-3 text-start">POINTS</th>
                                <th class="px-6 py-3 text-start">AWARDS</th>
                                <th class="px-6 py-3 text-start">1ST</th>
                                <th class="px-6 py-3 text-start">2ND</th>
                                <th class="px-6 py-3 text-start">3RD</th>
                                <th class="px-6 py-3 text-start">4TH</th>
                                <th class="px-6 py-3 text-start">BLACK</th>
                                <th class="px-6 py-3 text-start">GOLD</th>
                                <th class="px-6 py-3 text-start">SILVER</th>
                                <th class="px-6 py-3 text-start">BRONZE</th>
                                <th class="px-6 py-3 text-start">COMM</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-200">
                                <td class="px-6 py-3"><img src="assets/images/logos/Kind-logo.png" alt="logo"></td>
                                <td class="px-6 py-3">Kind</td>
                                <td class="px-6 py-3">Norway</td>
                                <td class="px-6 py-3">220</td>
                                <td class="px-6 py-3">90</td>
                                <td class="px-6 py-3">12</td>
                                <td class="px-6 py-3">2</td>
                                <td class="px-6 py-3">1</td>
                                <td class="px-6 py-3">3</td>
                                <td class="px-6 py-3">5</td>
                                <td class="px-6 py-3">6</td>
                                <td class="px-6 py-3">7</td>
                                <td class="px-6 py-3">8</td>
                                <td class="px-6 py-3">7</td>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> <!-- end card-->

    <div class="card overflow-hidden">
        <div class="card-header flex justify-between items-center">
            <h4 class="card-title">Student Design Rankings</h4>
            <a href="#" class="btn btn-sm bg-light !text-sm text-gray-800 ">View All</a>
        </div>

        <div class="overflow-x-auto custom-scroll">
            <div class="min-w-full inline-block align-middle whitespace-nowrap">
                <div class="overflow-hidden">
                    <table class="min-w-full">
                        <thead class="bg-light/40 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-start">LOGO</th>
                                <th class="px-6 py-3 text-start">ORGANISATION</th>
                                <th class="px-6 py-3 text-start">LOCATION</th>
                                <th class="px-6 py-3 text-start">POINTS</th>
                                <th class="px-6 py-3 text-start">AWARDS</th>
                                <th class="px-6 py-3 text-start">1ST</th>
                                <th class="px-6 py-3 text-start">2ND</th>
                                <th class="px-6 py-3 text-start">3RD</th>
                                <th class="px-6 py-3 text-start">4TH</th>
                                <th class="px-6 py-3 text-start">BLACK</th>
                                <th class="px-6 py-3 text-start">GOLD</th>
                                <th class="px-6 py-3 text-start">SILVER</th>
                                <th class="px-6 py-3 text-start">BRONZE</th>
                                <th class="px-6 py-3 text-start">COMM</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-200">
                                <td class="px-6 py-3"><img src="assets/images/logos/Kind-logo.png" alt="logo"></td>
                                <td class="px-6 py-3">Kind</td>
                                <td class="px-6 py-3">Norway</td>
                                <td class="px-6 py-3">220</td>
                                <td class="px-6 py-3">90</td>
                                <td class="px-6 py-3">12</td>
                                <td class="px-6 py-3">2</td>
                                <td class="px-6 py-3">1</td>
                                <td class="px-6 py-3">3</td>
                                <td class="px-6 py-3">5</td>
                                <td class="px-6 py-3">6</td>
                                <td class="px-6 py-3">7</td>
                                <td class="px-6 py-3">8</td>
                                <td class="px-6 py-3">7</td>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> <!-- end card-->

</div>

<?php include 'includes/footer.php'; ?>