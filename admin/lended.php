<?php
session_start();
include('../includes/db.php');
include('../includes/auth.php'); // Only allow admins


if (!isLoggedIn() || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}


$activePage = 'lended-books';

// Handle Return Action
if (isset($_GET['return_id'])) {
    $record_id = intval($_GET['return_id']);

    // Get book id to increase stock
    $book_sql = "SELECT book_id FROM borrow_records WHERE id = $record_id";
    $book_result = $conn->query($book_sql);
    $book = $book_result->fetch_assoc();
    $book_id = $book['book_id'];

    // Update borrow record
    $conn->query("
        UPDATE borrow_records 
        SET return_date = CURDATE(), status = 'returned' 
        WHERE id = $record_id
    ");

    // Increase available copies
    $conn->query("UPDATE books SET available_copies = available_copies + 1 WHERE id = $book_id");

    header('Location: lended.php?');
    exit();
}

// Fetch all borrows
$query = "
    SELECT br.*, u.name AS user_name, b.title AS book_title
    FROM borrow_records br
    JOIN users u ON br.user_id = u.id
    JOIN books b ON br.book_id = b.id
    ORDER BY br.borrow_date DESC
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manage Borrowed Books</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="assets/css/booksmng.css">
    <link rel="stylesheet" href="assets/css/userinfo.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

<div class="body">

    <div class="sidebar">
        <?php include 'includes/sidebar.php'; ?>
    </div>

    <main>

        <div class="header">
            <div class="breadcrumbs">
            <a href="lended.php">Borrowed Books Records</a>
            </div>
        </div>

        <div class="container">

                <?php if (isset($_GET['msg'])): ?>
                    <div class="alert"><?= htmlspecialchars($_GET['msg']) ?></div>
                <?php endif; ?>

                <table class="table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Book</th>
                            <th>Borrow Date</th>
                            <th>Due Date</th>
                            <th>Return Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['user_name']) ?></td>
                            <td><?= htmlspecialchars($row['book_title']) ?></td>
                            <td><?= $row['borrow_date'] ?></td>
                            <td><?= $row['due_date'] ?></td>
                            <td><?= $row['return_date'] ?: 'Not Returned' ?></td>
                            <td>
                                <?php
                                    if ($row['status'] == 'overdue') {
                                        echo "<span style='color:red;'>Overdue</span>";
                                    } elseif ($row['status'] == 'borrowed') {
                                        echo "<span style='color:orange;'>Borrowed</span>";
                                    } else {
                                        echo "<span style='color:green;'>Returned</span>";
                                    }
                                ?>
                            </td>
                            <td>
                                <?php if ($row['status'] == 'borrowed' || $row['status'] == 'overdue'): ?>
                                    <a href="?return_id=<?= $row['id'] ?>" onclick="return confirm('Mark as returned?');">Mark Returned</a>
                                <?php else: ?>
                                    Returned
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>

            </div>
        </main>
    </div>
</body>
</html>