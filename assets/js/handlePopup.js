$(document).ready(function () {
    // Add Category
    $("#confirm-add-category").click(function () {
        $.ajax({
            url: "db_context.php",
            type: "POST",
            data: $("#form-add-category").serialize() + "&action=addCategory",
            success: function (response) {
                alert(response); // Show success or error message
                $("#form-add-category")[0].reset(); // Clear the form
                $("#popup-box-category").hide(); // Close the popup
            },
            error: function () {
                alert("An error occurred while adding the category.");
            },
        });
    });

    // Add Manufacturer
    $("#confirm-add-manufacturer").click(function () {
        $.ajax({
            url: "db_model.php",
            type: "POST",
            data: $("#form-add-manufacturer").serialize() + "&action=addManufacturer",
            success: function (response) {
                alert(response); // Show success or error message
                $("#form-add-manufacturer")[0].reset(); // Clear the form
                $("#popup-box-manufacturer").hide(); // Close the popup
            },
            error: function () {
                alert("An error occurred while adding the manufacturer.");
            },
        });
    });

    // Similar AJAX calls for Office and Supplier
});