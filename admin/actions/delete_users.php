<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userIds'])) {
    $ids = $_POST['userIds'];

    if (!empty($ids)) {
        $escaped = array_map('intval', $ids); // sanitize IDs
        $idList = implode(',', $escaped);

        // Step 1: Fetch image filenames
        $imageQuery = "SELECT profile_pic FROM users WHERE id IN ($idList)";
        $imageResult = $conn->query($imageQuery);

        if ($imageResult && $imageResult->num_rows > 0) {
            while ($row = $imageResult->fetch_assoc()) {
                if (!empty($row['profile_pic'])) {
                    $filePath = '../assets/uploadsUsers/' . $row['profile_pic'];
                    if (file_exists($filePath)) {
                        unlink($filePath); // Delete the image file
                    }
                }
            }
        }

        // Step 2: Delete the users
        $sql = "DELETE FROM users WHERE id IN ($idList)";
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