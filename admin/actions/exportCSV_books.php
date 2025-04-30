<?php
require_once '../../includes/db.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="books_export.csv"');

$output = fopen('php://output', 'w');

// Column headers
fputcsv($output, ['ID', 'Title', 'Author', 'Category', 'Language', 'Copies', 'Status']);

$result = $conn->query("SELECT * FROM books");

while ($row = $result->fetch_assoc()) {
    fputcsv($output, [
        $row['id'],
        $row['title'],
        $row['author'],
        $row['category'],
        $row['language'],
        $row['copies'],
        $row['status']
    ]);
}

fclose($output);
exit();