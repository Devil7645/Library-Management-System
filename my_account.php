<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="admin/assets/css/admin.css"> <!-- for side bar -->
    
    <style>
        
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .welcome {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .library-info {
            background-color: #fff3e0;
            color: #e65100;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 14px;
        }

        .user-info-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            position: relative; /* To position the edit button */
            display: flex; /* Add this */
            flex-direction: column;
            align-items: center; /* Center content horizontally */
        }

        .edit-button {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: #1976d2;
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 3px;
            cursor: pointer;
            font-size: 14px;
        }

        .edit-button:hover {
            opacity: 0.9;
        }

        .user-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px 20px;
            width: 100%; /* Ensure user info takes full width of container */
        }

        .user-info-label {
            font-weight: bold;
            color: #555;
        }

        .user-info-value {
            color: #333;
        }

       .section-header{
            margin-top: 30px;
            margin-bottom: 10px;
            font-size: 20px;
            font-weight: bold;
            color: #333
        }

        .book-list{
            margin-top: 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .book-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 15px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* Add this */
        }

        .book-cover {
            width: 100%;
            height: 200px;
            object-fit: cover;
            margin-bottom: 10px;
            border-radius: 3px;
            background-color: #eee;
        }

        .book-title {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .book-author {
            font-size: 14px;
            color: #777;
            margin-bottom: 10px;
        }

        .book-actions {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 10px; /* Add this */
        }


        .view-book-btn{
            background-color: #1976d2;
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 3px;
            cursor: pointer;
            font-size: 14px;
            width: 100%;
        }

        .borrow-book-btn {
            background-color: #4caf50;
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 3px;
            cursor: pointer;
            font-size: 14px;
            width: 100%;
        }

        .view-book-btn:hover,
        .borrow-book-btn:hover {
            opacity: 0.9;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .user-info {
                grid-template-columns: 1fr;
            }
            .header {
                flex-direction: column;
                text-align: center;
            }
            .library-info{
                margin-top: 10px;
            }
        }

        .profile-photo {
            width: 150px; /* Adjust as needed */
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
            border: 3px solid #ddd; /* Optional border */
        }
    </style>
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
            <img src="https://via.placeholder.com/150" alt="Profile Photo" class="profile-photo">
            
            <button class="edit-button">Edit Profile</button>
            <div class="user-info">
                <div class="user-info-label">Name:</div>
                <div class="user-info-value">John Doe</div>
                <div class="user-info-label">Email:</div>
                <div class="user-info-value">john.doe@example.com</div>
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