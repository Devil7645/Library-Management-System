<?php
session_start();
include('../includes/db.php');
include('../includes/auth.php'); // Only allow admins


if (!isLoggedIn() || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = intval($_POST['user_id']);
    $book_id = intval($_POST['book_id']);
    $borrow_date = date('Y-m-d');
    $due_date = date('Y-m-d', strtotime('+15 days'));

    // Check if book has available copies
    $book_check = $conn->query("SELECT available_copies FROM books WHERE id = $book_id");
    if ($book_check->num_rows == 0) {
        die('Book not found.');
    }
    $book = $book_check->fetch_assoc();
    if ($book['available_copies'] <= 0) {
        die('No available copies for this book.');
    }

    // Insert into borrow_records
    $insert = $conn->query("
        INSERT INTO borrow_records (user_id, book_id, borrow_date, due_date, status)
        VALUES ($user_id, $book_id, '$borrow_date', '$due_date', 'borrowed')
    ");

    if ($insert) {
        // Reduce book copies
        $conn->query("UPDATE books SET available_copies = available_copies - 1 WHERE id = $book_id");

        header('Location: lend_book.php?msg=Book successfully lent!');
        exit();
    } else {
        die('Error lending book.');
    }
}

// Fetch all users and books for the dropdown
$users = $conn->query("SELECT id, name FROM users ORDER BY name ASC");
$books = $conn->query("SELECT id, title FROM books WHERE available_copies > 0 ORDER BY title ASC");


$activePage = 'lend';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lend a Book</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="assets/css/booksmng.css">
    <link rel="stylesheet" href="assets/css/lendaBook.css">
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
                <a href="lend.php">Lend a Book</a>
                </div>
            </div>

            <div class="container">


                <?php if (isset($_GET['msg'])): ?>
                    <div class="alert"><?= htmlspecialchars($_GET['msg']) ?></div>
                <?php endif; ?>

                <form method="POST" action="lend_book.php">
                    <div class="form-group">
                        <label for="user_id">Select User:</label>
                        <select name="user_id" id="user_id" required>
                            <option value="">-- Select User --</option>
                            <?php while ($user = $users->fetch_assoc()): ?>
                                <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['name']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="book_id">Select Book:</label>
                        <select name="book_id" id="book_id" required>
                            <option value="">-- Select Book --</option>
                            <?php while ($book = $books->fetch_assoc()): ?>
                                <option value="<?= $book['id'] ?>"><?= htmlspecialchars($book['title']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <button type="submit">Lend Book</button>
                </form>

            </div>
        </main>
    </div>
</body>
</html>