<?php
// Include the database connection file
include('./config/connection.php');
// Fetch asset data from the database
$sql = "SELECT 
    u.userID,
    u.fname,
    u.lname,
    u.role,
    u.email,
    u.loginEnabled,
    u.image,
    d.name AS departmentName,
    s.type AS statusType
FROM 
    user u
LEFT JOIN 
    department d ON u.departmentID = d.id
LEFT JOIN 
    status s ON u.statusID = s.statusID;";
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
            <h1>Manage Users</h1>
            <?php if ($_SESSION["user"]["role"] !== 'Employee') : ?>
                <a href="addUsers.php"><button class="primary-btn">Create New User</button></a>
            <?php endif; ?>

        </div>
        <!-- Table Container -->
        <div class="table-container">
            <table id="userTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User ID</th>
                        <th>Image</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Department</th>
                        <th>Status</th>
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
                            echo "<td>" . $row["userID"] . "</td>";
                            echo "<td><img src='./images/" . $row["image"] . "' alt='User Image' width='50' height='50'></td>";
                            echo "<td>" . $row["fname"] . "</td>";
                            echo "<td>" . $row["lname"] . "</td>";
                            echo "<td>" . $row["email"] . "</td>";
                            echo "<td>" . $row["role"] . "</td>";
                            echo "<td>" . $row["departmentName"] . "</td>";
                            echo "<td>" . $row["statusType"] . "</td>";
                            echo "<td>
                    <a href='addUsers.php?userID=" . $row['userID'] . "' class='btn btn-primary'>Update</a>
                    <form action='db_context.php' method='post' style='display:inline-block;'>
                        <input type='hidden' name='userID' value='" . $row['userID'] . "'>
                        <button type='submit' name='deleteUserButton' class='btn btn-danger' 
                        class='btn btn-danger' style='background-color:red;' 
                        onclick='return confirm(\"Are you sure you want to delete this user?\")'>
                        Delete</button>
                    </form>
                </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10'>No records found</td></tr>";
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
            $('#userTable').DataTable({
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