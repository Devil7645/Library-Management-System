<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../includes/db.php';
require_once '../includes/auth.php';
require_once 'includes/utility.php';

if (!isLoggedIn() || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "No book ID provided.";
    exit;
}

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM books WHERE id = $id");

if ($result->num_rows === 0) {
    echo "Book not found.";
    exit;
}

$book = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle file upload
    // if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
    //     $fileTmpPath = $_FILES['cover_image']['tmp_name'];
    //     $fileName = $_FILES['cover_image']['name'];
    //     $destination = '../assets/uploadsBooks/' . basename($fileName);

    //     if (move_uploaded_file($fileTmpPath, $destination)) {
    //         $cover_image = $fileName;
    //     } else {
    //         $cover_image = $book['cover_image'];
    //         // $cover_image = '';
    //     }
    // } else {
    //     $cover_image = $book['cover_image'];
    //     // $cover_image = '';
    // }


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
    $publishedDate = date('Y-m-d', strtotime($publishedDate));
    $moral = $_POST['moral'] ?? '';

//     echo "<pre>";
// print_r($_FILES['cover_image']);
// echo "</pre>";
// exit;

    // ✅ Handle cover image upload (fix: retain old image if no new file uploaded)
    if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['cover_image']['tmp_name'];
        $fileName = $_FILES['cover_image']['name'];
        $destination = 'assets/uploadsBooks/' . basename($fileName);

        if (move_uploaded_file($fileTmpPath, $destination)) {
            $cover_image = $fileName;
        } else {
            $cover_image = $book['cover_image']; // fallback to existing image
        }
    } else {
        $cover_image = $book['cover_image']; // keep old image
    }

    // Prepare and bind
    $stmt = $conn->prepare("UPDATE books SET 
    title = ?, author = ?, isbn = ?, category = ?, language = ?, copies = ?, available_copies = ?, 
    shelf_code = ?, status = ?, total_pages = ?, features = ?, volume = ?, publisher_name = ?, 
    published_date = ?, moral = ?, cover_image = ?
    WHERE id = ?");

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sssssiississssssi", 
        $title, $author, $isbn, $category, $language,
        $totalCopies, $availableCopies, $shelfCode, $status,
        $totalPages, $features, $volume, $publisherName,
        $publishedDate, $moral, $cover_image, $id
    );

    if ($stmt->execute()) {
        // $bookId = $conn->insert_id;

        // if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
        //     $newFileName = generateUniqueFileName($bookId, $title, $_FILES['cover_image']['name']);
        //     $destination = '../assets/uploadsBooks/' . $newFileName;

        //     if (move_uploaded_file($_FILES['cover_image']['tmp_name'], $destination)) {
        //         $updateStmt = $conn->prepare("UPDATE books SET cover_image = ? WHERE id = ?");
        //         $updateStmt->bind_param("si", $newFileName, $bookId);
        //         $updateStmt->execute();
        //         $updateStmt->close();
        //     }
        // }

        header("Location: book_details.php?id=$id&updated=1");
        exit();
    } else {
        echo "Error executing query: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}


$activePage = 'manage-books';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Book - <?= htmlspecialchars($book['title']?? '') ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="assets/css/admin.css">
    <!-- <link rel="stylesheet" href="assets/css/booksmng.css"> -->
    <link rel="stylesheet" href="assets/css/form.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <div class="body">

        <div class="sidebar">
            <?php include 'includes/sidebar.php'; ?>
        </div>
        
        <main class="main">

            <div class="breadcrumbs">
                <a href="manage-books.php">Manage Books</a>
                <span>></span>
                <a href="book_details.php?id=<?= htmlspecialchars($book['id']) ?>"><?= htmlspecialchars($book['title']) ?></a>
                <span>></span>
                <span>Editing</span>
            </div>
            <div class="container">
                    <h3>Book Information</h3>


                    <div class="cover-img" >
                        <!-- book cover image here -->
                         <img src="assets/uploadsBooks/<?= htmlspecialchars($book['cover_image']) ?>" alt="Book Cover">
                    </div>

                    <form method="post" enctype="multipart/form-data">
                        <div class="form-section">
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="bookTitle">Book title <span>*</span></label>
                                    <input type="text" name="title" placeholder="Book name here" value="<?= htmlspecialchars($book['title']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="author">Author(s) <span>*</span></label>
                                    <input type="text" name="author" placeholder="Author name here" value="<?= htmlspecialchars($book['author'] ?? '') ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="isbn">ISBN/ISSN</label>
                                    <input type="text" name="isbn" placeholder="ISBN here" value="<?= htmlspecialchars($book['isbn'] ?? '') ?>">
                                </div>
                                <div class="form-group">
                                    <label for="genre">Genre/category</label>
                                    <input type="text" name="category" placeholder="Category here" value="<?= htmlspecialchars($book['category'] ?? '') ?>">
                                </div>
                                <div class="form-group">
                                    <label for="language">Language <span>*</span></label>
                                    <input type="text" name="language" placeholder="language here" value="<?= htmlspecialchars($book['language'] ?? '') ?>">
                                </div>
                                <div class="form-group">
                                    <label for="availableCopies">Available Copies</label>
                                    <input type="number" name="available_copies" placeholder="Available Copies here" value="<?= htmlspecialchars($book['available_copies'] ?? '') ?>">
                                </div>
                                <div class="form-group">
                                    <label for="totalCopies">Total Copies <span>*</span></label>
                                    <input type="number" name="total_copies" value="<?= htmlspecialchars($book['copies'] ?? '') ?>">
                                </div>
                                <div class="form-group">
                                    <label for="shelfCode">Shelf/Location Code</label>
                                    <input type="text" name="shelf_code" placeholder="Shelf/Location Code here" value="<?= htmlspecialchars($book['shelf_code'] ?? '') ?>">
                                </div>
                                <div class="form-group">
                                    <label for="status">Status <span>*</span></label>
                                    <div class="radio-group">
                                        <label>
                                            <input type="radio" name="status" value="Available" <?= $book['status'] === 'Available' ? 'checked' : '' ?>>
                                            Available
                                        </label>

                                        <label>
                                            <input type="radio" name="status" value="Lended" <?= $book['status'] === 'Lended' ? 'checked' : '' ?>>
                                            Lended
                                        </label>

                                        <label>
                                            <input type="radio" name="status" value="Damaged" <?= $book['status'] === 'Damaged' ? 'checked' : '' ?>>
                                            Damaged
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="totalPages">Total no of Pages <span>*</span></label>
                                    <input type="number" name="total_pages" placeholder="10 to 10,000" value="<?= htmlspecialchars($book['total_pages'] ?? '') ?>">
                                </div>
                                <div class="form-group">
                                    <label for="cover_image">File Attachment</label>
                                    <label class="file-upload" for="cover_image" style="cursor: pointer;">
                                        <!-- Icon as a link to open current file -->
                                        <?php if (!empty($book['cover_image'])): ?>
                                            <a href="assets/uploadsBooks/<?= $book['cover_image'] ?>" target="_blank" title="View current cover">
                                                <svg viewBox="0 0 24 24">
                                                    <path fill="currentColor" d="M9 16h6v-6h4l-7-7l-7 7h4zm-4 2h14v2H5zm12-10v7h-2v-7h-4l6-6l6 6h-4z"/>
                                                </svg>
                                            </a>
                                        <?php else: ?>
                                            <svg viewBox="0 0 24 24">
                                                <path fill="currentColor" d="M9 16h6v-6h4l-7-7l-7 7h4zm-4 2h14v2H5zm12-10v7h-2v-7h-4l6-6l6 6h-4z"/>
                                            </svg>
                                        <?php endif; ?>
                                        <span id="file-name"><?= isset($book['cover_image']) && $book['cover_image'] ? $book['cover_image'] : 'Choose a file' ?></span>
                                    </label>
                                    <input type="file" name="cover_image" id="cover_image" accept="image/jpeg, image/png, image/gif" style="display: none;">
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <h3>Features Information</h3>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="bookFeatures">Book Features <span>*</span></label>
                                    <input type="text" name="features" placeholder="Hard Cover, etc" value="<?= htmlspecialchars($book['features'] ?? '') ?>">
                                </div>
                                <div class="form-group">
                                    <label for="bookVolume">Book Volume</label>
                                    <input type="text" name="volume" placeholder="None" value="<?= htmlspecialchars($book['volume'] ?? '') ?>">
                                </div>
                                <div class="form-group">
                                    <label for="publisherName">Publisher Name</label>
                                    <input type="text" name="publisher_name" placeholder="Publisher name here" value="<?= htmlspecialchars($book['publisher_name'] ?? '') ?>">
                                </div>
                                <div class="form-group">
                                    <label for="bookPublishedDate">Book Published Date</label>
                                    <input type="text" name="published_date" id="bookPublishedDate" placeholder="29-Oct-1950"
                                        value="<?= isset($book['published_date']) ? date('Y-M-d', strtotime($book['published_date'] ?? '')) : '' ?>">
                                </div>
                                <div class="form-group">
                                    <label for="bookmoral">Moral (If any)</label>
                                    <input type="text" name="moral" placeholder="What You think?" value="<?= htmlspecialchars($book['moral'] ?? '') ?>">
                                </div>
                                <div></div> <div></div> </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" onclick="window.location.href='book_details.php?id=<?= $id ?>'">Cancel</button>
                            <button type="submit">Update Book</button>
                        </div>
                    </form>
            </div>
        </main>
    </div>
    <?php include 'includes/footer.php' ?>
    <script>
    document.getElementById('cover_image').addEventListener('change', function () {
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        const file = this.files[0];
        const fileNameDisplay = document.getElementById('file-name');

        if (file) {
            if (!allowedTypes.includes(file.type)) {
                alert("❌ Invalid image format! Only JPG, PNG, or GIF allowed.");
                this.value = ''; // Clear the input
                fileNameDisplay.textContent = 'Choose a file'; // Reset label
            } else {
                fileNameDisplay.textContent = file.name;
            }
        }
    });

    <!-- Initialize Flatpickr -->
    flatpickr("#bookPublishedDate", {
        dateFormat: "Y-M-d",
        maxDate: "today"
    });
    </script>
</body>

</html>
