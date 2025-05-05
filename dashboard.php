<?php 
require_once 'includes/db.php';
require_once 'includes/auth.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

$sql = "SELECT name, user_nameId  FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Lended books count (not returned yet)
$sql = "SELECT COUNT(*) FROM borrow_records WHERE user_id = ? AND return_date IS NULL";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($lendedCount);
$stmt->fetch();
$stmt->close();

// Overdue books (due_date < today and not returned)
$sql = "SELECT COUNT(*) FROM borrow_records WHERE user_id = ? AND return_date IS NULL AND due_date < CURDATE()";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($overdueCount);
$stmt->fetch();
$stmt->close();

// Reserved books

// Fetch total Books
$resultBooks = $conn->query("SELECT COUNT(*) AS total FROM books");
$reservedCount = $resultBooks->fetch_assoc()['total'];

// $sql = "SELECT COUNT(*) FROM books";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("i", $userId);
// $stmt->execute();
// $stmt->bind_result($reservedCount);
// $stmt->fetch();
// $stmt->close();

// Fines (example calculation)
// $sql = "SELECT 
//             SUM(CASE WHEN type = 'overdue' THEN amount ELSE 0 END) AS overdue_fines,
//             SUM(CASE WHEN type = 'damage' THEN amount ELSE 0 END) AS damage_fines
//         FROM fines
//         WHERE user_id = ?";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("i", $userId);
// $stmt->execute();
// $stmt->bind_result($overdueFines, $damageFines);
// $stmt->fetch();
// $stmt->close();

// $totalFines = $overdueFines + $damageFines;
// $overduePercent = $totalFines > 0 ? round(($overdueFines / $totalFines) * 100) : 0;
// $damagePercent = 100 - $overduePercent;

$activePage = 'dashboard';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard <?= htmlspecialchars($user['user_nameId']) ?>  </title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="admin/assets/css/admin.css"> <!-- for side bar -->
    <link rel="stylesheet" href="assets/css/user.css">
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
            <div class="welcome">Welcome <?= htmlspecialchars($user['name']) ?></div>
            <div class="library-info">Library Operating Hours: Monday to Saturday 9 AM to 7 PM, Sunday: Closed</div>
        </div>

        <div class="widgets-container">
            <div class="widget-card">
                <div class="widget-icon"><?= $lendedCount ?></div>
                <h3 class="widget-title">Lended Books</h3>
                <!-- <div class="widget-value"><?= $lendedCount ?></div> -->
                <p class="widget-description">Total books currently borrowed</p>
            </div>
            <div class="widget-card">
                <div class="widget-icon overdue"><?= $overdueCount ?></div>
                <h3 class="widget-title">Books overdue for return</h3>
                <!-- <div class="widget-value"><?= $overdueCount ?></div> -->
                <p class="widget-description">Total books currently borrowed</p>
            </div>
            <div class="widget-card">
                <div class="widget-icon reserved"><?= $reservedCount ?></div>
                <h3 class="widget-title">Total Books</h3>
                <!-- <div class="widget-value"><?= $reservedCount ?></div> -->
                <p class="widget-description">Total Number of Books in library</p>
            </div>
        </div>
<!-- 
        <div class="charts-row">
            <div class="chart-container">
                <div class="chart-header">
                    <h3 class="chart-title">Fines</h3>
                    <div class="chart-filter">2024</div>
                </div>
                <div class="chart-body fines-chart-body">
                    <div class="pie-chart-wrapper">
                        <div class="pie-chart-inner">100%</div>
                    </div>
                    <div class="fines-legend">
                        <div class="legend-item">
                            <div class="legend-color pending"></div>
                            ₹ <?= number_format($overdueFines, 2) ?> (<?= $overduePercent ?>%) Overdue Fines
                        </div>
                        <div class="legend-item">
                            <div class="legend-color paid"></div>
                            ₹ <?= number_format($damageFines, 2) ?> (<?= $damagePercent ?>%) Lost/Damaged Book Fines
                        </div>
                    </div>
                </div>
            </div>
            <div class="chart-container">
                <div class="chart-header">
                    <h3 class="chart-title">Lending Activity</h3>
                    <div class="chart-filter">2024</div>
                </div>
                <div class="chart-body">
                    Placeholder for Lending Activity Chart
                </div>
            </div>
        </div> -->

        <div class="new-arrivals-section">
            <div class="arrivals-header">
                <h3 class="arrivals-title">New Arrivals</h3>
                <div class="arrivals-navigation">
                    <button>&lt;</button>
                    <button>&gt;</button>
                </div>
            </div>
            <div class="arrivals-list">
            <?php
            $sql = "SELECT id, title, author, cover_image FROM books ORDER BY id DESC LIMIT 3"; // Change as needed
            $result = $conn->query($sql);
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

        echo '<div class="book-item">';
        echo '<img src="' . $cover . '" alt="' . $title . '" class="book-cover">';
        echo '<h4 class="book-title">' . $title . '</h4>';
        echo '<p class="book-author">by ' . ($author ? $author : 'Unknown') . '</p>';
        echo '<div class="book-actions">';
        echo '<a href="view.php?id=' . $book['id'] . '" class="view-book-btn">View</a>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo '<p>No books found in the library.</p>';
}
            ?>
                <!-- <div class="book-item">
                    <img src="https://via.placeholder.com/100x120/2196F3/FFFFFF?Text=Cover" alt="Tirukkural Moolam" class="book-cover">
                    <h4 class="book-title">Tirukkural Moolam - Tamil</h4>
                    <p class="book-author">Educational Books</p>
                    <button class="view-book-btn">View Book</button>
                </div> -->
            </div>
        </div>
    </div>
  </div>
    
</div>
<?php include 'includes/footer.php'; ?> 
</body>
</html>