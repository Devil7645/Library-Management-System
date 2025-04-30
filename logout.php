<?php
// Start the session
session_start();

// Destroy all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to login page
header("Location: index.html");
exit();
?>

<!-- How TO Use


" <a href="logout.php" class="logout-btn">Logout</a> "

Or with a button style:

'''
<form action="logout.php" method="post">
  <button type="submit">Logout</button>
</form>
'''

    🔐 Using a POST method for logout is more secure, 
    but for simplicity, GET links are fine in many cases.

-->