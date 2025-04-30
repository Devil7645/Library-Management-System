<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Redirect if not logged in (for pages that require login)
function redirectIfNotLoggedIn($redirectPage = 'login.php') {
    if (!isLoggedIn()) {
        header("Location: $redirectPage");
        exit();
    }
}

// Check user role (admin or user) – modify as needed
function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

// Redirect if user is not admin (for admin-only pages)
function redirectIfNotAdmin($redirectPage = 'dashboard.php') {
    if (!isAdmin()) {
        header("Location: $redirectPage");
        exit();
    }
}
?>



<!-- 

How to Use:

    Include this file at the top of each page that requires authentication:

        require_once 'includes/auth.php';

    For pages that should be accessible only to logged-in users:

        redirectIfNotLoggedIn();  // Ensure the user is logged in

    For admin-only pages:

        redirectIfNotAdmin();  // Ensure the user is an admin

-->