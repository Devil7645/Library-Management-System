<?php
session_start();
include('../includes/db.php');
include('../includes/auth.php'); // Only allow users


if (!isLoggedIn() || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Fetch admin details
$admin_id = $_SESSION['user_id'];
$admin = $conn->query("SELECT * FROM users WHERE id = $admin_id AND role = 'admin'")->fetch_assoc();

// Fetch Library Settings
$settings = [];
$settings_query = $conn->query("SELECT * FROM settings");
while ($row = $settings_query->fetch_assoc()) {
    $settings[$row['name']] = $row['value'];
}

// Handle Profile Update
if (isset($_POST['update_profile'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);

    // Handle Profile Photo Upload
    if (!empty($_FILES['profile_photo']['name'])) {
        $photo_name = time() . '_' . basename($_FILES['profile_photo']['name']);
        $photo_db_path = 'assets/uploads/profile_photos/' . $photo_name; // For DB and <img>
        $target_path = '' . $photo_db_path; // For file upload from /admin/
    
        if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $target_path)) {
            $conn->query("UPDATE users SET profile_photo='$photo_db_path' WHERE id=$admin_id");
        }
    } else {
        die('Failed to upload image. Check folder permissions and path.');
    }

    $update = $conn->query("UPDATE users SET name='$name', email='$email' WHERE id=$admin_id");

    if ($update) {
        $_SESSION['admin_name'] = $name; // Update session
        header('Location: settings.php?msg=Profile updated successfully! To Take change you may need to logOut');
        exit();
    } else {
        die('Error updating profile.');
    }
}

// Handle Library Rules Update
if (isset($_POST['update_rules'])) {
    $borrow_days = (int)$_POST['borrow_days'];
    $fine_per_day = (float)$_POST['fine_per_day'];

    $conn->query("UPDATE settings SET value='$borrow_days' WHERE name='borrow_days'");
    $conn->query("UPDATE settings SET value='$fine_per_day' WHERE name='fine_per_day'");

    header('Location: settings.php?msg=Library rules updated successfully!');
    exit();
}


$activePage = 'settings';

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
    <link rel="stylesheet" href="assets/css/settings.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

<div class="body">

    <div class="sidebar">
        <?php include 'includes/sidebar.php'; ?>
    </div>

    <main>

        <div>
            <div class="breadcrumbs">
            <a href="settings.php">Settings</a>
            </div>
        </div>

        <div class="container">

            <?php if (isset($_GET['msg'])): ?>
                <div class="alert"> <?= htmlspecialchars($_GET['msg']) ?> </div>
            <?php endif; ?>

            <h2>Profile Settings</h2>
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Name:</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($admin['name']) ?>" required>
                </div>

                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($admin['email']) ?>" required>
                </div>

                <div class="form-group">
                    <label>Profile Photo:</label>
                    <input type="file" name="profile_photo" accept="image/jpeg, image/png, image/gif">
                    <?php if (!empty($admin['profile_photo'])): ?>
                        <br><img src="<?= htmlspecialchars($admin['profile_photo']) ?>" width="100" style="margin-top: 10px;">
                    <?php endif; ?>
                </div>

                <button type="submit" name="update_profile">Update Profile</button>
            </form>

            <br><hr><br>

            <h2>Library Rules</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label>Borrow Days:</label>
                    <input type="number" name="borrow_days" value="<?= htmlspecialchars($settings['borrow_days']) ?>" required>
                </div>

                <div class="form-group">
                    <label>Fine Per Day (in Rs):</label>
                    <input type="number" step="0.01" name="fine_per_day" value="<?= htmlspecialchars($settings['fine_per_day']) ?>" required>
                </div>

                <button type="submit" name="update_rules">Update Library Rules</button>
            </form>
        </div>
    </main>
    
</div>
</body>
</html>