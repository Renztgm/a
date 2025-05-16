<?php
session_start();
require 'db.php'; // Make sure you have your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    
    // Prepare SQL statement to fetch user data from users table
    $stmt = $conn->prepare("SELECT id, firstName, lastName, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        // Verify password using password_verify() to check against hashed password
        if (password_verify($password, $user['password'])) {
            // Set session variables with user data
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['firstName'] = $user['firstName'];
            $_SESSION['lastName'] = $user['lastName'];
            $_SESSION['email'] = $user['email'];
            
            // Redirect to dashboard after successful login
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid password";
        }
    } else {
        $error = "User not found";
    }
    
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login</title>
    <link rel="icon" href="../img/logo.svg" type="image/svg">
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script defer src="../js/password-toggle.js"></script>
</head>
<body>
    <div class="login-box">
        <h2>Login</h2>
        <?php if (isset($_SESSION['registration_success'])): ?>
            <div class="success-message">
                <?php 
                echo htmlspecialchars($_SESSION['registration_success']);
                unset($_SESSION['registration_success']); // Clear the message after showing
                ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password</label>
            <div class="password-container">
                <input type="password" id="password" name="password" required>
                <i class="far fa-eye" id="togglePassword"></i>
            </div>

            <button type="submit">Login</button>
        </form>
        <p class="register-link">
            Don't have an account? <a href="register.php">Create Account</a>
        </p>
    </div>
</body>
</html>
