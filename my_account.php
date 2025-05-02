<?php 


    $activePage = 'my-account';
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
        <div class="header">
            <div class="welcome">My Account</div>
            <div class="library-info">Welcome to your profile.</div>
        </div>

        <div class="user-info-container">
            <img src="assets/images/default-user.jpeg" alt="Profile Photo" class="profile-photo">
            
            <button class="edit-button">Edit Profile</button>
            <div class="user-info">
                <div class="user-info-label">Name:</div>
                <div class="user-info-value">Punit</div>
                <div class="user-info-label">Email:</div>
                <div class="user-info-value">devil@gmail.com</div>
                <div class="user-info-label">Member ID:</div>
                <div class="user-info-value">12345</div>
                <div class="user-info-label">Membership Type:</div>
                <div class="user-info-value">Premium</div>
                <div class="user-info-label">Date of Birth:</div>
                <div class="user-info-value">January 1, 1990</div>
                <div class="user-info-label">Address:</div>
                <div class="user-info-value">123 Main St, Anytown, USA</div>
            </div>
        </div>

        <h2 class="section-header">Borrowed Books</h2>
        <div class="book-list">
            <div class="book-card">
                <img src="https://via.placeholder.com/150x200/4CAF50/FFFFFF?Text=Book+1" alt="Book 1" class="book-cover">
                <h2 class="book-title">Chhatrapati - 2 Volume Set</h2>
                <p class="book-author">by K. N. Sardesai</p>
                <div class="book-actions">
                    <button class="view-book-btn">View</button>
                </div>
            </div>
            <div class="book-card">
                <img src="https://via.placeholder.com/150x200/F44336/FFFFFF?Text=Book+2" alt="Book 2" class="book-cover">
                <h2 class="book-title">Samvidhan - Ek Sankalpana</h2>
                <p class="book-author">by ---</p>
                <div class="book-actions">
                    <button class="view-book-btn">View</button>
                </div>
            </div>
        </div>

        <h2 class="section-header">Reserved Books</h2>
        <div class="book-list">
            <div class="book-card">
                <img src="https://via.placeholder.com/150x200/FF9800/FFFFFF?Text=Book+3" alt="Book 3" class="book-cover">
                <h2 class="book-title">Anandmathi - Godantar</h2>
                <p class="book-author">by ---</p>
                <div class="book-actions">
                    <button class="view-book-btn">View</button>
                </div>
            </div>
        </div>
    </div>

  </div>
    
</div>
<?php include 'includes/footer.php'; ?> 
</body>
</html>