<?php
// Database connection
include('./config/connection.php');

// Get consumableID from GET parameter
$consumableID = isset($_GET['consumableID']) ? intval($_GET['consumableID']) : null;
if (!$consumableID) {
    echo "Invalid Consumable ID.";
    exit;
}

// Fetch consumable details based on consumableID
$stmt = $conn->prepare("
    SELECT c.consumableID, 
           i.name AS consumableName, 
           i.itemID, 
           cat.name AS categoryName, 
           c.quantity AS totalQuantity,
           c.remaining
    FROM consumable c
    LEFT JOIN item i ON c.itemID = i.itemID
    LEFT JOIN category cat ON i.categoryID = cat.categoryID
    WHERE c.consumableID = ?");
$stmt->bind_param("i", $consumableID);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    echo "Consumable not found.";
    exit;
}
$consumable = $result->fetch_assoc();

// Fetch users for the dropdown
$users = $conn->query("SELECT userID, fname, lname FROM User");
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <?php include(__DIR__ . '/includes/header.php'); ?>
</head>
<body>
    <!-- Sidebar -->
    <?php include(__DIR__ . '/includes/sidemenu.php'); ?>

    <main class="main-content-create">
        <div class="main-header-create">
            <h1>Consumable Checkout</h1>
            
        </div>

        <div class="form-container">
            <div class="form-body">
                <form id="checkoutForm" action="db_context.php" method="POST" onsubmit="return validateCheckoutForm()">
                    <input type="hidden" name="consumableID" value="<?php echo htmlspecialchars($consumableID); ?>">
                    <input type="hidden" name="itemID" value="<?php echo htmlspecialchars($consumable['itemID']); ?>">

                    <!-- Display Consumable Name -->
                    <div class="form-element">
                        <label for="consumableName">Consumable Name:</label>
                        <input type="text" id="consumableName" name="consumableName" 
                               value="<?php echo htmlspecialchars($consumable['consumableName']); ?>" readonly>
                    </div>

                    <!-- Display Category -->
                    <div class="form-element">
                        <label for="category">Category:</label>
                        <input type="text" id="category" name="category" 
                               value="<?php echo htmlspecialchars($consumable['categoryName']); ?>" readonly>
                    </div>

                    <!-- Display Total Quantity -->
                    <div class="form-element">
                        <label for="totalQuantity">Total Quantity:</label>
                        <input type="text" id="totalQuantity" name="totalQuantity" 
                               value="<?php echo htmlspecialchars($consumable['totalQuantity']); ?>" readonly>
                    </div>

                    <!-- Display Remaining Quantity -->
                    <div class="form-element">
                        <label for="remaining">Remaining:</label>
                        <input type="text" id="remaining" name="remaining" 
                               value="<?php echo htmlspecialchars($consumable['remaining']); ?>" readonly>
                    </div>

                    <!-- Assignment Date -->
                    <div class="form-element">
                        <label for="assignmentDate">Assignment Date:</label>
                        <input type="date" id="assignmentDate" name="assignmentDate" required>
                    </div>

                    <!-- User Dropdown -->
                    <div class="form-element">
                        <label for="user">User:</label>
                        <select id="user" name="user" required>
                            <option value="" selected hidden>Select User</option>
                            <?php while ($user = $users->fetch_assoc()) { ?>
                                <option value="<?php echo $user['userID']; ?>">
                                    <?php echo htmlspecialchars($user['fname']) . " " . htmlspecialchars($user['lname']); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- Quantity User is Taking -->
                    <div class="form-element">
                        <label for="quantity">Quantity:</label>
                        <input type="number" id="quantity" placeholder="Quantity" name="quantity" min="1" 
                               max="<?php echo htmlspecialchars($consumable['remaining']); ?>" required>
                    </div>

                    <!-- Checkout Notes -->
                    <div class="form-element">
                        <label for="checkoutNotes">Checkout Notes:</label>
                        <textarea id="checkoutNotes" name="checkoutNotes" placeholder="Enter any notes"></textarea>
                    </div>

                    <div style="text-align: center;" id="error-box" class="error-box"></div>

                    <!-- Form Footer -->
                    <div class="form-footer">
                       
                        <button class="primary-button" type="submit" name="addConsumableCheckoutButton">Checkout Consumable</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <?php include('./includes/footer.php'); ?>

    <script>
        function validateCheckoutForm() {
            const assignmentDate = document.getElementById("assignmentDate").value.trim();
            const user = document.getElementById("user").value.trim();
            const quantity = document.getElementById("quantity").value.trim();
            const remaining = parseInt(document.getElementById("remaining").value.trim(), 10);
            const errorBox = document.getElementById("error-box");

            errorBox.innerHTML = "";

            if (!assignmentDate) {
                errorBox.innerHTML = "Assignment Date is required.";
                return false;
            }

            if (!user) {
                errorBox.innerHTML = "User is required.";
                return false;
            }

            if (!quantity || quantity <= 0) {
                errorBox.innerHTML = "Please enter a valid quantity.";
                return false;
            }

            if (quantity > remaining) {
                errorBox.innerHTML = "Quantity exceeds the remaining stock.";
                return false;
            }

            return true;
        }
    </script>
</body>

</html>
