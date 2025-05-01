<?php


$activePage = 'books'
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="admin/assets/css/admin.css"> <!-- for side bar -->
    <link rel="stylesheet" href="assets/css/books.css">
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
            <div class="welcome">Welcome to the Library</div>
            <div class="library-info">Explore our collection of books.</div>
        </div>

        <div class="book-catalog">
            <div class="book-card">
                <img src="https://via.placeholder.com/150x200/4CAF50/FFFFFF?Text=Book+1" alt="Book 1" class="book-cover">
                <h2 class="book-title">Chhatrapati - 2 Volume Set</h2>
                <p class="book-author">by K. N. Sardesai</p>
                 <div class="book-actions">
                    <button class="view-book-btn">View</button>
                    <button class="borrow-book-btn">Borrow</button>
                 </div>
            </div>
            <div class="book-card">
                <img src="https://via.placeholder.com/150x200/F44336/FFFFFF?Text=Book+2" alt="Book 2" class="book-cover">
                <h2 class="book-title">Samvidhan - Ek Sankalpana</h2>
                <p class="book-author">by ---</p>
                <div class="book-actions">
                    <button class="view-book-btn">View</button>
                    <button class="borrow-book-btn">Borrow</button>
                 </div>
            </div>
            <div class="book-card">
                <img src="https://via.placeholder.com/150x200/FF9800/FFFFFF?Text=Book+3" alt="Book 3" class="book-cover">
                <h2 class="book-title">Anandmathi - Godantar</h2>
                <p class="book-author">by ---</p>
                <div class="book-actions">
                    <button class="view-book-btn">View</button>
                    <button class="borrow-book-btn">Borrow</button>
                 </div>
            </div>
            <div class="book-card">
                <img src="https://via.placeholder.com/150x200/2196F3/FFFFFF?Text=Book+4" alt="Book 4" class="book-cover">
                <h2 class="book-title">Tukaram Maharaj - Vangmay</h2>
                <p class="book-author">by ---</p>
                <div class="book-actions">
                    <button class="view-book-btn">View</button>
                    <button class="borrow-book-btn">Borrow</button>
                 </div>
            </div>
            <div class="book-card">
                <img src="https://via.placeholder.com/150x200/8BC34A/FFFFFF?Text=Book+5" alt="Book 5" class="book-cover">
                <h2 class="book-title">The Great Indian Novel</h2>
                <p class="book-author">by Shashi Tharoor</p>
                 <div class="book-actions">
                    <button class="view-book-btn">View</button>
                    <button class="borrow-book-btn">Borrow</button>
                 </div>
            </div>
            <div class="book-card">
                <img src="#" alt="Book 6" class="book-cover">
                <h2 class="book-title">A Suitable Boy</h2>
                <p class="book-author">by Vikram Seth</p>
                 <div class="book-actions">
                    <button class="view-book-btn">View</button>
                    <button class="borrow-book-btn">Borrow</button>
                 </div>
            </div>
        </div>
    </div>

  </div>
    
</div>
<?php include 'includes/footer.php'; ?> 
</body>
</html>