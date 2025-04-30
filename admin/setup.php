<?php
require_once '../includes/db.php';

$admin_email = 'devil1@gmail.com';
$admin_password = password_hash('123', PASSWORD_DEFAULT);
$name = 'Punit';
$phone = '9999999999';

// Check if admin already exists
$sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $admin_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Create admin
    $sql = "INSERT INTO users (name, phone, email, password, role) VALUES (?, ?, ?, ?, 'admin')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $phone, $admin_email, $admin_password);

    if ($stmt->execute()) {
        echo "✅ Admin account created: Email: <strong>$admin_email</strong> | Password: <strong>123</strong><br>";
    } else {
        echo "❌ Failed to create admin!";
    }
} else {
    echo "⚠️ Admin already exists.";
}
echo "<a href='../login.php'>Log In</a>";

?>
