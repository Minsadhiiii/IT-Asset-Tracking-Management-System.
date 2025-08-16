<?php
// Include the database connection file
include('./config/connection.php');
// Fetch consumable data from the database
$sql = "SELECT c.consumableID, 
i.itemID, 
i.name, 
i.image, 
i.notes, 
cat.name AS categoryName, 
m.name AS manufacturerName, 
st.type AS `type`,  
o.name AS officeName, 
c.modelNo, 
c.quantity, 
c.remaining, 
ord.purchaseDate, 
ord.purchaseCost, 
su.name AS supplierName
FROM consumable c
LEFT JOIN item i ON i.itemID = c.itemID
LEFT JOIN `status` st ON i.statusID = st.statusID
LEFT JOIN `order` ord ON i.orderID = ord.orderID
LEFT JOIN `supplier` su ON ord.supplierID = su.supplierID
LEFT JOIN category cat ON i.categoryID = cat.categoryID
LEFT JOIN manufacturer m ON i.manufacturerID = m.manufacturerID
LEFT JOIN office o ON i.officeID = o.officeID;";
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
            <h1>Consumables List</h1>
            <?php if ($_SESSION["user"]["role"] !== 'Employee') : ?>
                <a href="addConsumable.php"><button class="primary-btn">Create New</button></a>
            <?php endif; ?>
            
        </div>
        <!-- Table Container -->
        <div class="table-container">
            <table id="consumableTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Notes</th>
                        <th>Category</th>
                        <th>Manufacturer</th>
                        <th>Status</th>
                        <th>Office</th>
                        <th>Model No</th>
                        <th>Quantity</th>
                        <th>Remaining</th>
                        <th>Purchase Date</th>
                        <th>Purchase Cost</th>
                        <th>Supplier</th>
                        <th>In/ Out</th>
                        <?php if ($_SESSION["user"]["role"] !== 'Employee') : ?>
                            <th>Action</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $index = 1; // Initialize index for row numbering
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $index++ . "</td>"; // Row number
                            echo "<td>" . $row["consumableID"] . "</td>";
                            echo "<td>" . $row["name"] . "</td>";
                            echo "<td><img src='images/" . $row["image"] . "' alt='" . $row["name"] . "' width='50' height='50'></td>";
                            echo "<td>" . $row["notes"] . "</td>";
                            echo "<td>" . $row["categoryName"] . "</td>";
                            echo "<td>" . $row["manufacturerName"] . "</td>";
                            echo "<td>" . $row["type"] . "</td>";
                            echo "<td>" . $row["officeName"] . "</td>";
                            echo "<td>" . $row["modelNo"] . "</td>";
                            echo "<td>" . $row["quantity"] . "</td>";
                            echo "<td>" . $row["remaining"] . "</td>";
                            echo "<td>" . $row["purchaseDate"] . "</td>";
                            echo "<td>" . $row["purchaseCost"] . "</td>";
                            echo "<td>" . $row["supplierName"] . "</td>";
                            echo "<td>";
                            if ($row['type'] === 'Deployed') {
                                echo "<a href='checkinAsset.php?itemID=" . $row['itemID'] . "' class='btn btn-success'>Checkin</a>";
                            } elseif ($row['type'] === 'Ready to Deploy') {
                                if ($row['remaining'] > 0) {
                                    echo "<a href='checkoutConsumable.php?consumableID=" . $row['consumableID'] . "' class='btn btn-primary'>Checkout</a>";
                                } else {
                                    echo "<button class='btn btn-primary' disabled>Checkout</button>";
                                }
                            } else {
                                echo "N/A";
                            }
                            echo "</td>";
                            if ($_SESSION["user"]["role"] !== 'Employee') :
                            echo "<td>
                                <a href='addConsumable.php?consumableID=" . $row['consumableID'] . "' class='btn btn-primary'>Update</a>
                                <form action='db_context.php' method='post' style='display:inline-block;'>
                              <input type='hidden' name='itemID' value='" . $row['itemID'] . "'>
                              <button type='submit' name='deleteConsumableButton' 
                              class='btn btn-danger' style='background-color:red;' 
                              onclick='return confirm(\"Are you sure you want to delete this consumable?\")'>
                              Delete</button>
                            </form>
                              </td>";
                            endif;
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='15'>No records found</td></tr>";
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
            $('#consumableTable').DataTable({
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
