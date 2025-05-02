<?php
 require_once 'includes/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Members | MyLMS</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="admin/assets/css/booksmng.css">
   
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

    <h1>Library Members</h1>

    <table class="table" id="booksTable"> 
                    <thead>
                        <tr>
                            
                            <th class="sortable">id<span>↑↓</span></th>
                            <th class="sortable">name<span>↑↓</span></th>
                            <th class="sortable">email<span>↑↓</span></th>
                            
                        </tr>
                    </thead>
        <?php
        $sql = "SELECT * FROM users ORDER BY id DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0):
            while($row = $result->fetch_assoc()):
        ?>
        <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
          
        </tr>
        <?php
            endwhile;
        else:
        ?>
        <tr>
            <td colspan="4">No members found.</td>
        </tr>
        <?php endif; ?>
    </table>

    
</body>
<footer>
        <p>&copy; 2025 MyLibrary. All rights reserved.</p>
    </footer>
</html>
