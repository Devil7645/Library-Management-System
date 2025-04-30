<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../includes/db.php';
require_once '../includes/auth.php';

if (!isLoggedIn() || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}


$activePage = 'members';

// Pagination logic
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Total records
$totalResult = $conn->query("SELECT COUNT(*) as total FROM users");
$totalRow = $totalResult->fetch_assoc();
$totalusers = $totalRow['total'];
$totalPages = ceil($totalusers / $limit);

// Fine var
$fineRate = 10; // Default fallback
$fineResult = $conn->query("SELECT value FROM settings WHERE name = 'fine_per_day'");

if ($fineResult && $fineResult->num_rows > 0) {
    $fineRow = $fineResult->fetch_assoc();
    $fineRate = floatval($fineRow['value']); // Correct column is 'value', not 'fine_per_day'
}

// Get current page records
$query = "
    SELECT 
        users.*, 
        SUM(
            CASE 
                WHEN br.return_date IS NULL AND CURDATE() > br.due_date THEN DATEDIFF(CURDATE(), br.due_date) * $fineRate
                WHEN br.return_date > br.due_date THEN DATEDIFF(br.return_date, br.due_date) * $fineRate
                ELSE 0
            END
        ) AS total_fine,
        GROUP_CONCAT(DISTINCT b.title SEPARATOR ', ') AS borrowed_books
    FROM users
    LEFT JOIN borrow_records br ON users.id = br.user_id
    LEFT JOIN books b ON br.book_id = b.id
    GROUP BY users.id
    LIMIT $limit OFFSET $offset
";
$result = $conn->query($query);
// $result = $conn->query("SELECT * FROM users LIMIT $limit OFFSET $offset");
// $result = $conn->query("SELECT * FROM books");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Members</title>
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
                <a href="members.php">Members</a>
            </div>
            <div class="container">
                <div class="toolbar">
                    <div class="search-bar">
                        <span class="search-icon">&#x1F50D;</span>
                        <input type="text" id="searchInput" class="search-input" placeholder="Search Members"
                            onkeyup="filterUsers()">
                    </div>
                    <div class="actions">
                        <button class="add-button" onclick="window.location.href='add_member.php'">+ Add Member</button>
                        <div class="actions dropdown">
                            <button class="actions-button" onclick="toggleDropdown()">Actions ▾</button>
                            <div class="dropdown-content" id="actionsDropdown">
                                <a href="#" onclick="deleteSelected()">&#x1F6AB; Delete Selected</a>
                                <a href="actions/exportCSV_users.php" onclick="exportCSV()">&#x1F4E4; Export to CSV</a>
                                <a href="javascript:window.print()">&#x1F5A8; Print List</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <table class="table" id="usersTable"> 
                    <thead>
                        <tr>
                            <th><input type="checkbox" onclick="toggleAll(this)"></th>
                            <th class="sortable">User ID <span>↑↓</span></th>
                            <th class="sortable">Names <span>↑↓</span></th>
                            <th class="sortable">E-mail <span>↑↓</span></th>
                            <th class="sortable">Phone No. <span>↑↓</span></th>
                            <th class="sortable">Role <span>↑↓</span></th>
                            <th class="sortable">Lending History <span>↑↓</span></th>
                            <th class="sortable">Fine <span>↑↓</span></th>
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

                            <?php
                            $profileUrl = 'user_details.php';
                            if (!empty($row['user_nameId'])) {
                                $profileUrl .= '?user=' . urlencode($row['user_nameId']);
                            } else {
                                $profileUrl .= '?id=' . $row['id'];
                            }
                            ?>
                            <td><a href="<?= $profileUrl ?>"><?= $row['user_nameId'] ?: 'User #' . $row['id'] ?></a>
                            </td>
                            <td> <?= $row['name'] ?> </td>
                            <td> <?= $row['email'] ?> </td>
                            <td> <?= $row['phone'] ?> </td>
                            <td><span class="role-<?= $row['role'] ?>">
                                    <?= $row['role'] ?>
                                </span>
                            </td>
                            <td><?= $row['borrowed_books'] ?? 'None' ?></td>
                            <td>₹<?= number_format($row['total_fine'], 2) ?></td>
                        </tr>
                        <?php } ?>

                    </tbody>
                </table>

                <div class="pagination">
                    <div>Total Members: <?= $totalusers ?></div>
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
        function filterUsers() {
            const input = document.getElementById("searchInput").value.toLowerCase();
            const rows = document.querySelectorAll("#usersTable tbody tr");

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
            alert("Download Starts as: users-export.csv ")
            // alert("CSV export functionality coming soon!");
        }

        function deleteSelected() {
            const checkboxes = document.querySelectorAll('#usersTable tbody input[type="checkbox"]:checked');
            if (checkboxes.length === 0) {
                alert("Please select at least one member to delete.");
                return;
            }

            const ids = Array.from(checkboxes).map(cb =>
                cb.closest('tr').dataset.id
            );

            if (!confirm("Are you sure you want to delete selected User?")) return;

            const formData = new FormData();
            ids.forEach(id => formData.append('userIds[]', id));

            fetch('actions/delete_users.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert("Selected Users deleted.");
                    window.location.reload();
                } else {
                    alert("Something went wrong: " + (data.error || "unknown error"));
                }
            })
            .catch(err => {
                console.error("Delete failed:", err);
                alert("Error deleting Users.");
            });
        }

        // Optional: Select All functionality
        function toggleAll(masterCheckbox) {
            const checkboxes = document.querySelectorAll('#usersTable tbody input[type="checkbox"]');
            checkboxes.forEach(cb => cb.checked = masterCheckbox.checked);
        }
    </script>
    
</body>
</html>