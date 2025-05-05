<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}
$sql = "SELECT id, title, author, cover_image FROM books ORDER BY id DESC"; // Change as needed
$result = $conn->query($sql);


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
            <?php
if ($result->num_rows > 0) {
    while ($book = $result->fetch_assoc()) {
        $title = htmlspecialchars($book['title']);
        $author = htmlspecialchars($book['author']);
        $cover = $book['cover_image'];

        // Use default if no cover
        if (!$cover) {
            $cover = 'assets/images/default-book.jpg';
        } else {
            $cover = 'admin/assets/uploadsBooks/' . $cover;
        }

        echo '<div class="book-card">';
        echo '<img src="' . $cover . '" alt="' . $title . '" class="book-cover">';
        echo '<h2 class="book-title">' . $title . '</h2>';
        echo '<p class="book-author">by ' . ($author ? $author : 'Unknown') . '</p>';
        echo '<div class="book-actions">';
        echo '<a href="" class="view-book-btn">View</a>';
        echo '<a href="borrow.php?id=' . $book['id'] . '" class="borrow-book-btn">Borrow</a>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo '<p>No books found in the library.</p>';
}
            ?>

            <!-- <div class="book-card">
                <img src="https://via.placeholder.com/150x200/F44336/FFFFFF?Text=Book+2" alt="Book 2" class="book-cover">
                <h2 class="book-title">Samvidhan - Ek Sankalpana</h2>
                <p class="book-author">by ---</p>
                <div class="book-actions">
                    <button class="view-book-btn">View</button>
                    <button class="borrow-book-btn">Borrow</button>
                 </div>
            </div> -->
            
        </div>
    </div>

  </div>
    
</div>
<?php include 'includes/footer.php'; ?> 
</body>
</html>