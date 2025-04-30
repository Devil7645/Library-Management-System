<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once '../includes/db.php';
require_once '../includes/auth.php';
require_once 'includes/utility.php';

if (!isLoggedIn() || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}


$autoISBN = generateISBN($conn);

$activePage = 'manage-books';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="assets/css/admin.css">
    <!-- <link rel="stylesheet" href="assets/css/booksmng.css"> -->
    <link rel="stylesheet" href="assets/css/form.css">
    <!-- Flatpickr CSS -->
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
                <span>Add Book</span>
            </div>

            <div class="container">
                    <h3>Book Information</h3>

                    <form action="actions/add_book_action.php" method="post" enctype="multipart/form-data">
                        <div class="form-section">
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="bookTitle">Book title <span>*</span></label>
                                    <input type="text" name="title" id="bookTitle" placeholder="Book name here" required>
                                </div>
                                <div class="form-group">
                                    <label for="author">Author(s) <span>*</span></label>
                                    <input type="text" name="author" id="author" placeholder="Author name here"required>
                                </div>
                                <div class="form-group">
                                    <label for="isbn">ISBN/ISSN</label>
                                    <input type="text" name="isbn" id="isbn" placeholder="ISBN here" value="<?= htmlspecialchars($autoISBN) ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="genre">Genre/category</label>
                                    <select name="category" id="genre">
                                        <optgroup label="Fiction">
                                            <option value="action_adventure">Action & Adventure</option>
                                            <option value="childrens">Children's</option>
                                            <option value="contemporary_fiction">Contemporary</option>
                                            <option value="dystopian_fiction">Dystopian</option>
                                            <option value="fantasy">Fantasy</option>
                                            <option value="historical_fiction">Historical Fiction</option>
                                            <option value="horror_fiction">Horror</option>
                                            <option value="lgbtq_fiction">LGBTQ+</option>
                                            <option value="literary_fiction">Literary Fiction</option>
                                            <option value="mystery_fiction">Mystery</option>
                                            <option value="paranormal_fiction">Paranormal</option>
                                            <option value="romance_fiction">Romance</option>
                                            <option value="science_fiction">Science Fiction</option>
                                            <option value="short_story">Short Story</option>
                                            <option value="thriller_suspense">Thriller & Suspense</option>
                                            <option value="young_adult">Young Adult (YA)</option>
                                            <option value="graphic_novel">Graphic Novel</option>
                                            <option value="satire_fiction">Satire</option>
                                            <option value="western_fiction">Western</option>
                                            <option value="war_fiction">War Fiction</option>
                                        </optgroup>
                                        <optgroup label="Non-Fiction">
                                            <option value="autobiography_memoir">Autobiography & Memoir</option>
                                            <option value="biography_nonfiction">Biography</option>
                                            <option value="essays_nonfiction">Essays</option>
                                            <option value="history_nonfiction">History</option>
                                            <option value="self_help">Self-Help</option>
                                            <option value="travel_nonfiction">Travel</option>
                                            <option value="true_crime">True Crime</option>
                                            <option value="art_photography">Art & Photography</option>
                                            <option value="cookbooks_nonfiction">Cookbooks</option>
                                            <option value="crafts_hobbies">Crafts & Hobbies</option>
                                            <option value="family_parenting">Family & Parenting</option>
                                            <option value="health_fitness">Health & Fitness</option>
                                            <option value="humor_nonfiction">Humor</option>
                                            <option value="politics_social_sciences">Politics & Social Sciences</option>
                                            <option value="religion_spirituality">Religion & Spirituality</option>
                                            <option value="science_technology">Science & Technology</option>
                                            <option value="poetry_nonfiction">Poetry</option>
                                            <option value="drama_plays">Drama/Plays</option>
                                            <option value="reference_manuals">Reference & Manuals</option>
                                            <option value="education_textbooks">Education/Textbooks</option>
                                            <option value="philosophy_nonfiction">Philosophy</option>
                                        </optgroup>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="language">Language <span>*</span></label>
                                    <select name="language" id="language">
                                        <option>English</option>
                                        <option>Hindi</option>
                                        <option>Tamil</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="availableCopies">Available Copies</label>
                                    <input type="number" name="available_copies" id="availableCopies" placeholder="Available Copies here">
                                </div>
                                <div class="form-group">
                                    <label for="totalCopies">Total Copies <span>*</span></label>
                                    <input type="number" name="total_copies" id="totalCopies">
                                </div>
                                <div class="form-group">
                                    <label for="shelfCode">Shelf/Location Code</label>
                                    <input type="text" name="shelf_code" id="shelfCode" placeholder="Shelf/Location Code here">
                                </div>
                                <div class="form-group">
                                    <label for="status">Status <span>*</span></label>
                                    <div class="radio-group">
                                        <label><input type="radio" name="status" value="Available" checked> Available</label>
                                        <label><input type="radio" name="status" value="Lended"> Reserved</label>
                                        <label><input type="radio" name="status" value="Damaged"> Out of Stock</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="totalPages">Total no of Pages <span>*</span></label>
                                    <input type="number" name="total_pages" id="totalPages" placeholder="10 to 10,000">
                                </div>
                                <div class="form-group">
                                    <label for="cover_image">File Attachment</label>
                                    <!-- Wrap the file-upload div in a label -->
                                    <label class="file-upload" for="cover_image">
                                        <svg viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M9 16h6v-6h4l-7-7l-7 7h4zm-4 2h14v2H5zm12-10v7h-2v-7h-4l6-6l6 6h-4z"/>
                                        </svg>
                                        <span style="color: #777;" id="file-name">Choose a file</span>
                                    </label>
                                    <!-- Keep the input outside, but connected via 'for' attribute -->
                                    <input type="file" name="cover_image" id="cover_image" accept="image/jpeg, image/png, image/gif" style="display: none;">
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <h3>Features Information</h3>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="bookFeatures">Book Features <span>*</span></label>
                                    <input type="text" name="features" placeholder="Hard Cover, etc">
                                </div>
                                <div class="form-group">
                                    <label for="bookVolume">Book Volume</label>
                                    <input type="text" name="volume" id="bookVolume" placeholder="None">
                                </div>
                                <div class="form-group">
                                    <label for="publisherName">Publisher Name</label>
                                    <input type="text" name="publisher_name" id="publisherName" placeholder="Publisher name here">
                                </div>
                                <div class="form-group">
                                    <label for="bookPublishedDate">Book Published Date</label>
                                    <input type="text" name="published_date" id="bookPublishedDate" placeholder="29-Oct-1950">
                                </div>
                                <div class="form-group">
                                    <label for="bookmoral">Moral (If any)</label>
                                    <input type="text" name="moral" id="bookMoral" placeholder="What You think?">
                                </div>
                                <div></div> <div></div> </div>
                        </div>

                        <div class="form-actions">
                            <button onclick="window.location.href='manage-books.php'">Cancel</button>
                            <button type="submit" name="submit">Add Book</button>
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
                fileNameDisplay.textContent = 'Choose a file'; // Reset display
            } else {
                fileNameDisplay.textContent = file.name;
            }
        }
    });
    
    flatpickr("#bookPublishedDate", {
        dateFormat: "d-M-Y", // Example: 29-Oct-1950
        maxDate: "today"     // Optional: restrict future dates
    });
    
    </script>
</body>

</html>
