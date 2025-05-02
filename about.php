<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <header>
    <div class="header-left">
      <div class="hamburger" id="hamburger">&#9776;</div>
      <div class="logo">📚 MyLMS</div>
    </div>
    <nav id="nav-menu">
      <ul>
        <li><a class="head-link" href="index.html">Home</a></li>
        <li><a class="head-link" href="book.php">Books</a></li>
        <li><a class="head-link" href="member.php">Members</a></li>
        <li><a class="head-link" href="about.php">About</a></li>
        <li><a class="head-link" href="login.php">Login</a></li>
      </ul>
    </nav>
  </header>

    <div class="container">
         <h1>About Our System</h1>
      <p>
        Welcome to the Library Management System! This platform is designed to simplify and automate library operations for administrators, librarians, and members. Our system provides a seamless experience for managing books, users, and transactions.
      </p><br>
      <ul>
        <li>. Modern dashboard for quick insights</li>
        <li>. Easy book and member management</li>
        <li>. Efficient book issue and return process</li>
        <li>. Real-time statistics and reports</li>
        <li>. Secure and user-friendly interface</li>
      </ul>
      <p>
        Our mission is to empower libraries with technology, making information accessible and management effortless.
      </p><br>
      <!-- Meet the Team Button -->
    <button id="teamBtn">Meet the Team</button><br>

<!-- Team Info (Initially hidden) -->
<div id="team" class="team-section">
  <strong>Our Team</strong>
  <h3>. Punit Pandey </h3>
  <h3>. Vinay Vishwakarma </h3>
  <h3>. Deepak Yadav </h3><br><br>
  <p>
    Developed by a passionate group of software engineers dedicated to improving library services through innovation and technology.
  </p><br>
</div>
</div>

<footer>
<p>&copy; 2025 MyLibrary. All rights reserved.</p>
</footer>

<script>
// Toggle functionality for "Meet the Team"
document.getElementById('teamBtn').addEventListener('click', function () {
  const team = document.getElementById('team');
  if (team.style.display === 'block') {
    team.style.display = 'none';
  } else {
    team.style.display = 'block';
  }
});
</script>
</body>
</html>
