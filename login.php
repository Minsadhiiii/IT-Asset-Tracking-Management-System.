<?php
// session_start();
include __DIR__ . '/config/connection.php';
// If already logged in, go to dashboard
if (isset($_SESSION["user"])) {
    header("Location: dashboard.php");
    exit;
}

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $errors = [];

    if (empty($username)) {
        $errors[] = "Email is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    if (empty($errors)) {
        $query = "SELECT * FROM user WHERE email = ? LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            if ($user['loginEnabled'] == 1) {
                if (password_verify($password, $user['password'])) {
                    $_SESSION["user"] = [
                        "userID" => htmlspecialchars($user["userID"]),
                        "fname" => htmlspecialchars($user["fname"]),
                        "lname" => htmlspecialchars($user["lname"]),
                        "role" => htmlspecialchars($user["role"]),
                        "email" => htmlspecialchars($user["email"]),
                        "image" => htmlspecialchars($user["image"]),
                        "departmentID" => htmlspecialchars($user["departmentID"]),
                        "statusID" => htmlspecialchars($user["statusID"]),
                        "locationID" => htmlspecialchars($user["locationID"]),
                    ];
                    header('Location: dashboard.php');
                    exit;
                } else {
                    $errors[] = "Incorrect password.";
                }
            } else {
                $errors[] = "Your account is disabled. Please contact the administrator.";
            }
        } else {
            $errors[] = "Email does not exist.";
        }
    }

    // Save errors for display after redirect
    if (!empty($errors)) {
        $_SESSION["errors_login"] = $errors;
        header('Location: login.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="./assets/css/loginstyle.css">
</head>
<body>
<div class="login-wrapper">
    <!-- Left Panel -->
    <div class="login-left">
        <div class="illustration">
            <img src="./assets/images/login.png" alt="Illustration">
            <p class="terms">
                By signing up you confirm that you've read and accepted our
                <a href="#">Terms & Conditions</a> and <a href="#">Privacy Policy</a>.
            </p>
        </div>
    </div>
    <!-- Right Panel -->
    <div class="login-right">
        <div class="login-box">
            <img src="./assets/images/logo.png" alt="Logo" class="logo">
            <h2>IT Asset Management System</h2>
            <p class="subtitle">Login to continue to your account</p>

            <form id="login-form" action="login.php" method="POST">
                <div class="input-group">
                    <input type="text" id="username" name="username" placeholder="Username">
                </div>
                <div class="input-group">
                    <input type="password" id="password" name="password" placeholder="Password">
                </div>

                <div class="login-options">
                    <label><input type="checkbox" name="remember"> Remember</label>
                    <a href="#" class="forgot">Forgot Password</a>
                </div>
                <div class="error">
                    <?php
                    if (isset($_SESSION["errors_login"])) {
                        foreach ($_SESSION["errors_login"] as $error) {
                            echo "<p>$error</p>";
                        }
                        unset($_SESSION["errors_login"]);
                    }
                    ?>
                </div>
                <button type="submit" class="btn-login">Login</button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('login-form');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const errorDiv = document.querySelector('.error');

    form.addEventListener('submit', function (event) {
        let valid = true;
        let errorMessage = '';

        errorDiv.innerHTML = '';

        if (usernameInput.value.trim() === '' && passwordInput.value.trim() === '') {
            errorMessage = 'Enter both username and password.';
            valid = false;
        } else if (usernameInput.value.trim() === '') {
            errorMessage = 'Username is required.';
            valid = false;
        } else if (passwordInput.value.trim() === '') {
            errorMessage = 'Password is required.';
            valid = false;
        }

        if (!valid) {
            errorDiv.innerHTML = `<p>${errorMessage}</p>`;
            event.preventDefault();
        }
    });
});
</script>
</body>
</html>
