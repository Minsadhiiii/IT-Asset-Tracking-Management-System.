<?php
include('./config/connection.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST['deleteMaintenanceButton'])) {
        $maintenanceID = $_POST['maintenanceID'] ?? '';

        if (!empty($maintenanceID)) {
            $stmt = $conn->prepare("DELETE FROM Maintenance WHERE maintenanceID = ?");
            $stmt->bind_param("i", $maintenanceID);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                header("Location: maintenance.php"); // Redirect to the maintenance list page
                exit;
            } else {
                echo "Error deleting maintenance record: " . $conn->error;
            }
        } else {
            echo "Invalid Maintenance ID.";
        }
    }

    if (isset($_POST['deleteAuditButton'])) {
        $auditID = $_POST['auditID'] ?? '';
    
        if (!empty($auditID)) {
            $stmt = $conn->prepare("DELETE FROM Audit WHERE auditID = ?");
            $stmt->bind_param("i", $auditID);
            $stmt->execute();
    
            if ($stmt->affected_rows > 0) {
                header("Location: audit.php"); // Redirect to the audit list page
                exit;
            } else {
                echo "Error deleting audit record: " . $conn->error;
            }
        } else {
            echo "Invalid Audit ID.";
        }
    }
    

    if (isset($_POST["deleteCategoryButton"])) {


        $categoryID = $_POST['categoryID'];
        $sql = "DELETE FROM category WHERE categoryID = $categoryID";

        if ($conn->query($sql) === TRUE) {
            header("Location: categories.php");
            exit;
        } else {
            header("Location: categories.php");
            exit;
        }
    }

    if (isset($_POST["deleteManufacturerButton"])) {


        $manufacturerID = $_POST['manufacturerID'];
        $sql = "DELETE FROM manufacturer WHERE manufacturerID = $manufacturerID";

        if ($conn->query($sql) === TRUE) {
            header("Location: manufacturers.php");
            exit;
        } else {
            header("Location: manufacturers.php");
            exit;
        }
    }

    if (isset($_POST["deleteSupplierButton"])) {
        $supplierID = $_POST['supplierID'];
        $sql = "DELETE FROM supplier WHERE supplierID = $supplierID";

        if ($conn->query($sql) === TRUE) {
            header("Location: suppliers.php");
            exit;
        } else {
            echo "Error deleting supplier: " . $conn->error;
        }
    }

    // Delete Office
    if (isset($_POST["deleteOfficeButton"])) {
        $officeID = $_POST['officeID'];
        $sql = "DELETE FROM office WHERE officeID = $officeID";

        if ($conn->query($sql) === TRUE) {
            header("Location: offices.php");
            exit;
        } else {
            echo "Error deleting office: " . $conn->error;
        }
    }

    if (isset($_POST["deleteAssetButton"])) {


        $itemID = $_POST['itemID'];
        $sql = "DELETE FROM item WHERE itemID = $itemID";

        if ($conn->query($sql) === TRUE) {
            header("Location: assets.php");
            exit;
        } else {
            header("Location: assets.php");
            exit;
        }
    }
    if (isset($_POST["deleteConsumableButton"])) {


        $itemID = $_POST['itemID'];
        $sql = "DELETE FROM item WHERE itemID = $itemID";

        if ($conn->query($sql) === TRUE) {
            header("Location: consumables.php");
            exit;
        } else {
            header("Location: consumables.php");
            exit;
        }
    }
    if (isset($_POST["deleteComponentButton"])) {


        $itemID = $_POST['itemID'];
        $sql = "DELETE FROM item WHERE itemID = $itemID";

        if ($conn->query($sql) === TRUE) {
            header("Location: components.php");
            exit;
        } else {
            header("Location: components.php");
            exit;
        }
    }
    if (isset($_POST["deleteAccessoryButton"])) {


        $itemID = $_POST['itemID'];
        $sql = "DELETE FROM item WHERE itemID = $itemID";

        if ($conn->query($sql) === TRUE) {
            header("Location: accessories.php");
            exit;
        } else {
            header("Location: accessories.php");
            exit;
        }
    }
    if (isset($_POST["deleteLicenseButton"])) {


        $itemID = $_POST['itemID'];
        $sql = "DELETE FROM item WHERE itemID = $itemID";

        if ($conn->query($sql) === TRUE) {
            header("Location: licenses.php");
            exit;
        } else {
            header("Location: licenses.php");
            exit;
        }
    }
    // Add Asset
    if (isset($_POST["addAssetButton"])) {
        $purchaseDate = $_POST['purchaseDate'] ?? '';
        $purchaseCost = $_POST['purchaseCost'] ?? '';
        $supplierID = $_POST['supplier'] ?? '';
        $warrantyStartDate = $_POST['warrantyStartDate'] ?? '';
        $warrantyEndDate = $_POST['warrantyEndDate'] ?? '';
        $assetName = $_POST['assetName'] ?? '';
        $assetTag = $_POST['assetTag'] ?? '';
        $serialNumber = $_POST['serialNumber'] ?? '';
        $modelName = $_POST['modelName'] ?? '';
        $categoryID = $_POST['category'] ?? '';
        $manufacturerID = $_POST['manufacturer'] ?? '';
        $statusID = $_POST['status'] ?? '';
        $officeID = $_POST['office'] ?? '';
        $notes = $_POST['notes'] ?? '';
        $image = $_FILES['image']['name'] ?? '';
        $orderID = '';
        $warrantyID = '';


        // Save image to the folder
        $imagePath = 'images/' . $image;
        if ($image) {
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        }

        $supplierID = !empty($_POST['supplier']) ? $_POST['supplier'] : 'NULL';

        // Insert into Order table if all order details are provided
        if (!empty($purchaseDate) && !empty($purchaseCost) && !empty($supplierID)) {
            $conn->query("INSERT INTO `order` (purchaseDate, purchaseCost, supplierID) VALUES ('$purchaseDate', '$purchaseCost', $supplierID)");
            $orderID = $conn->insert_id;
        } else {
            echo "Order details are incomplete.";
        }

        // Insert into Warranty table if all warranty details are provided
        if (!empty($warrantyStartDate) && !empty($warrantyEndDate)) {
            $conn->query("INSERT INTO warranty (startDate, endDate) VALUES ('$warrantyStartDate', '$warrantyEndDate')");
            $warrantyID = $conn->insert_id;
        } else {
            echo "Warranty details are incomplete.";
        }

        $categoryID = !empty($_POST['category']) ? $_POST['category'] : 'NULL';
        $manufacturerID = !empty($_POST['manufacturer']) ? $_POST['manufacturer'] : 'NULL';
        $officeID = !empty($_POST['office']) ? $_POST['office'] : 'NULL';
        $warrantyID = !empty($warrantyID) ? $warrantyID : 'NULL';
        $orderID = !empty($orderID) ? $orderID : 'NULL';



        // Insert into Item table
        $conn->query("INSERT INTO item (`name`, `image`, notes, categoryID, manufacturerID, orderID, statusID, officeID)
                      VALUES ('$assetName', '$image', '$notes', $categoryID, $manufacturerID, $orderID, $statusID, $officeID)");
        $itemID = $conn->insert_id;

        // Insert into Asset table
        $conn->query("INSERT INTO asset (assetTag, `serial`, modelName, itemID, warrantyID)
                      VALUES ('$assetTag', '$serialNumber', '$modelName', $itemID, $warrantyID)");

        if ($conn->affected_rows > 0) {
            header("Location: assets.php");
            exit;
        } else {
            echo "Error adding asset: " . $conn->error;
        }
    }

    // Update Asset
    if (isset($_POST["updateAssetButton"])) {
        $assetID = $_POST['assetID'] ?? '';
        $purchaseDate = $_POST['purchaseDate'] ?? '';
        $purchaseCost = $_POST['purchaseCost'] ?? '';
        $supplierID = $_POST['supplier'] ?? '';
        $warrantyStartDate = $_POST['warrantyStartDate'] ?? '';
        $warrantyEndDate = $_POST['warrantyEndDate'] ?? '';
        $assetName = $_POST['assetName'] ?? '';
        $assetTag = $_POST['assetTag'] ?? '';
        $serialNumber = $_POST['serialNumber'] ?? '';
        $modelName = $_POST['modelName'] ?? '';

        $categoryID = $_POST['category'] ?? '';
        $manufacturerID = $_POST['manufacturer'] ?? '';
        $statusID = $_POST['status'] ?? '';
        $officeID = $_POST['office'] ?? '';
        $notes = $_POST['notes'] ?? '';
        $image = $_FILES['image']['name'] ?? '';
        $orderID = '';
        $warrantyID = '';

        // Check if a new image was uploaded
        if (!empty($image)) {
            // Save new image to the folder
            $imagePath = 'images/' . $image;
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        } else {
            // Fetch current image from the database
            $result = $conn->query("SELECT i.image FROM item i INNER JOIN asset a ON i.itemID = a.itemID WHERE a.assetID = $assetID");
            if ($result && $row = $result->fetch_assoc()) {
                $image = $row['image']; // Keep the existing image
            }
        }

        $supplierID = !empty($_POST['supplier']) ? $_POST['supplier'] : 'NULL';

        // Update Order table if order details are provided
        if (!empty($purchaseDate) && !empty($purchaseCost) && !empty($supplierID)) {
            $conn->query("UPDATE `order` o
                          INNER JOIN item i ON i.orderID = o.orderID
                          INNER JOIN asset a ON a.itemID = i.itemID
                          SET o.purchaseDate = '$purchaseDate', o.purchaseCost = '$purchaseCost', o.supplierID = $supplierID
                          WHERE a.assetID = $assetID");
        }

        // Update Warranty table if warranty details are provided
        if (!empty($warrantyStartDate) && !empty($warrantyEndDate)) {
            $conn->query("UPDATE warranty w
                          INNER JOIN asset a ON a.warrantyID = w.warrantyID
                          SET w.startDate = '$warrantyStartDate', w.endDate = '$warrantyEndDate'
                          WHERE a.assetID = $assetID");
        }

        $categoryID = !empty($_POST['category']) ? $_POST['category'] : 'NULL';
        $manufacturerID = !empty($_POST['manufacturer']) ? $_POST['manufacturer'] : 'NULL';
        $officeID = !empty($_POST['office']) ? $_POST['office'] : 'NULL';
        $warrantyID = !empty($warrantyID) ? $warrantyID : 'NULL';
        $orderID = !empty($orderID) ? $orderID : 'NULL';

        // Update Item table
        $conn->query("UPDATE item i
                      INNER JOIN asset a ON a.itemID = i.itemID
                      SET i.name = '$assetName', i.image = '$image', i.notes = '$notes', i.categoryID = $categoryID,
                          i.manufacturerID = $manufacturerID, i.statusID = $statusID, i.officeID = $officeID
                      WHERE a.assetID = $assetID");

        // Update Asset table
        $conn->query("UPDATE asset SET assetTag = '$assetTag', `serial` = '$serialNumber', modelName = '$modelName' WHERE assetID = $assetID");

        header("Location: assets.php");
        exit;
    }



    // Add License
    if (isset($_POST["addLicenseButton"])) {
        $purchaseDate = $_POST['purchaseDate'] ?? '';
        $purchaseCost = $_POST['purchaseCost'] ?? '';
        $supplierID = !empty($_POST['supplier']) ? $_POST['supplier'] : 'NULL';
        $licenseName = $_POST['licenseName'] ?? '';
        $notes = $_POST['notes'] ?? '';

        $statusID = $_POST['status'] ?? '';

        $categoryID = !empty($_POST['category']) ? $_POST['category'] : 'NULL';
        $manufacturerID = !empty($_POST['manufacturer']) ? $_POST['manufacturer'] : 'NULL';
        $officeID = !empty($_POST['office']) ? $_POST['office'] : 'NULL';

        $productKey = $_POST['productKey'] ?? '';
        $seats = $_POST['seats'] ?? '';
        $available = $_POST['available'] ?? '';

        $licensedToName = $_POST['licensedToName'] ?? '';
        $licensedToEmail = $_POST['licensedToEmail'] ?? '';
        $expDate = $_POST['expDate'] ?? '';
        $image = $_FILES['image']['name'] ?? '';
        $orderID = '';


        // Save image to folder
        $imagePath = 'images/' . $image;
        if ($image) {
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        }



        if (!empty($purchaseDate) && !empty($purchaseCost) && !empty($supplierID)) {
            // Insert into Order table
            $conn->query("INSERT INTO `order` (purchaseDate, purchaseCost, supplierID) VALUES ('$purchaseDate', '$purchaseCost', $supplierID)");
            $orderID = $conn->insert_id;
        }

        $orderID = !empty($orderID) ? $orderID : 'NULL';

        // Insert into Item table
        $conn->query("INSERT INTO item (`name`, `image`, notes, categoryID, manufacturerID, orderID, statusID, officeID)
                  VALUES ('$licenseName', '$image', '$notes', $categoryID, $manufacturerID, $orderID, $statusID, $officeID)");
        $itemID = $conn->insert_id;

        // Insert into License table
        $conn->query("INSERT INTO license (productKey,available, seats, licensedToName, licensedToEmail, expDate, itemID)
                  VALUES ('$productKey', $available, $seats, '$licensedToName', '$licensedToEmail', '$expDate', $itemID)");

        if ($conn->affected_rows > 0) {
            header("Location: licenses.php");
            exit;
        } else {
            echo "Error adding license: " . $conn->error;
        }
    }

    // Update License
    if (isset($_POST["updateLicenseButton"])) {
        $licenseID = $_POST['licenseID'] ?? '';
        $purchaseDate = $_POST['purchaseDate'] ?? '';
        $purchaseCost = $_POST['purchaseCost'] ?? '';
        $supplierID = !empty($_POST['supplier']) ? $_POST['supplier'] : 'NULL';
        $licenseName = $_POST['licenseName'] ?? '';
        $notes = $_POST['notes'] ?? '';
        $categoryID = !empty($_POST['category']) ? $_POST['category'] : 'NULL';
        $manufacturerID = !empty($_POST['manufacturer']) ? $_POST['manufacturer'] : 'NULL';
        $officeID = !empty($_POST['office']) ? $_POST['office'] : 'NULL';

        $statusID = $_POST['status'] ?? 'NULL';
        $productKey = $_POST['productKey'] ?? '';
        $seats = $_POST['seats'] ?? '';
        $available = $_POST['available'] ?? '';

        $licensedToName = $_POST['licensedToName'] ?? '';
        $licensedToEmail = $_POST['licensedToEmail'] ?? '';
        $expDate = $_POST['expDate'] ?? '';
        $image = $_FILES['image']['name'] ?? '';
        $orderID = '';

        // Check if a new image was uploaded
        if (!empty($image)) {
            // Save new image to folder
            $imagePath = 'images/' . $image;
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        } else {
            // Fetch current image from the database
            $result = $conn->query("SELECT i.image FROM item i 
                                INNER JOIN license l ON i.itemID = l.itemID 
                                WHERE l.licenseID = $licenseID");
            if ($result && $row = $result->fetch_assoc()) {
                $image = $row['image']; // Keep existing image
            }
        }

        if (!empty($purchaseDate) && !empty($purchaseCost) && !empty($supplierID)) {
            // Update Order table
            $conn->query("UPDATE `order` o
                  INNER JOIN item i ON i.orderID = o.orderID
                  INNER JOIN license l ON l.itemID = i.itemID
                  SET o.purchaseDate = '$purchaseDate', o.purchaseCost = '$purchaseCost', o.supplierID = $supplierID
                  WHERE l.licenseID = $licenseID");
        }

        $orderID = !empty($orderID) ? $orderID : 'NULL';
        // Update Item table
        $conn->query("UPDATE item i
                  INNER JOIN license l ON l.itemID = i.itemID
                  SET i.name = '$licenseName', i.image = '$image', i.notes = '$notes', 
                      i.categoryID = $categoryID, i.manufacturerID = $manufacturerID, 
                      i.statusID = $statusID, i.officeID = $officeID
                  WHERE l.licenseID = $licenseID");

        // Update License table
        $conn->query("UPDATE license SET productKey = '$productKey', seats = $seats, available = $available, 
                  licensedToName = '$licensedToName', licensedToEmail = '$licensedToEmail', 
                  expDate = '$expDate' WHERE licenseID = $licenseID");

        if ($conn->affected_rows > 0) {
            header("Location: licenses.php");
            exit;
        } else {
            header("Location: licenses.php");
            exit;
        }
    }


    if (isset($_POST["addAccessoryButton"])) {
        $purchaseDate = $_POST['purchaseDate'] ?? '';
        $purchaseCost = $_POST['purchaseCost'] ?? '';
        $supplierID = !empty($_POST['supplier']) ? $_POST['supplier'] : 'NULL';
        $warrantyStartDate = $_POST['warrantyStartDate'] ?? '';
        $warrantyEndDate = $_POST['warrantyEndDate'] ?? '';
        $accessoryName = $_POST['accessoryName'] ?? '';
        $image = $_FILES['image']['name'] ?? '';
        $notes = $_POST['notes'] ?? '';
        $modelNo = $_POST['modelNo'] ?? '';
        $quantity = $_POST['quantity'] ?? '';
        $categoryID = !empty($_POST['category']) ? $_POST['category'] : 'NULL';
        $manufacturerID = !empty($_POST['manufacturer']) ? $_POST['manufacturer'] : 'NULL';
        $officeID = !empty($_POST['office']) ? $_POST['office'] : 'NULL';
        $statusID = $_POST['status'] ?? '';

        $orderID = '';
        $warrantyID = '';


        // Save image to the folder
        $imagePath = 'images/' . $image;
        if ($image) {
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        }


        // Insert into Order table if all order details are provided
        if (!empty($purchaseDate) && !empty($purchaseCost) && !empty($supplierID)) {
            $conn->query("INSERT INTO `order` (purchaseDate, purchaseCost, supplierID) VALUES ('$purchaseDate', '$purchaseCost', $supplierID)");
            $orderID = $conn->insert_id;
        } else {
            echo "Order details are incomplete.";
        }

        // Insert into Warranty table if all warranty details are provided
        if (!empty($warrantyStartDate) && !empty($warrantyEndDate)) {
            $conn->query("INSERT INTO warranty (startDate, endDate) VALUES ('$warrantyStartDate', '$warrantyEndDate')");
            $warrantyID = $conn->insert_id;
        } else {
            echo "Warranty details are incomplete.";
        }


        $warrantyID = !empty($warrantyID) ? $warrantyID : 'NULL';
        $orderID = !empty($orderID) ? $orderID : 'NULL';


        // Insert into Item table
        $conn->query("INSERT INTO item (`name`, `image`, notes, categoryID, manufacturerID, orderID, statusID, officeID)
                      VALUES ('$accessoryName', '$image', '$notes', $categoryID, $manufacturerID, $orderID, $statusID, $officeID)");
        $itemID = $conn->insert_id;

        // Insert into Asset table
        $conn->query("INSERT INTO accessory (modelNo, quantity, remaining, itemID, warrantyID)
                      VALUES ('$modelNo', '$quantity', '$quantity', $itemID, $warrantyID)");

        if ($conn->affected_rows > 0) {
            header("Location: accessories.php");
            exit;
        } else {
            echo "Error adding asset: " . $conn->error;
        }
    }




    if (isset($_POST["updateAccessoryButton"])) {
        $accessoryID = $_POST['accessoryID'] ?? '';
        $purchaseDate = $_POST['purchaseDate'] ?? '';
        $purchaseCost = $_POST['purchaseCost'] ?? '';
        $supplierID = !empty($_POST['supplier']) ? $_POST['supplier'] : 'NULL';
        $warrantyStartDate = $_POST['warrantyStartDate'] ?? '';
        $warrantyEndDate = $_POST['warrantyEndDate'] ?? '';
        $accessoryName = $_POST['accessoryName'] ?? '';
        $image = $_FILES['image']['name'] ?? '';
        $notes = $_POST['notes'] ?? '';
        $modelNo = $_POST['modelNo'] ?? '';
        $quantity = $_POST['quantity'] ?? '';
        $categoryID = !empty($_POST['category']) ? $_POST['category'] : 'NULL';
        $manufacturerID = !empty($_POST['manufacturer']) ? $_POST['manufacturer'] : 'NULL';
        $officeID = !empty($_POST['office']) ? $_POST['office'] : 'NULL';
        $statusID = $_POST['status'] ?? '';

        $orderID = '';
        $warrantyID = '';
        // Check if a new image was uploaded
        if (!empty($image)) {
            // Save new image to the folder
            $imagePath = 'images/' . $image;
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        } else {
            // Fetch current image from the database
            $result = $conn->query("SELECT i.image FROM item i INNER JOIN accessory a ON i.itemID = a.itemID WHERE a.accessoryID = $accessoryID");
            if ($result && $row = $result->fetch_assoc()) {
                $image = $row['image']; // Keep the existing image
            }
        }



        // Update Order table if order details are provided
        if (!empty($purchaseDate) && !empty($purchaseCost) && !empty($supplierID)) {
            $conn->query("UPDATE `order` o
                          INNER JOIN item i ON i.orderID = o.orderID
                          INNER JOIN accessory a ON a.itemID = i.itemID
                          SET o.purchaseDate = '$purchaseDate', o.purchaseCost = '$purchaseCost', o.supplierID = $supplierID
                          WHERE a.accessoryID = $accessoryID");
        }

        // Update Warranty table if warranty details are provided
        if (!empty($warrantyStartDate) && !empty($warrantyEndDate)) {
            $conn->query("UPDATE warranty w
                          INNER JOIN accessory a ON a.warrantyID = w.warrantyID
                          SET w.startDate = '$warrantyStartDate', w.endDate = '$warrantyEndDate'
                          WHERE a.accessoryID = $accessoryID");
        }


        $warrantyID = !empty($warrantyID) ? $warrantyID : 'NULL';
        $orderID = !empty($orderID) ? $orderID : 'NULL';

        // Update Item table
        $conn->query("UPDATE item i
                      INNER JOIN accessory a ON a.itemID = i.itemID
                      SET i.name = '$accessoryName', i.image = '$image', i.notes = '$notes', i.categoryID = $categoryID,
                          i.manufacturerID = $manufacturerID, i.statusID = $statusID, i.officeID = $officeID
                      WHERE a.accessoryID = $accessoryID");

        // Update Asset table
        $conn->query("UPDATE accessory SET modelNo = '$modelNo', quantity = $quantity WHERE accessoryID = $accessoryID");

        header("Location: accessories.php");
        exit;
    }

    if (isset($_POST["addComponentButton"])) {
        $purchaseDate = $_POST['purchaseDate'] ?? '';
        $purchaseCost = $_POST['purchaseCost'] ?? '';
        $supplierID = !empty($_POST['supplier']) ? $_POST['supplier'] : 'NULL';
        $warrantyStartDate = $_POST['warrantyStartDate'] ?? '';
        $warrantyEndDate = $_POST['warrantyEndDate'] ?? '';
        $componentName = $_POST['componentName'] ?? '';
        $image = $_FILES['image']['name'] ?? '';
        $notes = $_POST['notes'] ?? '';
        $modelNo = $_POST['modelNo'] ?? '';
        $serial = $_POST['serial'] ?? '';
        $quantity = $_POST['quantity'] ?? '';
        $categoryID = !empty($_POST['category']) ? $_POST['category'] : 'NULL';
        $manufacturerID = !empty($_POST['manufacturer']) ? $_POST['manufacturer'] : 'NULL';
        $officeID = !empty($_POST['office']) ? $_POST['office'] : 'NULL';
        $statusID = $_POST['status'] ?? '';

        $orderID = '';
        $warrantyID = '';


        // Save image to the folder
        $imagePath = 'images/' . $image;
        if ($image) {
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        }


        // Insert into Order table if all order details are provided
        if (!empty($purchaseDate) && !empty($purchaseCost) && !empty($supplierID)) {
            $conn->query("INSERT INTO `order` (purchaseDate, purchaseCost, supplierID) VALUES ('$purchaseDate', '$purchaseCost', $supplierID)");
            $orderID = $conn->insert_id;
        } else {
            echo "Order details are incomplete.";
        }

        // Insert into Warranty table if all warranty details are provided
        if (!empty($warrantyStartDate) && !empty($warrantyEndDate)) {
            $conn->query("INSERT INTO warranty (startDate, endDate) VALUES ('$warrantyStartDate', '$warrantyEndDate')");
            $warrantyID = $conn->insert_id;
        } else {
            echo "Warranty details are incomplete.";
        }


        $warrantyID = !empty($warrantyID) ? $warrantyID : 'NULL';
        $orderID = !empty($orderID) ? $orderID : 'NULL';


        // Insert into Item table
        $conn->query("INSERT INTO item (`name`, `image`, notes, categoryID, manufacturerID, orderID, statusID, officeID)
                      VALUES ('$componentName', '$image', '$notes', $categoryID, $manufacturerID, $orderID, $statusID, $officeID)");
        $itemID = $conn->insert_id;

        // Insert into Asset table
        $conn->query("INSERT INTO component (`serial`,modelNo, quantity, remaining, itemID, warrantyID)
                      VALUES ('$serial', '$modelNo', '$quantity','$quantity', $itemID, $warrantyID)");

        if ($conn->affected_rows > 0) {
            header("Location: components.php");
            exit;
        } else {
            echo "Error adding component: " . $conn->error;
        }
    }

    if (isset($_POST["updateComponentButton"])) {
        $componentID = $_POST['componentID'] ?? '';
        $purchaseDate = $_POST['purchaseDate'] ?? '';
        $purchaseCost = $_POST['purchaseCost'] ?? '';
        $supplierID = !empty($_POST['supplier']) ? $_POST['supplier'] : 'NULL';
        $warrantyStartDate = $_POST['warrantyStartDate'] ?? '';
        $warrantyEndDate = $_POST['warrantyEndDate'] ?? '';
        $componentName = $_POST['componentName'] ?? '';
        $image = $_FILES['image']['name'] ?? '';
        $serial = $_POST['serial'] ?? '';
        $notes = $_POST['notes'] ?? '';
        $modelNo = $_POST['modelNo'] ?? '';
        $quantity = $_POST['quantity'] ?? '';
        $categoryID = !empty($_POST['category']) ? $_POST['category'] : 'NULL';
        $manufacturerID = !empty($_POST['manufacturer']) ? $_POST['manufacturer'] : 'NULL';
        $officeID = !empty($_POST['office']) ? $_POST['office'] : 'NULL';
        $statusID = $_POST['status'] ?? '';

        $orderID = '';
        $warrantyID = '';
        // Check if a new image was uploaded
        if (!empty($image)) {
            // Save new image to the folder
            $imagePath = 'images/' . $image;
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        } else {
            // Fetch current image from the database
            $result = $conn->query("SELECT i.image FROM item i INNER JOIN component c ON i.itemID = c.itemID WHERE c.componentID = $componentID");
            if ($result && $row = $result->fetch_assoc()) {
                $image = $row['image']; // Keep the existing image
            }
        }


        // Update Order table if order details are provided
        if (!empty($purchaseDate) && !empty($purchaseCost) && !empty($supplierID)) {
            $conn->query("UPDATE `order` o
                          INNER JOIN item i ON i.orderID = o.orderID
                          INNER JOIN component c ON c.itemID = i.itemID
                          SET o.purchaseDate = '$purchaseDate', o.purchaseCost = '$purchaseCost', o.supplierID = $supplierID
                          WHERE c.componentID = $componentID");
        }

        // Update Warranty table if warranty details are provided
        if (!empty($warrantyStartDate) && !empty($warrantyEndDate)) {
            $conn->query("UPDATE warranty w
                          INNER JOIN component c ON c.warrantyID = w.warrantyID
                          SET w.startDate = '$warrantyStartDate', w.endDate = '$warrantyEndDate'
                          WHERE c.componentID = $componentID");
        }


        $warrantyID = !empty($warrantyID) ? $warrantyID : 'NULL';
        $orderID = !empty($orderID) ? $orderID : 'NULL';

        // Update Item table
        $conn->query("UPDATE item i
                      INNER JOIN component c ON c.itemID = i.itemID
                      SET i.name = '$componentName', i.image = '$image', i.notes = '$notes', i.categoryID = $categoryID,
                          i.manufacturerID = $manufacturerID, i.statusID = $statusID, i.officeID = $officeID
                      WHERE c.componentID = $componentID");

        // Update Asset table
        $conn->query("UPDATE component SET modelNo = '$modelNo',`serial` = '$serial', quantity = $quantity WHERE componentID = $componentID");

        header("Location: components.php");
        exit;
    }

    if (isset($_POST["addConsumableButton"])) {
        $purchaseDate = $_POST['purchaseDate'] ?? '';
        $purchaseCost = $_POST['purchaseCost'] ?? '';
        $supplierID = !empty($_POST['supplier']) ? $_POST['supplier'] : 'NULL';

        $consumableName = $_POST['consumableName'] ?? '';
        $image = $_FILES['image']['name'] ?? '';
        $notes = $_POST['notes'] ?? '';
        $modelNo = $_POST['modelNo'] ?? '';

        $quantity = $_POST['quantity'] ?? '';
        $categoryID = !empty($_POST['category']) ? $_POST['category'] : 'NULL';
        $manufacturerID = !empty($_POST['manufacturer']) ? $_POST['manufacturer'] : 'NULL';
        $officeID = !empty($_POST['office']) ? $_POST['office'] : 'NULL';
        $statusID = $_POST['status'] ?? '';

        $orderID = '';
        $warrantyID = '';


        // Save image to the folder
        $imagePath = 'images/' . $image;
        if ($image) {
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        }


        // Insert into Order table if all order details are provided
        if (!empty($purchaseDate) && !empty($purchaseCost) && !empty($supplierID)) {
            $conn->query("INSERT INTO `order` (purchaseDate, purchaseCost, supplierID) VALUES ('$purchaseDate', '$purchaseCost', $supplierID)");
            $orderID = $conn->insert_id;
        } else {
            echo "Order details are incomplete.";
        }





        $orderID = !empty($orderID) ? $orderID : 'NULL';


        // Insert into Item table
        $conn->query("INSERT INTO item (`name`, `image`, notes, categoryID, manufacturerID, orderID, statusID, officeID)
                      VALUES ('$consumableName', '$image', '$notes', $categoryID, $manufacturerID, $orderID, $statusID, $officeID)");
        $itemID = $conn->insert_id;

        // Insert into Asset table
        $conn->query("INSERT INTO consumable (modelNo, quantity, remaining, itemID)
                      VALUES ('$modelNo', '$quantity','$quantity', $itemID)");

        if ($conn->affected_rows > 0) {
            header("Location: consumables.php");
            exit;
        } else {
            echo "Error adding consumable " . $conn->error;
        }
    }


    if (isset($_POST["updateConsumableButton"])) {
        $consumableID = $_POST['consumableID'] ?? '';
        $purchaseDate = $_POST['purchaseDate'] ?? '';
        $purchaseCost = $_POST['purchaseCost'] ?? '';
        $supplierID = !empty($_POST['supplier']) ? $_POST['supplier'] : 'NULL';
        $consumableName = $_POST['consumableName'] ?? '';
        $image = $_FILES['image']['name'] ?? '';
        $notes = $_POST['notes'] ?? '';
        $modelNo = $_POST['modelNo'] ?? '';
        $quantity = $_POST['quantity'] ?? '';
        $categoryID = !empty($_POST['category']) ? $_POST['category'] : 'NULL';
        $manufacturerID = !empty($_POST['manufacturer']) ? $_POST['manufacturer'] : 'NULL';
        $officeID = !empty($_POST['office']) ? $_POST['office'] : 'NULL';
        $statusID = $_POST['status'] ?? '';

        $orderID = '';
        $warrantyID = '';
        // Check if a new image was uploaded
        if (!empty($image)) {
            // Save new image to the folder
            $imagePath = 'images/' . $image;
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        } else {
            // Fetch current image from the database
            $result = $conn->query("SELECT i.image FROM item i INNER JOIN consumable c ON i.itemID = c.itemID WHERE c.consumableID = $consumableID");
            if ($result && $row = $result->fetch_assoc()) {
                $image = $row['image']; // Keep the existing image
            }
        }


        // Update Order table if order details are provided
        if (!empty($purchaseDate) && !empty($purchaseCost) && !empty($supplierID)) {
            $conn->query("UPDATE `order` o
                          INNER JOIN item i ON i.orderID = o.orderID
                          INNER JOIN consumable c ON c.itemID = i.itemID
                          SET o.purchaseDate = '$purchaseDate', o.purchaseCost = '$purchaseCost', o.supplierID = $supplierID
                          WHERE c.consumableID = $consumableID");
        }



        $orderID = !empty($orderID) ? $orderID : 'NULL';

        // Update Item table
        $conn->query("UPDATE item i
                      INNER JOIN consumable c ON c.itemID = i.itemID
                      SET i.name = '$consumableName', i.image = '$image', i.notes = '$notes', i.categoryID = $categoryID,
                          i.manufacturerID = $manufacturerID, i.statusID = $statusID, i.officeID = $officeID
                      WHERE c.consumableID = $consumableID");

        // Update Asset table
        $conn->query("UPDATE consumable SET modelNo = '$modelNo', quantity = $quantity WHERE consumableID = $consumableID");

        header("Location: consumables.php");
        exit;
    }


    if (isset($_POST["addCheckoutButton"])) {
        // Include database connection


        // Retrieve and sanitize inputs
        $itemID = $conn->real_escape_string($_POST['itemID'] ?? '');
        $assignmentDate = $conn->real_escape_string($_POST['assignmentDate'] ?? '');
        $userID = !empty($_POST['user']) ? $conn->real_escape_string($_POST['user']) : 'NULL';
        $expCheckinDate = $conn->real_escape_string($_POST['expCheckinDate'] ?? '');
        $checkoutNotes = $conn->real_escape_string($_POST['checkoutNotes'] ?? '');
        $officeID = !empty($_POST['office']) ? $conn->real_escape_string($_POST['office']) : 'NULL';

        // Step 1: Get the status ID for "Deployed"
        $statusQuery = "SELECT statusID FROM status WHERE `type` = 'Deployed'";
        $statusResult = $conn->query($statusQuery);

        if ($statusResult && $statusResult->num_rows > 0) {
            $statusRow = $statusResult->fetch_assoc();
            $statusID = $statusRow['statusID'];

            // Step 2: Update the statusID of the relevant item in the `item` table
            $updateItemQuery = "UPDATE item SET statusID = $statusID WHERE itemID = $itemID";
            if ($conn->query($updateItemQuery)) {
                // Step 3: Insert into the `assetassignment` table
                $insertAssignmentQuery = "
                    INSERT INTO assetassignment (assignmentDate, itemID, userID, expCheckinDate, officeID, checkoutNotes)
                    VALUES ('$assignmentDate', $itemID, $userID, '$expCheckinDate', $officeID, '$checkoutNotes')
                ";
                if ($conn->query($insertAssignmentQuery)) {
                    // Redirect on success
                    header("Location: assets.php");
                    exit;
                } else {
                    echo "Error adding asset assignment: " . $conn->error;
                }
            } else {
                echo "Error updating item status: " . $conn->error;
            }
        } else {
            echo "Error retrieving 'Deployed' status: " . $conn->error;
        }
    }

    if (isset($_POST["addCheckinButton"])) {
        // Include database connection
        include('connection.php');

        // Retrieve and sanitize inputs
        $itemID = $conn->real_escape_string($_POST['itemID'] ?? '');
        $returnDate = $conn->real_escape_string($_POST['returnDate'] ?? '');
        $checkinNotes = $conn->real_escape_string($_POST['checkinNotes'] ?? '');
        $officeID = !empty($_POST['office']) ? $conn->real_escape_string($_POST['office']) : 'NULL';

        // Step 1: Get the status ID for "Ready to Deploy"
        $statusQuery = "SELECT statusID FROM status WHERE `type` = 'Ready to Deploy'";
        $statusResult = $conn->query($statusQuery);

        if ($statusResult && $statusResult->num_rows > 0) {
            $statusRow = $statusResult->fetch_assoc();
            $statusID = $statusRow['statusID'];

            // Step 2: Update the item's statusID and officeID in the `item` table
            $updateItemQuery = "UPDATE item SET statusID = $statusID, officeID = $officeID WHERE itemID = $itemID";
            if ($conn->query($updateItemQuery)) {

                // Step 3: Find the active assignment for the given item
                $assignmentQuery = "SELECT * FROM assetassignment WHERE itemID = $itemID AND status = 'Active'";
                $assignmentResult = $conn->query($assignmentQuery);

                if ($assignmentResult && $assignmentResult->num_rows > 0) {
                    $assignmentRow = $assignmentResult->fetch_assoc();
                    $assignmentID = $assignmentRow['assignmentID'];

                    // Step 4: Update the assignment with check-in details
                    $updateAssignmentQuery = "
                        UPDATE assetassignment 
                        SET returnDate = '$returnDate',
                            officeID = $officeID,
                            checkinNotes = '$checkinNotes',
                            status = 'Completed'
                        WHERE assignmentID = $assignmentID
                    ";
                    if ($conn->query($updateAssignmentQuery)) {
                        // Redirect on success
                        header("Location: assets.php");
                        exit;
                    } else {
                        echo "Error updating assignment: " . $conn->error;
                    }
                } else {
                    echo "No active assignment found for this item.";
                }
            } else {
                echo "Error updating item status: " . $conn->error;
            }
        } else {
            echo "Error retrieving 'Ready to Deploy' status: " . $conn->error;
        }
    }

    if (isset($_POST["addLicenseCheckoutButton"])) {

        $itemID = $conn->real_escape_string($_POST['itemID'] ?? '');
        $licenseID = $conn->real_escape_string($_POST['licenseID'] ?? '');
        $assignmentDate = $conn->real_escape_string($_POST['assignmentDate'] ?? '');
        $userID = !empty($_POST['user']) ? $conn->real_escape_string($_POST['user']) : 'NULL';
        $available = $conn->real_escape_string($_POST['available'] ?? '');
        $checkoutNotes = $conn->real_escape_string($_POST['checkoutNotes'] ?? '');


        if ($available > 0) {
            // Step 2: Reduce the available count by 1 and update the license table
            $newAvailable = $available - 1;
            $conn->query("UPDATE license SET available = '$newAvailable' WHERE licenseID = $licenseID");

            // Step 3: Insert into the `assetassignment` table
            $insertAssignmentQuery = "INSERT INTO assetassignment (assignmentDate, itemID, userID, checkoutNotes, `status`)
                    VALUES ('$assignmentDate', $itemID, $userID, '$checkoutNotes', 'Completed')";

            if ($conn->query($insertAssignmentQuery)) {
                // Redirect on success
                header("Location: licenses.php");
                exit;
            } else {
                echo "Error adding asset assignment: " . $conn->error;
            }
        } else {
            echo $available;
        }
    }

    if (isset($_POST["addAccessoryCheckoutButton"])) {
        // Retrieve and sanitize inputs
        $accessoryID = $conn->real_escape_string($_POST['accessoryID'] ?? '');
        $itemID = $conn->real_escape_string($_POST['itemID'] ?? '');
        $assignmentDate = $conn->real_escape_string($_POST['assignmentDate'] ?? '');
        $userID = !empty($_POST['user']) ? $conn->real_escape_string($_POST['user']) : 'NULL';
        $quantityTaken = intval($_POST['quantity'] ?? 0);
        $checkoutNotes = $conn->real_escape_string($_POST['checkoutNotes'] ?? '');

        // Fetch current remaining and total quantity for the accessory
        $result = $conn->query("SELECT quantity, remaining FROM accessory WHERE accessoryID = $accessoryID");
        if ($result && $result->num_rows > 0) {
            $accessory = $result->fetch_assoc();
            $currentRemaining = intval($accessory['remaining']);
            $currentTotalQuantity = intval($accessory['quantity']);

            // Check if the requested quantity is available
            if ($quantityTaken > 0 && $quantityTaken <= $currentRemaining) {
                // Update remaining quantity
                $newRemaining = $currentRemaining - $quantityTaken;


                $updateQuery = "UPDATE accessory 
                                SET remaining = $newRemaining 
                                WHERE accessoryID = $accessoryID";

                if ($conn->query($updateQuery)) {
                    // Insert into the `assetassignment` table
                    $insertAssignmentQuery = "INSERT INTO assetassignment (assignmentDate, itemID, userID, checkoutNotes, quantity, `status`)
                                              VALUES ('$assignmentDate', $itemID, $userID, '$checkoutNotes', $quantityTaken, 'Completed')";

                    if ($conn->query($insertAssignmentQuery)) {
                        // Redirect on success
                        header("Location: accessories.php");
                        exit;
                    } else {
                        echo "Error adding asset assignment: " . $conn->error;
                    }
                } else {
                    echo "Error updating accessory quantities: " . $conn->error;
                }
            } else {
                echo "Invalid quantity requested. Available quantity: $currentRemaining.";
            }
        } else {
            echo "Accessory not found.";
        }
    }


    if (isset($_POST["addComponentCheckoutButton"])) {
        // Retrieve and sanitize inputs
        $componentID = $conn->real_escape_string($_POST['componentID'] ?? '');
        $itemID = $conn->real_escape_string($_POST['itemID'] ?? '');
        $assignmentDate = $conn->real_escape_string($_POST['assignmentDate'] ?? '');
        $userID = !empty($_POST['user']) ? $conn->real_escape_string($_POST['user']) : 'NULL';
        $quantityTaken = intval($_POST['quantity'] ?? 0);
        $checkoutNotes = $conn->real_escape_string($_POST['checkoutNotes'] ?? '');

        // Fetch current remaining and total quantity for the component
        $result = $conn->query("SELECT quantity, remaining FROM component WHERE componentID = $componentID");
        if ($result && $result->num_rows > 0) {
            $component = $result->fetch_assoc();
            $currentTotalQuantity = intval($component['quantity']);
            $currentRemaining = intval($component['remaining']);

            // Check if the requested quantity is valid and available
            if ($quantityTaken > 0 && $quantityTaken <= $currentRemaining) {
                // Calculate new total quantity and remaining
                $newTotalQuantity = $currentTotalQuantity - $quantityTaken;
                $newRemaining = $currentRemaining - $quantityTaken;

                // Update total and remaining quantities in the component table
                $updateQuery = "UPDATE component 
                                SET remaining = $newRemaining 
                                WHERE componentID = $componentID";

                if ($conn->query($updateQuery)) {
                    // Insert into the `assetassignment` table
                    $insertAssignmentQuery = "INSERT INTO assetassignment (assignmentDate, itemID, userID, checkoutNotes, quantity, `status`)
                                              VALUES ('$assignmentDate', $itemID, $userID, '$checkoutNotes', $quantityTaken, 'Completed')";

                    if ($conn->query($insertAssignmentQuery)) {
                        // Redirect on success
                        header("Location: components.php");
                        exit;
                    } else {
                        echo "Error adding asset assignment: " . $conn->error;
                    }
                } else {
                    echo "Error updating component quantities: " . $conn->error;
                }
            } else {
                echo "Invalid quantity requested. Available quantity: $currentRemaining.";
            }
        } else {
            echo "Component not found.";
        }
    }


    if (isset($_POST["addConsumableCheckoutButton"])) {
        // Retrieve and sanitize inputs
        $consumableID = $conn->real_escape_string($_POST['consumableID'] ?? '');
        $itemID = $conn->real_escape_string($_POST['itemID'] ?? '');
        $assignmentDate = $conn->real_escape_string($_POST['assignmentDate'] ?? '');
        $userID = !empty($_POST['user']) ? $conn->real_escape_string($_POST['user']) : 'NULL';
        $quantityTaken = intval($_POST['quantity'] ?? 0);
        $checkoutNotes = $conn->real_escape_string($_POST['checkoutNotes'] ?? '');

        // Fetch current remaining and total quantity for the consumable
        $result = $conn->query("SELECT quantity, remaining FROM consumable WHERE consumableID = $consumableID");
        if ($result && $result->num_rows > 0) {
            $consumable = $result->fetch_assoc();
            $currentTotalQuantity = intval($consumable['quantity']);
            $currentRemaining = intval($consumable['remaining']);

            // Check if the requested quantity is valid and available
            if ($quantityTaken > 0 && $quantityTaken <= $currentRemaining) {
                // Calculate new total quantity and remaining
                $newTotalQuantity = $currentTotalQuantity - $quantityTaken;
                $newRemaining = $currentRemaining - $quantityTaken;

                // Update total and remaining quantities in the consumable table
                $updateQuery = "UPDATE consumable 
                                SET remaining = $newRemaining 
                                WHERE consumableID = $consumableID";

                if ($conn->query($updateQuery)) {
                    // Insert into the `assetassignment` table
                    $insertAssignmentQuery = "INSERT INTO assetassignment (assignmentDate, itemID, userID, checkoutNotes, quantity, `status`)
                                              VALUES ('$assignmentDate', $itemID, $userID, '$checkoutNotes', $quantityTaken, 'Completed')";

                    if ($conn->query($insertAssignmentQuery)) {
                        // Redirect on success
                        header("Location: consumables.php");
                        exit;
                    } else {
                        echo "Error adding asset assignment: " . $conn->error;
                    }
                } else {
                    echo "Error updating consumable quantities: " . $conn->error;
                }
            } else {
                echo "Invalid quantity requested. Available quantity: $currentRemaining.";
            }
        } else {
            echo "Consumable not found.";
        }
    }

    $previousPage = $_SERVER['HTTP_REFERER'] ?? 'index.php';

    if (isset($_POST["addCategoryButton"])) {
        $categoryName = $_POST['categoryName'] ?? '';

        if (!empty($categoryName)) {
            $conn->query("INSERT INTO category (`name`) VALUES ('$categoryName')");

            if ($conn->affected_rows > 0) {
                header("Location: $previousPage");
                exit;
            } else {
                echo "Error adding category: " . $conn->error;
            }
        } else {
            echo "Category Name is required.";
        }
    }

    // Handle Add Manufacturer
    if (isset($_POST["addManufacturerButton"])) {
        $manufacturerName = $_POST['manufacturerName'] ?? '';
        $url = $_POST['url'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';

        if (!empty($manufacturerName)) {
            $conn->query("INSERT INTO manufacturer (`name`, `url`, supportEmail, supportPhone) VALUES ('$manufacturerName', '$url', '$email', '$phone')");

            if ($conn->affected_rows > 0) {
                header("Location: $previousPage");
                exit;
            } else {
                echo "Error adding manufacturer: " . $conn->error;
            }
        } else {
            echo "Manufacturer Name is required.";
        }
    }

    // Handle Add Office
    if (isset($_POST["addOfficeButton"])) {
        $officeName = $_POST['officeName'] ?? '';
        $address = $_POST['address'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';

        if (!empty($officeName)) {
            $conn->query("INSERT INTO office (`name`, `address`, email, phone) VALUES ('$officeName', '$address', '$email', '$phone')");

            if ($conn->affected_rows > 0) {
                header("Location: $previousPage");
                exit;
            } else {
                echo "Error adding office: " . $conn->error;
            }
        } else {
            echo "Office Name is required.";
        }
    }

    // Handle Add Supplier
    if (isset($_POST["addSupplierButton"])) {
        $supplierName = $_POST['supplierName'] ?? '';
        $address = $_POST['address'] ?? '';
        $contactName = $_POST['contactName'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';

        if (!empty($supplierName)) {
            $conn->query("INSERT INTO supplier (`name`, `address`, contactName, email, phone) VALUES ('$supplierName', '$address', '$contactName', '$email', '$phone')");

            if ($conn->affected_rows > 0) {
                header("Location: $previousPage");
                exit;
            } else {
                echo "Error adding supplier: " . $conn->error;
            }
        } else {
            echo "Supplier Name is required.";
        }
    }


    if (isset($_POST['addUserButton'])) {
        $userID = $_POST['userID'] ?? '';
        $firstName = $_POST['fname'] ?? '';
        $lastName = $_POST['lname'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : '';
        $role = $_POST['role'] ?? '';
        $statusID = $_POST['status'] ?? '';
        $officeID = $_POST['office'] ?? '';
        $departmentID = $_POST['department'] ?? '';
        $loginEnabled = isset($_POST['loginEnabled']) ? 1 : 0;

        $image = $_FILES['image']['name'] ?? '';
        $imagePath = 'images/' . $image;

        // Move uploaded image file
        if (!empty($image)) {
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        }

        // Validation for required fields
        if (!empty($firstName) && !empty($lastName) && !empty($email) && !empty($role)) {
            // Insert user data (Prepared Statement)
            if (isset($_POST['addUserButton'])) {
                $stmt = $conn->prepare("INSERT INTO `user` 
                    (fname, lname, email, password, image, role, loginEnabled, departmentID, statusID, locationID) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param('ssssssiiii', $firstName, $lastName, $email, $password, $image, $role, $loginEnabled, $departmentID, $statusID, $officeID);
            }
            // Update user data (Prepared Statement)
            elseif (isset($_POST['updateUserButton'])) {
                if (!empty($password)) {
                    $stmt = $conn->prepare("UPDATE `user` SET fname=?, lname=?, email=?, password=?, image=?, role=?, loginEnabled=?, departmentID=?, statusID=?, locationID=? WHERE userID=?");
                    $stmt->bind_param('ssssssiiiii', $firstName, $lastName, $email, $password, $image, $role, $loginEnabled, $departmentID, $statusID, $officeID, $userID);
                } else {
                    // If password is empty, don't update it
                    $stmt = $conn->prepare("UPDATE `user` SET fname=?, lname=?, email=?, image=?, role=?, loginEnabled=?, departmentID=?, statusID=?, locationID=? WHERE userID=?");
                    $stmt->bind_param('ssssiiiii', $firstName, $lastName, $email, $image, $role, $loginEnabled, $departmentID, $statusID, $officeID, $userID);
                }
            }

            // Execute the query and check for errors
            if ($stmt->execute()) {
                echo "<script>alert('User data saved successfully!');</script>";
                header("Location: manageUsers.php");
                exit;
            } else {
                echo "Error saving user data: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Please fill in all required fields.";
        }
    }

    if (isset($_POST['updateUserButton'])) {
        $userID = $_POST['userID'] ?? '';
        $fname = $_POST['fname'] ?? '';
        $lname = $_POST['lname'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? ''; // Optional password
        $loginEnabled = isset($_POST['loginEnabled']) ? 1 : 0; // Checkbox handling
        $image = $_FILES['image']['name'] ?? ''; // Optional image upload
        $role = $_POST['role'] ?? '';
        $statusID = $_POST['status'] ?? '';
        $officeID = !empty($_POST['office']) ? $_POST['office'] : 'NULL';
        $departmentID = !empty($_POST['department']) ? $_POST['department'] : 'NULL';

        // Handle image upload if a new image is provided
        if (!empty($image)) {
            $imagePath = 'images/' . basename($image);
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        } else {
            // Fetch current image if no new image is uploaded
            $result = $conn->query("SELECT u.image FROM user u WHERE u.userID = $userID");
            if ($result && $row = $result->fetch_assoc()) {
                $image = $row['image']; // Retain the existing image
            }
        }

        // Prepare the query based on whether a password is provided
        if (!empty($password)) {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare(
                "UPDATE `user` SET fname=?, lname=?, email=?, password=?, image=?, role=?, loginEnabled=?, departmentID=?, statusID=?, locationID=? WHERE userID=?"
            );
            $stmt->bind_param('ssssssiiiii', $fname, $lname, $email, $hashedPassword, $image, $role, $loginEnabled, $departmentID, $statusID, $officeID, $userID);
        } else {
            // Exclude password if not provided
            $stmt = $conn->prepare(
                "UPDATE `user` SET fname=?, lname=?, email=?, image=?, role=?, loginEnabled=?, departmentID=?, statusID=?, locationID=? WHERE userID=?"
            );
            $stmt->bind_param('ssssssiiii', $fname, $lname, $email, $image, $role, $loginEnabled, $departmentID, $statusID, $officeID, $userID);
        }

        if ($stmt->execute()) {
            header("Location: manageUsers.php");
            exit;
        } else {
            echo "Error updating user: " . $stmt->error;
        }
    }

    if (isset($_POST['deleteUserButton'])) {
        $userID = $_POST['userID'] ?? '';

        if (!empty($userID)) {
            // Ensure to sanitize the input to prevent SQL injection
            $userID = (int)$userID; // Typecasting to integer

            // Prepare the delete statement
            $stmt = $conn->prepare("DELETE FROM `user` WHERE userID = ?");
            $stmt->bind_param('i', $userID);

            if ($stmt->execute()) {
                // Redirect back to the user management page or show a success message
                header("Location: manageUsers.php?message=User deleted successfully");
                exit;
            } else {
                echo "Error deleting user: " . $stmt->error;
            }
        } else {
            echo "Invalid user ID.";
        }
    }



    // Add Maintenance
    if (isset($_POST["addMaintenanceButton"])) {
        $startDate = $_POST['startDate'] ?? '';
        $completionDate = $_POST['completionDate'] ?? '';
        $type = $_POST['type'] ?? '';
        $description = $_POST['description'] ?? '';
        $cost = $_POST['cost'] ?? '';
        $itemID = $_POST['itemID'] ?? '';

        if (!empty($startDate) && !empty($completionDate) && !empty($type) && !empty($description) && !empty($cost) && !empty($itemID)) {
            $stmt = $conn->prepare("INSERT INTO Maintenance (startDate, completionDate, type, description, cost, itemID) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssdi", $startDate, $completionDate, $type, $description, $cost, $itemID);

            if ($stmt->execute()) {
                header("Location: maintenance.php");
                exit;
            } else {
                echo "Error adding maintenance: " . $conn->error;
            }
        } else {
            echo "All fields are required.";
        }
    }

    // Update Maintenance
    if (isset($_POST["updateMaintenanceButton"])) {
        $maintenanceID = $_POST['maintenanceID'] ?? '';
        $startDate = $_POST['startDate'] ?? '';
        $completionDate = $_POST['completionDate'] ?? '';
        $type = $_POST['type'] ?? '';
        $description = $_POST['description'] ?? '';
        $cost = $_POST['cost'] ?? '';
        $itemID = $_POST['itemID'] ?? '';

        if (!empty($maintenanceID) && !empty($startDate) && !empty($completionDate) && !empty($type) && !empty($description) && !empty($cost) && !empty($itemID)) {
            $stmt = $conn->prepare("UPDATE Maintenance SET startDate = ?, completionDate = ?, type = ?, description = ?, cost = ?, itemID = ? WHERE maintenanceID = ?");
            $stmt->bind_param("ssssdii", $startDate, $completionDate, $type, $description, $cost, $itemID, $maintenanceID);

            if ($stmt->execute()) {
                header("Location: maintenance.php");
                exit;
            } else {
                echo "Error updating maintenance: " . $conn->error;
            }
        } else {
            echo "All fields are required.";
        }
    }

    // Add Audit
if (isset($_POST["addAuditButton"])) {
    $auditDate = $_POST['auditDate'] ?? '';
    $auditor = $_POST['auditor'] ?? '';
    $findings = $_POST['findings'] ?? '';
    $itemID = $_POST['itemID'] ?? '';

    if (!empty($auditDate) && !empty($auditor) && !empty($findings) && !empty($itemID)) {
        $stmt = $conn->prepare("INSERT INTO Audit (auditDate, auditor, findings, itemID) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $auditDate, $auditor, $findings, $itemID);

        if ($stmt->execute()) {
            header("Location: audit.php");
            exit;
        } else {
            echo "Error adding audit: " . $conn->error;
        }
    } else {
        echo "All fields are required.";
    }
}

// Update Audit
if (isset($_POST["updateAuditButton"])) {
    $auditID = $_POST['auditID'] ?? '';
    $auditDate = $_POST['auditDate'] ?? '';
    $auditor = $_POST['auditor'] ?? '';
    $findings = $_POST['findings'] ?? '';
    $itemID = $_POST['itemID'] ?? '';

    if (!empty($auditID) && !empty($auditDate) && !empty($auditor) && !empty($findings) && !empty($itemID)) {
        $stmt = $conn->prepare("UPDATE Audit SET auditDate = ?, auditor = ?, findings = ?, itemID = ? WHERE auditID = ?");
        $stmt->bind_param("sssii", $auditDate, $auditor, $findings, $itemID, $auditID);

        if ($stmt->execute()) {
            header("Location: audit.php");
            exit;
        } else {
            echo "Error updating audit: " . $conn->error;
        }
    } else {
        echo "All fields are required.";
    }
}

}
