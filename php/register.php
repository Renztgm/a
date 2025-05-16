<?php
session_start();
require_once 'db.php'; // Make sure db.php is in the same directory

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = filter_var($_POST['firstName'], FILTER_SANITIZE_STRING);
    $lastName = filter_var($_POST['lastName'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    
    // Validate password match
    if ($password !== $confirmPassword) {
        $error = "Passwords do not match";
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $error = "Email already exists";
        } else {
            // Hash password and insert new user
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (firstName, lastName, email, password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $firstName, $lastName, $email, $hashedPassword);
            
            if ($stmt->execute()) {
                $_SESSION['registration_success'] = "Account created successfully! Please login.";
                header("Location: login.php");
                exit();
            } else {
                $error = "Registration failed";
            }
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../css/register.css">
</head>
<body>
    <div class="login-box">
        <h2>Create Account</h2>
        <?php if (isset($error)): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="firstName">First Name</label>
            <input type="text" id="firstName" name="firstName" required>

            <label for="lastName">Last Name</label>
            <input type="text" id="lastName" name="lastName" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <label for="confirmPassword">Confirm Password</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required>

            <button type="submit">Register</button>
        </form>
        <p class="register-link">
            Already have an account? <a href="login.php">Login</a>
        </p>
    </div>
</body>
</html>