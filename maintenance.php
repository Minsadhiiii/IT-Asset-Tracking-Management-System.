<?php
// Include the database connection file
include('./config/connection.php');

// Fetch maintenance data with item details
$sql = "SELECT 
    m.maintenanceID,
    m.startDate,
    m.completionDate,
    m.type,
    m.description,
    m.cost,
    i.name AS itemName
FROM 
    Maintenance m
LEFT JOIN 
    Item i ON m.itemID = i.itemID;";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include(__DIR__ . '/includes/header.php'); ?>
</head>

<body>
    <!-- Sidebar -->
    <?php include(__DIR__ . '/includes/sidemenu.php'); ?>

    <!-- Main Content -->
    <main class="main-content">
        <div class="main-header">
            <h1>Manage Maintenance</h1>
            <a href="addMaintenance.php"><button class="primary-btn">Add New Maintenance</button></a>
        </div>
        <!-- Table Container -->
        <div class="table-container">
            <table id="maintenanceTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Maintenance ID</th>
                        <th>Item Name</th>
                        <th>Start Date</th>
                        <th>Completion Date</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Cost</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $index = 1; // Initialize index for row numbering
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $index++ . "</td>"; // Row number
                            echo "<td>" . $row["maintenanceID"] . "</td>";
                            echo "<td>" . htmlspecialchars($row["itemName"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["startDate"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["completionDate"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["type"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["description"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["cost"]) . "</td>";
                            echo "<td>
                                <a href='addMaintenance.php?maintenanceID=" . $row['maintenanceID'] . "' class='btn btn-primary'>Update</a>
                                <form action='db_context.php' method='post' style='display:inline-block;'>
                                    <input type='hidden' name='maintenanceID' value='" . $row['maintenanceID'] . "'>
                                    <button type='submit' name='deleteMaintenanceButton' style='background-color:red;' class='btn btn-danger' 
                                    onclick='return confirm(\"Are you sure you want to delete this maintenance record?\")'>
                                    Delete</button>
                                </form>
                            </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>No records found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
    <?php include('./includes/footer.php'); ?>

    <script src="./assets/js/hamburger.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#maintenanceTable').DataTable({
                "paging": true,
                "lengthChange": false,
                "pageLength": 15,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "pagingType": "simple_numbers",
                dom: 'Bfrtip',
                buttons: ['copy', 'excel', 'pdf', 'print']
            });
        });
    </script>
</body>

</html>
