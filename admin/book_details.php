<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

if (!isLoggedIn() || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "No book ID provided.";
    exit;
}

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM books WHERE id = $id");

if ($result->num_rows === 0) {
    echo "Book not found.";
    exit;
}

$book = $result->fetch_assoc();

$activePage = 'manage-books'; // For sidebar

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Book Info - <?= htmlspecialchars($book['title']) ?></title> <!-- php for book title -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="assets/css/bookinfo.css">
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <div class="body">

        <div class="sidebar">
            <?php include 'includes/sidebar.php'; ?>
        </div>
        
        <main class="main">
            <div class="header">
                <div class="breadcrumbs">
                    <a href="manage-books.php">Manage Books</a>
                    <span>></span>
                    <span><?= htmlspecialchars($book['title']) ?></span>
                </div>
                <a href="edit-book.php?id=<?= $book['id'] ?>" class="edit-button">Edit Book</a>
            </div>
            <div class="container">
        
                <div class="section-title">Book Information</div>
                <div class="info-img">
                    <div class="cover-img" >
                        <!-- book cover image here -->
                         <img src="assets/uploadsBooks/<?= htmlspecialchars($book['cover_image']) ?>" alt="Book Cover">
                    </div>
                    <div class="info-grid">
                        <div class="info-item">
                            <strong>Book title</strong>
                            <?= htmlspecialchars($book['title']) ?>
                        </div>
                        <div class="info-item">
                            <strong>Author(s)</strong>
                            <?= htmlspecialchars($book['author']) ?>
                        </div>
                        <div class="info-item">
                            <strong>ISBN/ISSN</strong>
                            <?= htmlspecialchars($book['isbn']) ?>
                        </div>
                        <div class="info-item">
                            <strong>Genre/Category</strong>
                            <?= htmlspecialchars($book['category']) ?>
                        </div>
                        <div class="info-item">
                            <strong>Language</strong>
                            <?= htmlspecialchars($book['language']) ?>
                        </div>
                        <div class="info-item">
                            <strong>Available Copies</strong>
                            <?= htmlspecialchars($book['available_copies']) ?>
                        </div>
                        <div class="info-item">
                            <strong>Total Copies</strong>
                            <?= htmlspecialchars($book['copies']) ?>
                        </div>
                        <div class="info-item">
                            <strong>Shelf/Location Code</strong>
                            <?= htmlspecialchars($book['shelf_code']) ?>
                        </div>
                        <div class="info-item">
                            <strong>Status</strong>
                            <?= htmlspecialchars($book['status']) ?>
                        </div>
                        <div class="info-item">
                            <strong>File Attachment</strong>
                            <a href="assets/uploadsBooks/<?= htmlspecialchars($book['cover_image']) ?>">
                                <?= htmlspecialchars($book['cover_image']) ?>
                            </a>
                        </div>
                    </div>
                </div>
        
                <div class="section-title">Features Information</div>
                <div class="info-grid">
                    <div class="info-item">
                        <strong>Book Features</strong>
                        <?= htmlspecialchars($book['features']) ?>
                    </div>
                    <div class="info-item">
                        <strong>Total Number of Pages</strong>
                        <?= htmlspecialchars($book['total_pages']) ?>
                    </div>
                    <div class="info-item">
                        <strong>Book Published Date</strong>
                        <?= htmlspecialchars($book['published_date']) ?>
                    </div>
                    <div class="info-item">
                        <strong>Book Volume</strong>
                        <?= htmlspecialchars($book['volume']) ?>
                    </div>
                </div>
        
                <div class="moral-of-book">
                    <strong>Moral of the Book</strong>
                    <?= htmlspecialchars($book['moral']) ?>
                </div>
        
                <div class="button-container">
                    <button onclick="location.replace('manage-books.php')" class="cancel-button">Cancel</button>
                </div>
            </div>
            
        </main>
    </div>
    <?php include 'includes/footer.php' ?>
</body>

</html>
