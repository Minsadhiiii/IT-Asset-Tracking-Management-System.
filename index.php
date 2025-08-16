<?php
session_start(); // Start the session

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION["user"])) {
    // Redirect to login.php if not logged in
    header('Location: login.php');
    exit;
}

?>
