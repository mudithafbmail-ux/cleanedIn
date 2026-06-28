<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Redirect based on role
$role = $_SESSION['role'] ?? '';

switch ($role) {
    case 'cleaner':
        header('Location: cleanboard.php');
        exit;
    case 'contractor':
        header('Location: contractboard.php');
        exit;
    case 'admin':
        header('Location: admin_dashboard.php'); // optional admin dashboard
        exit;
    default:
        // Unknown role — log out
        session_destroy();
        header('Location: login.php');
        exit;
}
