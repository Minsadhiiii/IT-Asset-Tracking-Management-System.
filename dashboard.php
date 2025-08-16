<?php
// Database connection
include('./config/connection.php');
// Query to count the items by status
$query = "SELECT s.type, COUNT(i.itemID) as count
FROM item i
JOIN status s ON i.statusID = s.statusID
GROUP BY s.type;
";
$result = mysqli_query($conn, $query);

$statuses = [];
$counts = [];

while ($row = mysqli_fetch_assoc($result)) {
    $statuses[] = $row['type']; // Store statuses (labels)
    $counts[] = $row['count'];    // Store the count of each status
}

// Convert PHP arrays into JSON format for Chart.js
$statuses_json = json_encode($statuses);
$counts_json = json_encode($counts);



// Fetch counts from each table
$assets_count = $conn->query("SELECT COUNT(*) as count FROM asset")->fetch_assoc()['count'];
$licenses_count = $conn->query("SELECT COUNT(*) as count FROM license")->fetch_assoc()['count'];
$accessories_count = $conn->query("SELECT COUNT(*) as count FROM accessory")->fetch_assoc()['count'];
$consumables_count = $conn->query("SELECT COUNT(*) as count FROM consumable")->fetch_assoc()['count'];
$components_count = $conn->query("SELECT COUNT(*) as count FROM component")->fetch_assoc()['count'];


//asset assignment
$query = "SELECT o.name, i.itemID, aa.assignmentID, u.fname AS assignedTo, aa.assignmentDate
          FROM assetassignment aa
          LEFT JOIN item i ON aa.itemID = i.itemID
          LEFT JOIN office o ON i.officeID = o.officeID
          LEFT JOIN user u ON aa.userID = u.userID
          ORDER BY aa.assignmentDate DESC
          LIMIT 5"; // Fetch only the first 5 rows
$result = $conn->query($query);

?>
<!DOCTYPE html>
<!-- Created by CodingLab |www.youtube.com/CodingLabYT-->
<html lang="en" dir="ltr">
<head>
    <?php include(__DIR__ . '/includes/header.php'); ?>
</head>

<body>
    <!-- Sidebar -->
    <?php include(__DIR__ . '/includes/sidemenu.php'); ?>
        <main class="main-content">
            <div class="main-header">
                <h1>Dashboard</h1>
            </div>
            <div class="dashboard-summary">
                <!-- Assets Card -->
                <div class="card" style="background-color: #4CAF50;"> <!-- Green for Assets -->
                    <div class="card-body">
                        <div>
                            <h1><?php echo $assets_count; ?></h1> <!-- Display the asset count -->
                            <h3>Assets</h3>
                        </div>
                        <div>
                            <a href="assets.php">
                                <i class='bx bx-laptop'></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="assets.php" style="color: white; text-decoration: none;">
                            View All <i class='bx bx-right-arrow-alt'></i> <!-- Arrow icon -->
                        </a>
                    </div>
                </div>

                <!-- Licenses Card -->
                <div class="card" style="background-color: #FF5722;"> <!-- Orange for Licenses -->
                    <div class="card-body">
                        <div>
                            <h1><?php echo $licenses_count; ?></h1> <!-- Display the licenses count -->
                            <h3>Licenses</h3>
                        </div>
                        <div>
                            <a href="licenses.php">
                                <i class='bx bx-window-alt'></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="licenses.php" style="color: white; text-decoration: none;">
                            View All <i class='bx bx-right-arrow-alt'></i> <!-- Arrow icon -->
                        </a>
                    </div>
                </div>

                <!-- Accessories Card -->
                <div class="card" style="background-color: #2196F3;"> <!-- Blue for Accessories -->
                    <div class="card-body">
                        <div>
                            <h1><?php echo $accessories_count; ?></h1> <!-- Display the accessories count -->
                            <h3>Accessories</h3>
                        </div>
                        <div>
                            <a href="accessories.php">
                                <i class='bx bxs-keyboard'></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="accessories.php" style="color: white; text-decoration: none;">
                            View All <i class='bx bx-right-arrow-alt'></i> <!-- Arrow icon -->
                        </a>
                    </div>
                </div>

                <!-- Consumales Card -->
                <div class="card" style="background-color: #9C27B0;"> <!-- Purple for Consumables -->
                    <div class="card-body">
                        <div>
                            <h1><?php echo $consumables_count; ?></h1> <!-- Display the consumables count -->
                            <h3>Consumables</h3>
                        </div>
                        <div>
                            <a href="consumables.php">
                                <i class='bx bx-cart-alt'></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="consumables.php" style="color: white; text-decoration: none;">
                            View All <i class='bx bx-right-arrow-alt'></i> <!-- Arrow icon -->
                        </a>
                    </div>
                </div>

                <!-- Components Card -->
                <div class="card" style="background-color: #FFC107;"> <!-- Yellow for Components -->
                    <div class="card-body">
                        <div>
                            <h1><?php echo $components_count; ?></h1> <!-- Display the components count -->
                            <h3>Components</h3>
                        </div>
                        <div>
                            <a href="components.php">
                                <i class='bx bx-folder'></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="components.php" style="color: white; text-decoration: none;">
                            View All <i class='bx bx-right-arrow-alt'></i> <!-- Arrow icon -->
                        </a>
                    </div>
                </div>
            </div>

            <div class="body1">
            <!-- Recent Activity -->
            <div class="recent-activity">
                <div class="table-container">
                    <h3>Recent Activity</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Office</th>
                                <th>Asset ID</th>
                                <th>Assigned To</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>{$count}</td>
                                    <td>{$row['name']}</td>
                                    <td>{$row['itemID']}</td>
                                    <td>{$row['assignedTo']}</td>
                                    <td>{$row['assignmentDate']}</td>
                                </tr>";
                                $count++;
                            }
                            ?>
                        </tbody>
                    </table>
                    <a href="activityLog.php" class="btn-view-log">View Full Activity Log</a>
                </div>
            </div>
                <div class="asset-type">
                    <h2>Asset by Status Type</h2>
                    <canvas id="statusPieChart" width="300" height="300"></canvas>

                </div>
            </div>


        </main>
        <?php include('./includes/footer.php'); ?>

    <script>
        let sidebar = document.querySelector(".sidebar");
        let closeBtn = document.querySelector("#btn");


        closeBtn.addEventListener("click", () => {
            sidebar.classList.toggle("open");
            menuBtnChange(); //calling the function(optional)
        });
        // following are the code to change sidebar button(optional)
        function menuBtnChange() {
            if (sidebar.classList.contains("open")) {
                closeBtn.classList.replace("bx-menu", "bx-menu-alt-right"); //replacing the iocns class
            } else {
                closeBtn.classList.replace("bx-menu-alt-right", "bx-menu"); //replacing the iocns class
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Retrieve the data passed from PHP
        const statuses = <?php echo $statuses_json; ?>; // Labels
        const counts = <?php echo $counts_json; ?>; // Data

        // Create the chart
        const ctx = document.getElementById('statusPieChart').getContext('2d');
        const statusPieChart = new Chart(ctx, {
            type: 'pie', // Specifies the type of chart
            data: {
                labels: statuses, // Labels (statuses)
                datasets: [{
                    label: 'Item Status',
                    data: counts, // Data (counts of each status)
                    backgroundColor: [
                        'rgba(0, 0, 139, 0.6)', // Dark blue
                        'rgba(255, 0, 0, 0.6)', // Red
                        'rgba(0, 0, 139, 0.6)', // Dark blue (repeated)
                        'rgba(255, 0, 0, 0.6)' // Red (repeated)
                    ],
                    borderColor: [
                        'rgba(0, 0, 139, 1)', // Dark blue
                        'rgba(255, 0, 0, 1)', // Red
                        'rgba(0, 0, 139, 1)', // Dark blue (repeated)
                        'rgba(255, 0, 0, 1)' // Red (repeated)
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true, // Ensures the chart scales with window size
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        enabled: true
                    }
                }
            }
        });
    </script>
</body>

</html>