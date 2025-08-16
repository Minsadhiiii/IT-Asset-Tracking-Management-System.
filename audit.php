<?php
include('./config/connection.php');

// Fetch audit data with item details
$sql = "SELECT 
    a.auditID,
    a.auditDate,
    a.auditor,
    a.findings,
    i.name AS itemName
FROM 
    Audit a
INNER JOIN 
    Item i ON a.itemID = i.itemID;";
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
            <h1>Audit Management</h1>
            <a href="addAudit.php"><button class="primary-btn">Add New Audit</button></a>
        </div>

        <!-- Table Container -->
        <div class="table-container">
            <table id="auditTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Audit ID</th>
                        <th>Audit Date</th>
                        <th>Auditor</th>
                        <th>Findings</th>
                        <th>Item Name</th>
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
                            echo "<td>" . $row["auditID"] . "</td>";
                            echo "<td>" . htmlspecialchars($row["auditDate"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["auditor"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["findings"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["itemName"]) . "</td>";
                            echo "<td>
                                <a href='addAudit.php?auditID=" . $row['auditID'] . "' class='btn btn-primary'>Update</a>
                                <form action='db_context.php' method='post' style='display:inline-block;'>
                                    <input type='hidden' name='auditID' value='" . $row['auditID'] . "'>
                                    <button type='submit' name='deleteAuditButton' style='background-color:red;' class='btn btn-danger' 
                                    onclick='return confirm(\"Are you sure you want to delete this audit record?\")'>
                                    Delete</button>
                                </form>
                            </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No records found</td></tr>";
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
            $('#auditTable').DataTable({
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
