<?php
include('./config/connection.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["addCategoryButton"])) {

        $categoryName = $_POST['categoryName'] ?? '';

        if (!empty($categoryName)) {
            $conn->query("INSERT INTO category (`name`) VALUES ('$categoryName')");

            if ($conn->affected_rows > 0) {
                header("Location: categories.php");
                exit;
            } else {
                echo "Error adding category: " . $conn->error;
            }
        } else {
            echo "Category Name is required.";
        }
    }

    if (isset($_POST["updateCategoryButton"])) {
        $categoryName = $_POST['categoryName'] ?? '';
        $categoryID = $_POST['categoryID'] ?? '';


        if (!empty($categoryName)) {
            $conn->query("UPDATE category
            SET `name` = '$categoryName'
            WHERE categoryID = $categoryID");

            if ($conn->affected_rows > 0) {
                header("Location: categories.php");
                exit;
            } else {
                echo "Error adding category: " . $conn->error;
            }
        } else {
            echo "Category Name is required.";
        }
    }
}

// Variables
$categoryID = isset($_GET['categoryID']) ? intval($_GET['categoryID']) : null;
$isEditMode = $categoryID !== null;


// Initialize variables
$name =  "";

if ($isEditMode) {
    $stmt = $conn->prepare("SELECT categoryID, `name` 
        FROM category
        WHERE categoryID = ?");
    $stmt->bind_param("i", $categoryID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $category = $result->fetch_assoc();
        // Populate variables with existing data
        extract($category);
    } else {
        echo "Invalid Category ID.";
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
            <h1>Add Category</h1>
        </div>
        <div class="form-container">
            <div class="form-body">
                <form id="categoryForm" action="addCategory.php" method="POST" enctype="multipart/form-data" onsubmit="return validateCategoryForm()">
                    <input type="hidden" name="categoryID" value="<?php echo htmlspecialchars($categoryID ?? ''); ?>">
                    <!-- Name -->
                    <div class="form-element">
                        <label for="categoryName">Category Name:</label>
                        <input type="text" id="categoryName" name="categoryName" placeholder="Category Name" value="<?php echo htmlspecialchars($name); ?>">
                    </div>


                    <div style="text-align: center; margin-top: 20px;" id="error-box" class="error-box"></div>
                    <!-- Form Footer -->
                    <div class="form-footer">
                        
                        <button class="primary-button" type="submit" name="<?php echo $isEditMode ? 'updateCategoryButton' : 'addCategoryButton'; ?>">
                            <?php echo $isEditMode ? "Update Category" : "Add Category"; ?>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </main>
    <?php include('./includes/footer.php'); ?>

    <script>
        function validateComponentForm() {
            const categoryName = document.getElementById("categoryName").value.trim();


            const errorBox = document.getElementById("error-box");

            errorBox.innerHTML = "";

            if (!categoryName) {
                errorBox.innerHTML = "Category Name is required.";
                return false;
            }


            return true;
        }
    </script>

    <script src="./assets/js/expand.js"></script>
    <script src=".assets/js/popupLast.js"></script>
</body>

</html>