<?php

include('./config/connection.php');

// Redirect if not logged in
if (!isset($_SESSION["user"]["userID"])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include(__DIR__ . '/includes/header.php'); ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
</head>

<body>
    <?php include(__DIR__ . '/includes/sidemenu.php'); ?>

    <main class="main-content">
        <div class="container mt-4">
            <h3>My Assigned Assets</h3>
            <table id="assignedAssetsTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Assignment ID</th>
                        <th>Assignment Date</th>
                        <th>Return Date</th>
                        <th>Expected Check-in Date</th>
                        <th>Status</th>
                        <th>Quantity</th>
                        <th>Checked Out Date</th>
                        <th>Item Name</th>
                        <th>Office Name</th>
                    </tr>
                </thead>
            </table>

        </div>
    </main>

    <?php include('./includes/footer.php'); ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#assignedAssetsTable').DataTable({
                "ajax": {
                    "url": "getAssignedAssets.php",
                    "dataSrc": "data",
                    "error": function(xhr, error, thrown) {
                        console.error("DataTables error:", xhr.responseText);
                    }
                },
                "columns": [{
                        "data": "assignmentID"
                    },
                    {
                        "data": "assignmentDate"
                    },
                    {
                        "data": "returnDate"
                    },
                    {
                        "data": "expCheckinDate"
                    },
                    {
                        "data": "status"
                    },
                    {
                        "data": "quantity"
                    },
                    {
                        "data": "checkedOutDate"
                    },
                    {
                        "data": "itemName"
                    },
                    {
                        "data": "officeName"
                    }
                ]
            });
        });
    </script>

</body>

</html>