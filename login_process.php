<?php
session_start();
require 'db.php';

/*
    CleanedIn - Login Processor
    Author: Muditha Jayasundara
*/

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

// Basic validation
if (empty($email) || empty($password)) {
    header('Location: login.php?error=empty_fields');
    exit;
}

// SECURITY: prepared statement (prevents SQL injection)
$stmt = $conn->prepare("SELECT id, email, password_hash, role FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();

if ($result && $result->num_rows === 1) {

    $user = $result->fetch_assoc();

    // Verify password hash
    if (password_verify($password, $user['password_hash'])) {

        // Prevent session fixation
        session_regenerate_id(true);

        // Set session data
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        // Role-based routing
        switch ($user['role']) {

            case 'cleaner':
                header('Location: cleanboard.php');
                break;

            case 'contractor':
                header('Location: contractboard.php');
                break;

            case 'admin':
                header('Location: admin_dashboard.php');
                break;

            default:
                header('Location: login.php?error=invalid_role');
                break;
        }

        exit;

    } else {
        header('Location: login.php?error=wrong_password');
        exit;
    }

} else {
    header('Location: login.php?error=user_not_found');
    exit;
}