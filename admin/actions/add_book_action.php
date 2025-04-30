<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once '../../includes/db.php';
require_once '../../includes/auth.php';
require_once '../includes/utility.php';

if (!isLoggedIn() || $_SESSION['role'] !== 'admin') {
    header("Location: ../../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Handle file upload
    if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['cover_image']['tmp_name'];
        $fileName = $_FILES['cover_image']['name'];
        $destination = '../assets/uploadsBooks/' . basename($fileName);

        if (move_uploaded_file($fileTmpPath, $destination)) {
            $cover_image = $fileName;
        } else {
            $cover_image = '';
        }
    } else {
        $cover_image = '';
    }

    // Collect form data
    $title = $_POST['title'] ?? '';
    $author = $_POST['author'] ?? '';
    $isbn = $_POST['isbn'] ?? '';
    $category = $_POST['category'] ?? '';
    $language = $_POST['language'] ?? '';
    $availableCopies = intval($_POST['available_copies'] ?? 0);
    $totalCopies = intval($_POST['total_copies'] ?? 1);
    $shelfCode = $_POST['shelf_code'] ?? '';
    $status = $_POST['status'] ?? 'Available';
    $totalPages = intval($_POST['total_pages'] ?? 0);
    $features = $_POST['features'] ?? '';
    $volume = $_POST['volume'] ?? '';
    $publisherName = $_POST['publisher_name'] ?? '';
    $publishedDate = !empty($_POST['published_date']) ? $_POST['published_date'] : null;
    $moral = $_POST['moral'] ?? '';

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO books 
        (title, author, isbn, category, language, copies, available_copies, shelf_code, status, total_pages, features, volume, publisher_name, published_date, moral, cover_image)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sssssiississssss", 
        $title, $author, $isbn, $category, $language,
        $totalCopies, $availableCopies, $shelfCode, $status,
        $totalPages, $features, $volume, $publisherName,
        $publishedDate, $moral, $cover_image
    );

    if ($stmt->execute()) {
        $bookId = $conn->insert_id;

        if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
            $newFileName = generateUniqueFileName($bookId, $title, $_FILES['cover_image']['name']);
            $destination = '../assets/uploadsBooks/' . $newFileName;

            if (move_uploaded_file($_FILES['cover_image']['tmp_name'], $destination)) {
                $updateStmt = $conn->prepare("UPDATE books SET cover_image = ? WHERE id = ?");
                $updateStmt->bind_param("si", $newFileName, $bookId);
                $updateStmt->execute();
                $updateStmt->close();
            }
        }

        header("Location: ../manage-books.php");
        exit();
    } else {
        echo "Error executing query: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

} else {
    header("Location: ../add_books.php");
    exit();
}
?>