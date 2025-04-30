<?php
session_start();
require_once '../includes/auth.php';
require_once '../includes/db.php';

if (!isLoggedIn() || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
// Total number of book records (titles)
$resultBooks = $conn->query("SELECT COUNT(*) AS total FROM books");
$totalBooks = $resultBooks->fetch_assoc()['total'];

// Total available copies (sum of all available copies)
$resultAvailable = $conn->query("SELECT SUM(available_copies) AS total FROM books");
$availableBooks = $resultAvailable->fetch_assoc()['total'] ?? 0;

// Total lended = total copies - available copies
$resultCopies = $conn->query("SELECT SUM(copies) AS total FROM books");
$totalCopies = $resultCopies->fetch_assoc()['total'] ?? 0;

$lendedBooks = $totalCopies - $availableBooks;

// Fetch Total Users (not admin)
$resultUsers = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role = 'user'");
$totalUsers = $resultUsers->fetch_assoc()['total'];

// Fetch Overdue Books
$resultOverdue = $conn->query("SELECT COUNT(*) AS total FROM borrow_records WHERE due_date < NOW() AND return_date IS NULL");
$overdueBooks = $resultOverdue->fetch_assoc()['total'];

$activePage = 'dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js" />
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="assets/css/admin.css">
</head>

<body>
<?php include 'includes/header.php'; ?>

<div class="body">

  <div class="sidebar">
    <?php include 'includes/sidebar.php'; ?>
  </div>

  <div class="main">
    <div class="topbar">
      <h1>Welcome Admin: <?php echo $_SESSION['name'] ?></h1>
      <div class="quick">
        <p>Quick Actions : </p>
        <button onclick="window.location.href='add_books.php'">Add New Book</button>
      </div>
    </div>

    <div class="cards">
      <div class="card card-yellow">
        <div class="icon-container">
          <span class="icon book-icon"></span>
        </div>
        <h3>Total Books</h3><p><?php echo $totalBooks; ?></p>
        <button>View Details</button>
      </div>
      <div class="card card-blue">
        <div class="icon-container">
          <span class="icon book-icon"></span>
        </div>
        <h3>Lended Books</h3><p><?php echo $lendedBooks; ?></p>
        <button>View Details</button>
      </div>
      <div class="card card-teal">
        <div class="icon-container">
          <span class="icon book-icon"></span>
        </div>
        <h3>Available Books</h3><p><?php echo $availableBooks; ?></p>
        <button>View Details</button>
      </div>
      <div class="card card-green">
        <div class="icon-container">
          <span class="icon user-icon"></span>
        </div>
        <h3>Total Users</h3><p><?php echo $totalUsers; ?></p>
        <button>View Details</button>
      </div>
      <div class="card card-pink">
        <div class="icon-container">
          <span class="icon overdue-icon"></span>
        </div>
        <h3>Overdue Books</h3><p><?php echo $overdueBooks; ?></p>
        <button>View Details</button>
      </div>
    </div>

    <div class="charts">
      <div class="chart-box"><h3>No of Visitors</h3><canvas id="visitorsChart"></canvas></div>
      <div class="chart-box"><h3>Book Availability</h3><canvas id="availabilityChart"></canvas></div>
      <div class="chart-box"><h3>Book Lending Trends</h3><canvas id="lendingChart"></canvas></div>
    </div>
  </div>

   

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
  // Charts
  const availableBooks = <?php echo $availableBooks; ?>;
  const lendedBooks = <?php echo $lendedBooks; ?>;
  const reservedBooks = 0; // if you track this, change from DB

  // Book Availability Chart (Live Data)
  new Chart(document.getElementById('availabilityChart'), {
    type: 'pie',
    data: {
      labels: ['Lended', 'Available', 'Reserved'],
      datasets: [{
        data: [lendedBooks, availableBooks, reservedBooks],
        backgroundColor: ['#ef4444', '#10b981', '#f59e0b']
      }]
    }
  });

  // Static or future implementation for others:
  new Chart(document.getElementById('visitorsChart'), {
    type: 'bar',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'],
      datasets: [
        {
          label: 'Visitors',
          // data: [0, 0, 0, 0, 0, 0, 0, 0],
          data: [80, 100, 95, 130, 150, 140, 120, 100],
          backgroundColor: '#5b21b6'
        },
        {
          label: 'Lenders',
          // data: [0, 0, 0, 0, 0, 0, 0, 0],
          data: [40, 60, 50, 70, 80, 70, 60, 50],
          backgroundColor: '#818cf8'
        }
      ]
    }
  });

  new Chart(document.getElementById('lendingChart'), {
    type: 'bar',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'],
      datasets: [{
        label: 'Books Lent',
        // data: [0, 0, 0, 0, 0, 0, 0, 0],
        data: [200, 300, 350, 400, 420, 380, 360, 300],
        backgroundColor: '#7c3aed'
      }]
    }
  });

  // Hamburger toggle for mobile
  document.getElementById('hamburger')?.addEventListener('click', () => {
    document.getElementById('nav-menu')?.classList.toggle('show');
  });

</script>
</div>
<?php include 'includes/footer.php'; ?> 
</body>
</html>