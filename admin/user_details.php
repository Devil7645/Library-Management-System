<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

if (!isLoggedIn() || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$userCondition = '';

if (isset($_GET['user'])) {
    $username = $conn->real_escape_string($_GET['user']);
    $userCondition = "u.user_nameId = '$username'";
} elseif (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $userCondition = "u.id = $id";
} else {
    die("User not specified.");
}

$query = "
    SELECT u.name, u.email, u.phone, u.role, u.user_nameId, u.profile_photo,
           b.title, br.borrow_date, br.due_date, br.return_date,
           CASE 
               WHEN br.return_date IS NULL AND br.due_date < CURDATE() THEN DATEDIFF(CURDATE(), br.due_date) * 10
               ELSE 0
           END AS fine
    FROM users u
    LEFT JOIN borrow_records br ON u.id = br.user_id
    LEFT JOIN books b ON br.book_id = b.id
    WHERE $userCondition
    ORDER BY br.borrow_date DESC
";

$result = $conn->query($query);

$userInfo = null;
$borrowHistory = [];

while ($row = $result->fetch_assoc()) {
    if (!$userInfo) {
        $userInfo = [
            'name' => $row['name'],
            'user_nameId' => $row['user_nameId'],
            'email' => $row['email'],
            'phone' => $row['phone'],
            'role' => $row['role'],
            'profile_photo' => $row['profile_photo'],
        ];
    }

    if ($row['title']) {
        $borrowHistory[] = $row;
    }
}


$activePage = 'members'; // For sidebar
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Details - <?= $username ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="assets/css/admin.css">
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
                    <a href="members.php">Member</a>
                    <span>></span>
                    User Details
                    <span>></span>
                    <span><?= htmlspecialchars($userInfo['name']) ?></span>
                </div>
                <a href="edit-user.php?id=<?= $userInfo['id'] ?? '' ?>" class="edit-button">Edit User</a>

            </div>

            <div class="container">
        

            <h1><?= htmlspecialchars($userInfo['profile_photo']) ?></h1>



            <?php
            $defaultPhoto = '../assets/images/default-user.jpeg'; // fallback photo
            // $profilePhoto = !empty($user['profile_photo']) ?  $user['profile_photo'] : $defaultPhoto;
           
            // $defaultPhoto = '../assets/images/default-user.jpeg';
            // $profilePhoto = (!empty($user['profile_photo']) && file_exists($user['profile_photo']))
            //     ? $user['profile_photo']
            //     : $defaultPhoto;
            $photoPath = '' . ltrim($userInfo['profile_photo'] ?? '', '/');
            $profilePhoto = (!empty($userInfo['profile_photo']) && file_exists($photoPath))
                ? $photoPath
                : $defaultPhoto;
            ?>
            <img src="<?= $profilePhoto ?>" alt="Profile Photo" class="profile-photo">

            <?php if ($userInfo): ?>
                <div class="userinfo">
                    <div class="info">
                        <p><strong>Name:</strong> <?= $userInfo['name'] ?></p>
                    </div>
                    <div class="info">
                        <p><strong>User Name:</strong> <?= $userInfo['user_nameId'] ?></p>
                    </div>
                    <div class="info">
                        <p><strong>Email:</strong> <?= $userInfo['email'] ?></p>
                    </div>
                    <div class="info">
                        <p><strong>Phone:</strong> <?= $userInfo['phone'] ?></p>
                    </div>
                    <div class="info">
                        <p><strong>Role:</strong> <?= ucfirst($userInfo['role']) ?></p>
                    </div>
                </div>
            </div>
            <div class="history">
                <h3>Borrow History</h3>
                <?php if (count($borrowHistory) > 0): ?>
                    <table border="1" cellpadding="10">
                        <thead>
                            <tr>
                                <th>Book Title</th>
                                <th>Borrow Date</th>
                                <th>Due Date</th>
                                <th>Return Date</th>
                                <th>Fine</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($borrowHistory as $borrow): ?>
                                <tr>
                                    <td><?= $borrow['title'] ?></td>
                                    <td><?= $borrow['borrow_date'] ?></td>
                                    <td><?= $borrow['due_date'] ?></td>
                                    <td><?= $borrow['return_date'] ?? 'Not Returned' ?></td>
                                    <td>₹<?= $borrow['fine'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No borrow history.</p>
                <?php endif; ?>

            <?php else: ?>
                <p>User not found.</p>
            <?php endif; ?>
            </div>
        </main>
    </div>

    <?php include 'includes/footer.php' ?>
    
</body>


<body>


</body>
</html>