<?php

function generateUniqueFileName($bookId, $title, $originalFileName) {
    if (empty($originalFileName)) {
        return '';
    }

    $extension = pathinfo($originalFileName, PATHINFO_EXTENSION) ?: 'jpg';
    $cleanTitle = preg_replace("/[^a-zA-Z0-9]/", "", strtolower($title));
    $shortTitle = substr($cleanTitle, 0, 5) ?: 'book';

    return "book_" . $bookId . "_" . $shortTitle . "." . $extension;
}

function generateISBN($conn) {
    $result = $conn->query("SELECT isbn FROM books WHERE isbn LIKE 'LMS-B0-%' ORDER BY id DESC LIMIT 1");

    if ($result && $row = $result->fetch_assoc()) {
        $lastIsbn = $row['isbn'];
        $numberPart = intval(str_replace('LMS-B0-', '', $lastIsbn));
        $nextNumber = $numberPart + 1;
    } else {
        $nextNumber = 1;
    }

    return 'LMS-B0-' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);
}


?>