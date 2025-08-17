<?php
include('./config/connection.php');

// Fetch counts of assets assigned to this employee
$userID = $_SESSION["user"]["userID"];
$assignedAssetsCount = $conn->query("SELECT COUNT(*) as count 
    FROM assetassignment aa 
    JOIN item i ON aa.itemID = i.itemID
    WHERE aa.userID = '$userID' AND aa.status = 'Active'")->fetch_assoc()['count'];

// Fetch last 5 assignments for this employee
$query = "SELECT o.name AS officeName, i.name AS assetName, aa.assignmentDate
          FROM assetassignment aa
          LEFT JOIN item i ON aa.itemID = i.itemID
          LEFT JOIN office o ON i.officeID = o.officeID
          WHERE aa.userID = '$userID'
          ORDER BY aa.assignmentDate DESC
          LIMIT 5";
$assignmentsResult = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include(__DIR__ . '/includes/header.php'); ?>
    <style>
        .welcome-card {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: white;
            padding: 2rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }
        .dashboard-summary {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .card {
            flex: 1 1 300px;
            padding: 1.5rem;
            border-radius: 10px;
            color: white;
            box-shadow: 0 2px 12px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card-body h1 { font-size: 2rem; margin: 0; }
        .card-body h3 { margin: 0; }
        .recent-assignments table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        .recent-assignments table th, .recent-assignments table td {
            border: 1px solid #ddd;
            padding: 0.75rem;
            text-align: left;
        }
        .recent-assignments table th {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <?php include(__DIR__ . '/includes/sidemenu.php'); ?>

    <main class="main-content">
        <!-- Welcome Card -->
        <div class="welcome-card">
            <h1>Welcome, <?php echo $_SESSION["user"]["fname"]; ?>!</h1>
            <p>Here’s a summary of your assets and recent assignments.</p>
        </div>

        <!-- Dashboard Summary Cards -->
        <div class="dashboard-summary">
            <div class="card" style="background-color: #4CAF50;">
                <div class="card-body">
                    <div>
                        <h1><?php echo $assignedAssetsCount; ?></h1>
                        <h3>Assigned Assets</h3>
                    </div>
                    <div>
                        <i class='bx bx-laptop' style="font-size: 2.5rem;"></i>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="empAssetAssignment.php" style="color: white; text-decoration: none;">View My Assets <i class='bx bx-right-arrow-alt'></i></a>
                </div>
            </div>

            <!-- You can add other relevant cards for employees if needed -->
        </div>

        <!-- Recent Assignments Table -->
        <div class="recent-assignments" style="margin-top: 2rem;">
            <h3>Recent Asset Assignments</h3>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Asset Name</th>
                        <th>Office</th>
                        <th>Assignment Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($assignmentsResult->num_rows > 0) {
                        $i = 1;
                        while($row = $assignmentsResult->fetch_assoc()) {
                            echo "<tr>
                                <td>".$i++."</td>
                                <td>".$row['assetName']."</td>
                                <td>".$row['officeName']."</td>
                                <td>".$row['assignmentDate']."</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No assignments found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <?php include('./includes/footer.php'); ?>
</body>
</html>
