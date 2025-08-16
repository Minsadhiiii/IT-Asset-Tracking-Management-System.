<?php
include('./config/connection.php');
// Variables
$componentID = isset($_GET['componentID']) ? intval($_GET['componentID']) : null;
$isEditMode = $componentID !== null;

// Fetch categories and statuses
$categories = $conn->query("SELECT categoryID, name FROM Category");
$manufacturers = $conn->query("SELECT manufacturerID, name FROM Manufacturer");
$suppliers = $conn->query("SELECT supplierID, name FROM Supplier");
$offices = $conn->query("SELECT officeID, name FROM Office");
$statuses = $conn->query("SELECT statusID, type FROM Status");

// Initialize variables
$name = $modelNo = $quantity = $serial = $image = $notes = $categoryID = $statusID = $location =
    $purchaseDate = $warrantyExpiry = $purchaseCost = $checkinCheckout = $manufacturerID = $officeID = $supplierID = $warrantyStartDate = $warrantyEndDate =  "";

if ($isEditMode) {
    $stmt = $conn->prepare("SELECT cmp.componentID, 
        i.name, 
        i.image, 
        i.notes, 
        cat.name AS categoryName, 
        cat.categoryID AS categoryID, 
        m.manufacturerID AS manufacturerID, 
        m.name AS manufacturerName, 
        o.officeID AS officeID, 
        o.name AS officeName, 
        st.type AS `type`,  
        st.statusID AS statusID,  
        cmp.serial, 
        cmp.modelNo, 
        cmp.quantity, 
        w.startDate AS warrantyStartDate, 
        w.endDate AS warrantyEndDate, 
        ord.purchaseDate, 
        ord.purchaseCost, 
        su.name AS supplierName,
        su.supplierID AS supplierID
        FROM component cmp
        LEFT JOIN item i ON i.itemID = cmp.itemID
        LEFT JOIN `status` st ON i.statusID = st.statusID
        LEFT JOIN `order` ord ON i.orderID = ord.orderID
        LEFT JOIN `supplier` su ON ord.supplierID = su.supplierID
        LEFT JOIN category cat ON i.categoryID = cat.categoryID
        LEFT JOIN manufacturer m ON i.manufacturerID = m.manufacturerID
        LEFT JOIN office o ON i.officeID = o.officeID
        LEFT JOIN warranty w ON cmp.warrantyID = w.warrantyID WHERE componentID = ?");
    $stmt->bind_param("i", $componentID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $component = $result->fetch_assoc();
        // Populate variables with existing data
        extract($component);
    } else {
        echo "Invalid Asset ID.";
        exit;
    }
}
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
            <h1>Add Component</h1>
            
        </div>

        <div class="form-container">
            <div class="form-body">
                <form id="componentForm" action="db_context.php" method="POST" enctype="multipart/form-data" onsubmit="return validateComponentForm()">
                    <input type="hidden" name="componentID" value="<?php echo htmlspecialchars($componentID ?? ''); ?>">


                    <!-- Name -->
                    <div class="form-element">
                        <label for="componentName">Component Name:</label>
                        <input type="text" id="componentName" name="componentName" placeholder="Component Name" value="<?php echo htmlspecialchars($name); ?>" >
                    </div>

                    <div class="form-element">
                        <label for="serialNumber">Serial Number:</label>
                        <input type="text" id="serial" name="serial" placeholder="Serial Number" value="<?php echo htmlspecialchars($serial); ?>">
                    </div>

                    <!-- Image -->
                    <div class="form-element">
                        <label for="image">Image:</label>
                        <input type="file" id="image" name="image">
                    </div>

                    <div class="form-element">
                        <label for="notes">Notes:</label>
                        <textarea id="notes" name="notes" placeholder="Notes"><?php echo htmlspecialchars($notes); ?></textarea>
                    </div>

                    <div class="form-element">
                        <label for="category">Category:</label>
                        <select id="category" name="category">
                        <option value="" selected hidden>Select Category</option>
                            <?php while ($category = $categories->fetch_assoc()) { ?>
                                <option value="<?php echo $category['categoryID']; ?>" <?php echo $categoryID == $category['categoryID'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </option>
                            <?php } ?>
                        </select>
                        <button id="add-category-btn">Add</button>
                    </div>

                    <div class="form-element">
                        <label for="manufacturer">Manufacturer:</label>
                        <select id="manufacturer" name="manufacturer">
                            <option value="" selected hidden>Select Manufacturer</option>
                            <?php while ($manufacturer = $manufacturers->fetch_assoc()) { ?>
                                <option value="<?php echo $manufacturer['manufacturerID']; ?>" <?php echo $manufacturerID == $manufacturer['manufacturerID'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($manufacturer['name']); ?>
                                </option>
                            <?php } ?>
                        </select>
                        <button id="add-manufacturer-btn">Add</button>
                    </div>

                    <div class="form-element">
                        <label for="status">Status:</label>
                        <select id="status" name="status">
                            <option value="" selected hidden>Select Status</option>
                            <?php while ($status = $statuses->fetch_assoc()) { ?>
                                <option value="<?php echo $status['statusID']; ?>" <?php echo $statusID == $status['statusID'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($status['type']); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-element">
                        <label for="office">Office:</label>
                        <select id="office" name="office">
                            <option value="" selected hidden>Select Office</option>
                            <?php while ($office = $offices->fetch_assoc()) { ?>
                                <option value="<?php echo $office['officeID']; ?>" <?php echo $officeID == $office['officeID'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($office['name']); ?>
                                </option>
                            <?php } ?>
                        </select>
                        <button id="add-office-btn">Add</button>
                    </div>

                    <!-- Model No -->
                    <div class="form-element">
                        <label for="modelNo">Model No:</label>
                        <input type="text" id="modelNo" name="modelNo" placeholder="Model No" value="<?php echo htmlspecialchars($modelNo); ?>">
                    </div>

                    <!-- Quantity -->
                    <div class="form-element">
                        <label for="quantity">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" placeholder="Quantity" min="1" value="<?php echo htmlspecialchars($quantity); ?>">
                    </div>

                    <!-- Order Details -->
                    <div class="section">
                        <h3 id="orderHeading">Order Details</h3>
                        <div id="orderDetails" class="hidden">
                            <div class="form-element">
                                <label for="purchaseDate">Purchase Date:</label>
                                <input type="date" id="purchaseDate" name="purchaseDate" value="<?php echo htmlspecialchars($purchaseDate); ?>">
                            </div>
                            <div class="form-element">
                                <label for="purchaseCost">Purchase Cost:</label>
                                <input type="number" id="purchaseCost" name="purchaseCost" step="0.01" placeholder="Purchase Cost" value="<?php echo htmlspecialchars($purchaseCost); ?>">
                            </div>
                            <div class="form-element">
                                <label for="supplier">Supplier:</label>
                                <select id="supplier" name="supplier">
                                    <option value="" selected hidden>Select Supplier</option>
                                    <?php while ($supplier = $suppliers->fetch_assoc()) { ?>
                                        <option value="<?php echo $supplier['supplierID']; ?>" <?php echo $supplierID == $supplier['supplierID'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($supplier['name']); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <button id="add-supplier-btn">Add</button>
                            </div>
                        </div>
                    </div>

                    <div class="section">
                        <h3 id="warrantyHeading">Warranty Details</h3>
                        <div id="warrantyDetails" class="hidden">
                            <div class="form-element">
                                <label for="warrantyStartDate">Start Date:</label>
                                <input type="date" id="warrantyStartDate" name="warrantyStartDate" value="<?php echo htmlspecialchars($warrantyStartDate); ?>">
                            </div>
                            <div class="form-element">
                                <label for="warrantyEndDate">End Date:</label>
                                <input type="date" id="warrantyEndDate" name="warrantyEndDate" value="<?php echo htmlspecialchars($warrantyEndDate); ?>">
                            </div>
                        </div>
                    </div>
                    <div style="text-align: center; margin-top: 20px;" id="error-box" class="error-box"></div>
                    <!-- Form Footer -->
                    <div class="form-footer">
                        
                        <button class="primary-button" type="submit" name="<?php echo $isEditMode ? 'updateComponentButton' : 'addComponentButton'; ?>">
                            <?php echo $isEditMode ? "Update Component" : "Add Component"; ?>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </main>
    <?php include('./includes/footer.php'); ?>
    <div class="overlay" id="popup-overlay"> </div>
    <div id="popup-box-category" class="popup-box">
        <div class="popup-header">
            <button class="close-btn" id="close-popup-category">&times;</button>
            <h2>Add Category</h2>
        </div>
        <form action="db_context.php" method="POST" enctype="multipart/form-data">
            <div class="popup-element">
                <label for="categoryName">Category Name:</label>
                <input type="text" id="categoryName" placeholder="Category Name" name="categoryName" required>
            </div>
            <div class="popup-footer">

                <button class="action-btn" name="addCategoryButton" id="confirm-add-category">Confirm</button>
            </div>
        </form>
    </div>

    <div id="popup-box-manufacturer" class="popup-box">
        <div class="popup-header">
            <button class="close-btn" id="close-popup-manufacturer">&times;</button>
            <h2>Add Manufacturer</h2>
        </div>
        <form action="db_context.php" method="POST" enctype="multipart/form-data">
            <div class="popup-element">
                <label for="manufacturerName">Manufacturer Name:</label>
                <input type="text" id="manufacturerName" placeholder="Manufacturer Name" name="manufacturerName" required>
            </div>
            <div class="popup-element">
                <label for="url">URL:</label>
                <input type="text" id="url" placeholder="URL" name="url">
            </div>
            <div class="popup-element">
                <label for="email">Support Email:</label>
                <input type="text" id="email" placeholder="Email" name="email">
            </div>
            <div class="popup-element">
                <label for="phone">Support Phone:</label>
                <input type="text" id="phone" placeholder="Phone" name="phone">
            </div>
            <div class="popup-footer">

                <button class="action-btn" name="addManufacturerButton" id="confirm-add-manufacturer">Confirm</button>
            </div>
        </form>
    </div>


    <div id="popup-box-office" class="popup-box">
        <div class="popup-header">
            <button class="close-btn" id="close-popup-office">&times;</button>
            <h2>Add Office</h2>
        </div>
        <form action="db_context.php" method="POST" enctype="multipart/form-data">
            <div class="popup-element">
                <label for="officeName">Office Name:</label>
                <input type="text" id="officeName" placeholder="Office Name" name="officeName" required>
            </div>
            <div class="popup-element">
                <label for="address">Address:</label>
                <input type="text" id="address" placeholder="Address" name="address">
            </div>
            <div class="popup-element">
                <label for="email">Email:</label>
                <input type="text" id="email" placeholder="Email" name="email">
            </div>
            <div class="popup-element">
                <label for="phone">Phone:</label>
                <input type="text" id="phone" placeholder="Phone" name="phone">
            </div>
            <div class="popup-footer">

                <button class="action-btn" name="addOfficeButton" id="confirm-add-office">Confirm</button>
            </div>
        </form>
    </div>

    <div id="popup-box-supplier" class="popup-box">
        <div class="popup-header">
            <button class="close-btn" id="close-popup-supplier">&times;</button>
            <h2>Add Supplier</h2>
        </div>
        <form action="db_context.php" method="POST" enctype="multipart/form-data">
            <div class="popup-element">
                <label for="supplierName">Supplier Name:</label>
                <input type="text" id="supplierName" placeholder="Supplier Name" name="supplierName" required>
            </div>
            <div class="popup-element">
                <label for="address">Address:</label>
                <input type="text" id="address" placeholder="Address" name="address">
            </div>
            <div class="popup-element">
                <label for="contactName">Contact Name:</label>
                <input type="text" id="contactName" placeholder="Contact Name" name="contactName">
            </div>
            <div class="popup-element">
                <label for="email">Email:</label>
                <input type="text" id="email" placeholder="Email" name="email">
            </div>
            <div class="popup-element">
                <label for="phone">Phone:</label>
                <input type="text" id="phone" placeholder="Phone" name="phone">
            </div>
            <div class="popup-footer">

                <button class="action-btn" name="addSupplierButton" id="confirm-add-supplier">Confirm</button>
            </div>
        </form>
    </div>

    <script>
        function validateComponentForm() {
            const componentName = document.getElementById("componentName").value.trim();
            const quantity = document.getElementById("quantity").value.trim();
            const status = document.getElementById("status").value.trim();

            const errorBox = document.getElementById("error-box");

            errorBox.innerHTML = "";

            if (!componentName) {
                errorBox.innerHTML = "Component Name is required.";
                return false;
            }
            if (!status) {
                errorBox.innerHTML = "Status is required.";
                return false;
            }

            if (!quantity || quantity <= 0) {
                errorBox.innerHTML = "Quantity must be greater than 0.";
                return false;
            }

            return true;
        }
    </script>

<script src="./assets/js/expand.js"></script>
<script src="./assets/js/popupLast.js"></script>
</body>

</html>