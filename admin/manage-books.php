<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/auth.php';

if (!isLoggedIn() || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}


$activePage = 'manage-books';

// Pagination logic
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Total records
$totalResult = $conn->query("SELECT COUNT(*) as total FROM books");
$totalRow = $totalResult->fetch_assoc();
$totalBooks = $totalRow['total'];
$totalPages = ceil($totalBooks / $limit);


// Get current page records
$result = $conn->query("SELECT * FROM books LIMIT $limit OFFSET $offset");
// $result = $conn->query("SELECT * FROM books");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="assets/css/booksmng.css">
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <div class="body">

        <div class="sidebar">
            <?php include 'includes/sidebar.php'; ?>
        </div>

        <main>
            <div class="breadcrumbs">
                <a href="manage-books.php">Manage Books</a>
            </div>
            <div class="container">
                <div class="toolbar">
                    <div class="search-bar">
                        <span class="search-icon">&#x1F50D;</span>
                        <input type="text" id="searchInput" class="search-input" placeholder="Search books"
                            onkeyup="filterBooks()">
                    </div>
                    <div class="actions">
                        <button class="add-button" onclick="window.location.href='add_books.php'">+ Add Books</button>
                        <div class="actions dropdown">
                            <button class="actions-button" onclick="toggleDropdown()">Actions ▾</button>
                            <div class="dropdown-content" id="actionsDropdown">
                                <a href="#" onclick="deleteSelected()">&#x1F6AB; Delete Selected</a>
                                <a href="actions/exportCSV_books.php" onclick="exportCSV()">&#x1F4E4; Export to CSV</a>
                                <a href="#" onclick="exportPDF()">&#x1F4E4; Export to PDF</a>
                                <a href="javascript:window.print()">&#x1F5A8; Print List</a>
                                <a href="#" onclick="importBooks()">&#x1F4E5; Import Books</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <table class="table" id="booksTable"> 
                    <thead>
                        <tr>
                            <th><input type="checkbox" onclick="toggleAll(this)"></th>
                            <th class="sortable">Book ISBN <span>↑↓</span></th>
                            <th class="sortable">Book Title <span>↑↓</span></th>
                            <th class="sortable">Author(s) <span>↑↓</span></th>
                            <th class="sortable">Genre/Category <span>↑↓</span></th>
                            <th class="sortable">Language <span>↑↓</span></th>
                            <th class="sortable">Total Copies <span>↑↓</span></th>
                            <th class="sortable">Status <span>↑↓</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- <tr>
                            <td><input type="checkbox"></td>
                            <td>ASP-B0-01</td>
                            <td>The Great Gatsby</td>
                            <td>F. Scott Fitzgerald</td>
                            <td>Fiction</td>
                            <td>English</td>
                            <td>10</td>
                            <td><span class="status-Available">Available</span></td>
                        </tr> -->
                        <?php while($row = $result->fetch_assoc()) { ?>
                        <tr data-id="<?= $row['id'] ?>">
                            <td><input type="checkbox"></td>
                            <td> <?= $row['isbn'] ?> </td>
                            <td><a href="book_details.php?id=<?= $row['id'] ?>"><?= $row['title'] ?></a></td>
                            <td> <?= $row['author'] ?> </td>
                            <td> <?= $row['category'] ?> </td>
                            <td> <?= $row['language'] ?> </td>
                            <td> <?= $row['copies'] ?> </td>
                            <td><span class="status-<?= $row['status'] ?>">
                                    <?= $row['status'] ?>
                                </span>
                            </td>
                        </tr>
                        <?php } ?>

                    </tbody>
                </table>

                <div class="pagination">
                    <div>Total Books: <?= $totalBooks ?></div>
                    <div class="pagination-links">
                        <?php if ($page > 1): ?>
                            <a href="?page=1&limit=<?= $limit ?>" class="pagination-arrow">&lt;&lt;</a>
                            <a href="?page=<?= $page - 1 ?>&limit=<?= $limit ?>" class="pagination-arrow">&lt;</a>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <a href="?page=<?= $i ?>&limit=<?= $limit ?>" class="pagination-link <?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
                        <?php endfor; ?>

                        <?php if ($page < $totalPages): ?>
                            <a href="?page=<?= $page + 1 ?>&limit=<?= $limit ?>" class="pagination-arrow">&gt;</a>
                            <a href="?page=<?= $totalPages ?>&limit=<?= $limit ?>" class="pagination-arrow">&gt;&gt;</a>
                        <?php endif; ?>
                    </div>
                    <div class="show-entries"> 
                        Show 
                        <select onchange="changeLimit(this.value)">
                            <option value="5" <?= $limit == 5 ? 'selected' : '' ?>>5</option>
                            <option value="10" <?= $limit == 10 ? 'selected' : '' ?>>10</option>
                            <option value="25" <?= $limit == 25 ? 'selected' : '' ?>>25</option>
                            <option value="50" <?= $limit == 50 ? 'selected' : '' ?>>50</option>
                            <option value="100" <?= $limit == 100 ? 'selected' : '' ?>>100</option>
                        </select> entries
                    </div>
                </div>
            </div>
        </main>
    </div>

    <?php include 'includes/footer.php' ?>

    <script>
        // JS search function.
        function filterBooks() {
            const input = document.getElementById("searchInput").value.toLowerCase();
            const rows = document.querySelectorAll("#booksTable tbody tr");

            rows.forEach(row => {
                const cells = row.querySelectorAll("td");
                const matches = Array.from(cells).some(cell =>
                    cell.textContent.toLowerCase().includes(input)
                );
                row.style.display = matches ? "" : "none";
            });
        }

        // To set pagination limit
        function changeLimit(limit) {
            const url = new URL(window.location.href);
            url.searchParams.set('limit', limit);
            url.searchParams.set('page', 1);
            window.location.href = url.toString();
        }

        // For Actions button dropdown menu
        function toggleDropdown() {
            const dropdown = document.getElementById("actionsDropdown");
            dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
        }

        window.onclick = function(event) {
            if (!event.target.matches('.actions-button')) {
                const dropdown = document.getElementById("actionsDropdown");
                if (dropdown && dropdown.style.display === "block") {
                dropdown.style.display = "none";
                }
            }
        }

        function exportCSV() {
            alert("Download Starts as: books-export.csv ")
            // alert("CSV export functionality coming soon!");
        }
        

        function exportPDF() {
            alert("PDF export functionality coming soon!");
        }

        function importBooks() {
            alert("Import Books functionality coming soon!\n(For now use Add Books Button)")
        }

        function deleteSelected() {
            const checkboxes = document.querySelectorAll('#booksTable tbody input[type="checkbox"]:checked');
            if (checkboxes.length === 0) {
                alert("Please select at least one book to delete.");
                return;
            }

            const ids = Array.from(checkboxes).map(cb =>
                cb.closest('tr').dataset.id
            );

            if (!confirm("Are you sure you want to delete selected books?")) return;

            const formData = new FormData();
            ids.forEach(id => formData.append('bookIds[]', id));

            fetch('actions/delete_books.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert("Selected books deleted.");
                    window.location.reload();
                } else {
                    alert("Something went wrong: " + (data.error || "unknown error"));
                }
            })
            .catch(err => {
                console.error("Delete failed:", err);
                alert("Error deleting books.");
            });
        }

        // Optional: Select All functionality
        function toggleAll(masterCheckbox) {
            const checkboxes = document.querySelectorAll('#booksTable tbody input[type="checkbox"]');
            checkboxes.forEach(cb => cb.checked = masterCheckbox.checked);
        }
    </script>
    
</body>
</html>