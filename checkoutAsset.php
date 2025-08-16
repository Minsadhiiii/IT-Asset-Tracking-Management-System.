<?php
// Database connection
include('./config/connection.php');

// Get itemID from GET parameter
$itemID = isset($_GET['itemID']) ? intval($_GET['itemID']) : null;
if (!$itemID) {
    echo "Invalid Item ID.";
    exit;
}

// Fetch item name based on itemID
$stmt = $conn->prepare("SELECT name FROM item WHERE itemID = ?");
$stmt->bind_param("i", $itemID);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    echo "Item not found.";
    exit;
}
$item = $result->fetch_assoc();
$itemName = $item['name'];

// Fetch users, statuses, and offices for dropdowns
$users = $conn->query("SELECT userID, fname, lname FROM User");
$statuses = $conn->query("SELECT statusID, type FROM Status");
$offices = $conn->query("SELECT officeID, name FROM Office");
?>


<!DOCTYPE html>
<!-- Created by CodingLab |www.yuube.com/CodingLabYT-->
<html lang="en" dir="ltr">
<head>
    <?php include(__DIR__ . '/includes/header.php'); ?>
</head>

<body>
    <!-- Sidebar -->
    <?php include(__DIR__ . '/includes/sidemenu.php'); ?>

    <main class="main-content-create">
        <div class="main-header-create">
            <h1>Checkout</h1>
           
        </div>

        <div class="form-container">
            <div class="form-body">
                <form id="checkoutForm" action="db_context.php" method="POST" onsubmit="return validateCheckoutForm()">
                    <input type="hidden" name="itemID" value="<?php echo htmlspecialchars($itemID); ?>">

                    <div class="form-element">
                        <label for="itemName">Item Name:</label>
                        <input type="text" id="itemName" name="itemName" value="<?php echo htmlspecialchars($itemName); ?>" readonly>
                    </div>

                    <div class="form-element">
                        <label for="assignmentDate">Assignment Date:</label>
                        <input type="date" id="assignmentDate" name="assignmentDate">
                    </div>

                    <div class="form-element">
                        <label for="user">User:</label>
                        <select id="user" name="user" required>
                            <option value="" selected hidden>Select User</option>
                            <?php while ($user = $users->fetch_assoc()) { ?>
                                <option value="<?php echo $user['userID']; ?>"><?php echo htmlspecialchars($user['fname']); echo ' '; echo htmlspecialchars($user['lname']); ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-element">
                        <label for="expCheckinDate">Expected Check-In Date:</label>
                        <input type="date" id="expCheckinDate" name="expCheckinDate">
                    </div>

                    

                    <div class="form-element">
                        <label for="office">Office:</label>
                        <select id="office" name="office" >
                            <option value="" selected hidden>Select Office</option>
                            <?php while ($office = $offices->fetch_assoc()) { ?>
                                <option value="<?php echo $office['officeID']; ?>"><?php echo htmlspecialchars($office['name']); ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-element">
                        <label for="checkoutNotes">Checkout Notes:</label>
                        <textarea id="checkoutNotes" name="checkoutNotes" placeholder="Enter any notes"></textarea>
                    </div>

                    <div style="text-align: center;" id="error-box" class="error-box"></div>

                    <div class="form-footer">
                        
                        <button class="primary-button" type="submit" name="addCheckoutButton">Checkout Asset</button>
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
            return true;
        }
    </script>
</body>
</html>