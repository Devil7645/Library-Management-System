<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bookIds'])) {
    $ids = $_POST['bookIds'];

    if (!empty($ids)) {
        $escaped = array_map('intval', $ids); // sanitize IDs
        $idList = implode(',', $escaped);

        // Step 1: Fetch image filenames
        $imageQuery = "SELECT cover_image FROM books WHERE id IN ($idList)";
        $imageResult = $conn->query($imageQuery);

        if ($imageResult && $imageResult->num_rows > 0) {
            while ($row = $imageResult->fetch_assoc()) {
                if (!empty($row['cover_image'])) {
                    $filePath = '../assets/uploadsBooks/' . $row['cover_image'];
                    if (file_exists($filePath)) {
                        unlink($filePath); // Delete the image file
                    }
                }
            }
        }

        // Step 2: Delete the books
        $sql = "DELETE FROM books WHERE id IN ($idList)";
        if ($conn->query($sql)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
        exit;
    }
}

echo json_encode(['success' => false, 'message' => 'No IDs provided']);
?>