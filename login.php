<?php
session_start(); // Start the session (though not strictly needed for registration itself, good practice for related flows)

// --- Database Configuration (UPDATE THESE TO YOUR ACTUAL CREDENTIALS) ---
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root'); // Common default user for local MySQL installations (e.g., XAMPP, WAMP)
define('DB_PASSWORD', '');     // Common default password (empty string) for 'root' on local installations
define('DB_NAME', 'favpet_db'); // The name of your database

// Attempt to connect to MySQL database
try {
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    // Set the PDO error mode to exception for better error handling
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("ERROR: Could not connect to the database. " . $e->getMessage());
}

// Initialize variables for form data and errors
$username = $email = $password = $confirm_password = "";
$username_err = $email_err = $password_err = $confirm_password_err = $general_err = "";
$registration_success_message = ""; // Variable to hold success message for this page

// Process form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Validate Username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else {
        // Check if username is already taken
        $sql = "SELECT id FROM users WHERE username = :username";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $param_username = trim($_POST["username"]);
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                $general_err = "Oops! Something went wrong. Please try again later.";
            }
            unset($stmt);
        }
    }

    // 2. Validate Email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a valid email address.";
    } else {
        // Check if email is already taken
        $sql = "SELECT id FROM users WHERE email = :email";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $param_email = trim($_POST["email"]);
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $email_err = "This email is already registered.";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                $general_err = "Oops! Something went wrong. Please try again later.";
            }
            unset($stmt);
        }
    }

    // 3. Validate Password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // 4. Validate Confirm Password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // 5. If no errors, insert user into database
    if (empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($general_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, email, password_hash) VALUES (:username, :email, :password_hash)";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $stmt->bindParam(":password_hash", $param_password_hash, PDO::PARAM_STR);

            // Set parameters
            $param_username = $username;
            $param_email = $email;
            $param_password_hash = password_hash($password, PASSWORD_DEFAULT); // Hash the password!

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Set the success message for display on THIS page
                $registration_success_message = "Account created successfully! You can now log in.";
                // Clear the form fields after successful registration
                $username = $email = $password = $confirm_password = "";

            } else {
                $general_err = "Something went wrong. Please try again later.";
            }

            unset($stmt);
        }
    }
    unset($pdo); // Close connection
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favpet - Create Account</title>
    <style>
        /* --- CSS Styling (Embedded - Mostly reused from login page) --- */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

        :root {
            --primary-color: #FF6B6B; /* Example reddish-orange from the image */
            --secondary-color: #555;
            --text-color: #333;
            --light-grey: #f0f0f0;
            --white: #fff;
            --border-color: #ddd;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            background-color: var(--light-grey);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 5%;
            background-color: var(--white);
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .logo img {
            height: 40px; /* Adjust as needed */
            /* Ensure you have an image file here, e.g., in a 'images' folder: src="images/favpet_logo.png" */
        }

        nav ul {
            list-style: none;
            display: flex;
        }

        nav ul li {
            margin-right: 30px;
        }

        nav ul li a {
            text-decoration: none;
            color: var(--secondary-color);
            font-weight: 500;
            transition: color 0.3s ease;
        }

        nav ul li a:hover {
            color: var(--primary-color);
        }

        .header-actions {
            display: flex;
            gap: 15px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .btn-login {
            background-color: transparent;
            color: var(--secondary-color);
            border: 1px solid var(--border-color);
        }

        .btn-login:hover {
            background-color: var(--light-grey);
        }

        .btn-request-service {
            background-color: var(--primary-color);
            color: var(--white);
        }

        .btn-request-service:hover {
            background-color: #e65c5c; /* Darker shade of primary */
        }

        /* Main Registration Container (reusing login-container class for general layout) */
        .register-container {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            background-color: var(--light-grey);
        }

        .register-card { /* Similar styling to login-card */
            background-color: var(--white);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            text-align: center;
            width: 100%;
            max-width: 400px;
        }

        .register-card h2 {
            font-size: 2.2em;
            margin-bottom: 10px;
            color: var(--text-color);
        }

        .register-card p {
            color: var(--secondary-color);
            margin-bottom: 30px;
            font-size: 0.95em;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--secondary-color);
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border-color);
            border-radius: 5px;
            font-size: 1em;
            color: var(--text-color);
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-group input[type="text"]:focus,
        .form-group input[type="email"]:focus,
        .form-group input[type="password"]:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.2);
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            background-color: var(--primary-color);
            color: var(--white);
            font-size: 1.1em;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #e65c5c;
        }

        .login-link { /* Renamed from signup-link */
            margin-top: 25px;
            font-size: 0.9em;
            color: var(--secondary-color);
        }

        .login-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: #d9534f; /* Red for errors */
            margin-top: 5px; /* Adjust margin for individual field errors */
            font-size: 0.85em;
            font-weight: 500;
            text-align: left; /* Error messages should typically align with fields */
        }
        .general-error-message { /* For overall form errors */
            color: #d9534f;
            margin-top: 15px;
            font-size: 0.9em;
            font-weight: 500;
            text-align: center;
        }
        .success-message { /* Style for success message on this page */
            color: #28a745; /* Green */
            background-color: #d4edda; /* Light green background */
            border: 1px solid #c3e6cb;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px; /* Space above form */
            font-size: 0.9em;
            font-weight: 500;
            text-align: center;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                padding: 15px 20px;
            }

            nav ul {
                margin-top: 15px;
                flex-wrap: wrap;
                justify-content: center;
            }

            nav ul li {
                margin: 5px 15px;
            }

            .header-actions {
                margin-top: 15px;
            }

            .register-card {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="logo.png" alt="Favpet Logo">
        </div>
        <nav>
            <ul>
                <li><a href="find.php">Find Favpet</a></li>
                <li><a href="service.php">Service</a></li>
                <li><a href="favpet.php">Favpet</a></li>
                <li><a href="#">Review</a></li>
            </ul>
        </nav>
        <div class="header-actions">
            <a href="index.php" class="btn btn-login">Login</a>
            <a href="#" class="btn btn-request-service">Request Service</a>
        </div>
    </header>

    <main class="register-container">
        <div class="register-card">
            <h2>Create Your Account</h2>
            <p>Join Favpet today!</p>

            <?php
            // PHP to display the success message after successful registration
            if (!empty($registration_success_message)) {
                echo '<p class="success-message">' . htmlspecialchars($registration_success_message) . '</p>';
            }
            ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" novalidate>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
                    <span class="error-message"><?php echo $username_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                    <span class="error-message"><?php echo $email_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                    <span class="error-message"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                    <span class="error-message"><?php echo $confirm_password_err; ?></span>
                </div>
                <button type="submit" class="btn btn-primary">Create Account</button>
            </form>
            <?php
            // Display general errors (e.g., database connection issues)
            if (!empty($general_err)) {
                echo '<p class="general-error-message">' . htmlspecialchars($general_err) . '</p>';
            }
            ?>
            <p class="login-link">Already have an account? <a href="index.php">Login here</a></p>
        </div>
    </main>

    <footer>
    </footer>
</body>
</html>