<?php 
session_start();
include('includes/db.php');
include('includes/auth.php'); // Only allow logged in users

if (!isLoggedIn() || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user = $conn->query("SELECT * FROM users WHERE id = $user_id")->fetch_assoc();

if (isset($_POST['update_profile'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);

    if (!empty($_FILES['profile_photo']['name'])) {
        $photo_name = time() . '_' . basename($_FILES['profile_photo']['name']);
        $photo_db_path = 'admin/assets/uploads/profile_photos/' . $photo_name;
        $target_path = $photo_db_path;

        if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $target_path)) {
            $conn->query("UPDATE users SET profile_photo='$photo_db_path' WHERE id=$user_id");
        } else {
            echo "<script>alert('Image upload failed. Check folder permissions.');</script>";
        }
    }

    $update = $conn->query("UPDATE users SET name='$name', email='$email', phone='$phone' WHERE id=$user_id");

    if ($update) {
        $_SESSION['user_name'] = $name;
        header('Location: my_account.php?msg=Profile updated successfully!');
        exit();
    } else {
        die('Error updating profile.');
    }
}

 
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


        <?php if (isset($_GET['msg'])): ?>
            <div class="alert"><?= htmlspecialchars($_GET['msg']) ?></div>
        <?php endif; ?>

        <div class="user-info-container">
            <img src="<?= $user['profile_photo'] ? htmlspecialchars($user['profile_photo']) : 'assets/images/default-user.jpeg' ?>" 
                 alt="Profile Photo" class="profile-photo">

                <div>
                    <p><strong>User ID:</strong> <?= htmlspecialchars($user['user_nameId']) ?></p>
                </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Name:</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Phone:</label>
                    <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>">
                </div>
                <div class="form-group">
                    <label>Profile Photo:</label>
                    <input type="file" name="profile_photo" accept="image/*">
                </div>
                <button class="edit-button" type="submit" name="update_profile">Update Profile</button>
            </form>

            <div class="user-meta">
                <p><strong>Fine Due:</strong> ₹<?= number_format($user['fine'], 2) ?></p>
            </div>
        </div>

        <h2 class="section-header">Borrowed Books</h2>
        <div class="book-list">
        <?php
        $user_id = $_SESSION['user_id'];

        // Fetch books borrowed by the user
        $sql = "SELECT 
                    b.title, b.author, b.cover_image,
                    br.borrow_date, br.due_date, br.return_date
                FROM borrow_records br
                JOIN books b ON br.book_id = b.id
                WHERE br.user_id = $user_id
                ORDER BY br.borrow_date DESC";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($book = $result->fetch_assoc()) {
                $title = htmlspecialchars($book['title']);
                $author = htmlspecialchars($book['author']);
                $cover = $book['cover_image'] ? 'admin/assets/uploadsBooks/' . $book['cover_image'] : 'assets/images/default-book.jpg';

                $borrowDate = date('d M Y', strtotime($book['borrow_date']));
                $dueDate = $book['due_date'] ? date('d M Y', strtotime($book['due_date'])) : 'N/A';
                $isReturned = $book['return_date'] ? true : false;
                $returnDate = $isReturned ? date('d M Y', strtotime($book['return_date'])) : null;

                echo '<div class="book-card">';
                echo '<img src="' . $cover . '" alt="' . $title . '" class="book-cover">';
                echo '<h2 class="book-title">' . $title . '</h2>';
                echo '<p class="book-author">by ' . ($author ? $author : 'Unknown') . '</p>';
                echo '<p class="borrow-date">Borrowed: ' . $borrowDate . '</p>';
                echo '<p class="due-date">Due: ' . $dueDate . '</p>';

                if ($isReturned) {
                    echo '<p class="return-status returned">Returned on: ' . $returnDate . '</p>';
                } else {
                    echo '<p class="return-status not-returned">Not Returned</p>';
                }

                echo '<div class="book-actions">';
                echo '<a href="#" class="view-book-btn">View</a>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>You have not borrowed any books Yet.</p>';
        }
        ?>
        </div>

    </div>

  </div>
    
</div>
<?php include 'includes/footer.php'; ?> 
</body>
</html>