<?php
require_once '../../includes/db.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="users_export.csv"');

$output = fopen('php://output', 'w');

// Column headers
fputcsv($output, ['ID', 'User Name', 'Name', 'phone No.', 'E-mail', 'Role', 'Created Date']);

$result = $conn->query("SELECT * FROM users");

while ($row = $result->fetch_assoc()) {
    fputcsv($output, [
        $row['id'],
        $row['user_nameId'],
        $row['name'],
        $row['phone'],
        $row['email'],
        $row['role'],
        $row['created_at']
    ]);
}

fclose($output);
exit();