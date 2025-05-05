<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once 'includes/db.php';  // Include DB connection
require_once 'includes/auth.php'; // Include auth checks

// Redirect to dashboard if already logged in
if (isLoggedIn()) {
  if ($_SESSION['role'] == 'admin') {
    header('Location: admin/');
    exit();
  } 
  header('Location: dashboard.php');
  exit();
}

// Handle form submission for login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // For Login
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Query the database to check if the user exists
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Check if user exists
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role']; // e.g., 'admin' or 'user'
                $_SESSION['name'] = $user['name'];
                
                // Redirect based on role
                if ($user['role'] === 'admin') {
                  header("Location: admin/");
                } else {
                  header("Location: dashboard.php");
                }
                exit();
            } else {
                $login_error = "Invalid password!";
            }
        } else {
            $login_error = "No user found with that email!";
        }
    }

    // For Signup
    if (isset($_POST['signup'])) {
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $repeat_password = $_POST['repeat_password'];

        // Check if passwords match
        if ($password !== $repeat_password) {
            $signup_error = "Passwords do not match!";
        } else {
            // Hash password before storing it
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert into the database
            $sql = "INSERT INTO users (name, phone, email, password) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $name, $phone, $email, $hashed_password);
            $stmt->execute();

            // Check if the insert was successful
            if ($stmt->affected_rows > 0) {
                $user_id = $stmt->insert_id;
    
                // Step 2: Generate user_nameId using first name and user ID
                $first_name = explode(" ", trim($name))[0];
                $user_nameId = $first_name . '-' . $user_id;
    
                // Step 3: Update the user_nameId for the inserted user
                $update_sql = "UPDATE users SET user_nameId = ? WHERE id = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("si", $user_nameId, $user_id);
                $update_stmt->execute();
    
                // Session setup and redirect
                $_SESSION['user_id'] = $user_id;
                $_SESSION['email'] = $email;
                $_SESSION['role'] = 'user';
                $_SESSION['nameId'] = $user_nameId;
                $_SESSION['name'] = $name;

                // Redirect to My account
                header('Location: my_account.php');
                exit();
            } else {
                $signup_error = "Something went wrong! Please try again.";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login / Signup</title>
  <link rel="stylesheet" href="assets/css/login.css" />
</head>
<body>

  <div class="container" id="container">
    
    <!-- Signup Section -->
    <div class="form-container sign-up-container">
      <form action="login.php" method="POST">
        <h2>Create Account</h2>
        
        <?php if (isset($signup_error)): ?>
            <div class="error"><?= $signup_error ?></div>
        <?php endif; ?>

        <input type="text" name="name" placeholder="Full Name" required />
        <input type="text" name="phone" placeholder="Phone No." required />
        <input type="email" name="email" placeholder="Email" required />
        <input type="password" name="password" placeholder="Password" required />
        <input type="password" name="repeat_password" placeholder="Repeat Password" required />
        <button type="submit" name="signup">Sign Up</button>
        <p class="mobile-switch">Already have an account? <a href="#login" id="mobileToLogin">Login</a></p>
      </form>
    </div>

    <!-- Login Section -->
    <div class="form-container sign-in-container">
      <form action="login.php" method="POST">
        <h2>Sign in</h2>
        
        <?php if (isset($login_error)): ?>
            <div class="error"><?= $login_error ?></div>
        <?php endif; ?>
        
        <input type="email" name="email" placeholder="Email" required />
        <input type="password" name="password" placeholder="Password" required />
        <button type="submit" name="login">Login</button>
        <p class="mobile-switch">Don't have an account? <a href="#signup" id="mobileToSignup">Sign Up</a></p>
      </form>
    </div>

    <!-- Overlay Section -->
    <div class="overlay-container">
      <div class="overlay">
        <div class="overlay-panel overlay-left">
          <h2>Hello, Friend!</h2>
          <p>Enter your details and start your journey with us</p>
          <button class="ghost" id="signIn">Login</button>
        </div>
        <div class="overlay-panel overlay-right">
          <h2>Welcome Back!</h2>
          <p>To keep connected with us, please login with your personal info</p>
          <button class="ghost" id="signUp">Sign Up</button>
        </div>
      </div>
    </div>

  </div>

  <script src="assets/js/login.js"></script>

</body>
</html>