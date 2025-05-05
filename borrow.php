<?php 
session_start();
include('includes/db.php');
include('includes/auth.php'); // Only allow logged in users

if (!isLoggedIn() || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="admin/assets/css/admin.css"> <!-- for side bar -->
    <link rel="stylesheet" href="assets/css/account.css">
</head>
<body>
<?php include 'includes/header.php'; ?>

<div class="body">

  <div class="sidebar">
    <?php include 'includes/sidebar.php'; ?>
  </div>

  <div class="main"> 
  
    <div class="dashboard-container">
        
        <p style="color:green;">GO Library to Borrow Books.</p>

    </div>

  </div>
    
</div>
<?php include 'includes/footer.php'; ?> 
</body>
</html>