<?php
session_start();
require 'db.php';

/*
    CleanedIn - Register Process
    Author: Muditha Jayasundara
*/

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: register.php");
    exit;
}

// Get and clean input
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$role = $_POST['role'] ?? '';

// Basic validation
if (empty($name) || empty($email) || empty($password) || empty($role)) {
    $_SESSION['message'] = "All fields are required!";
    $_SESSION['message_type'] = "error";
    header("Location: register.php");
    exit;
}

// Validate role (security hard-stop)
$allowed_roles = ['cleaner', 'contractor'];
if (!in_array($role, $allowed_roles)) {
    $_SESSION['message'] = "Invalid role selected!";
    $_SESSION['message_type'] = "error";
    header("Location: register.php");
    exit;
}

// Check if email already exists
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $_SESSION['message'] = "Email already registered!";
    $_SESSION['message_type'] = "error";
    header("Location: register.php");
    exit;
}
$stmt->close();

// Hash password securely
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Insert new user
$stmt = $conn->prepare("INSERT INTO users (name, email, password_hash, role) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $password_hash, $role);

if ($stmt->execute()) {

    $_SESSION['message'] = "Registration successful! Please login.";
    $_SESSION['message_type'] = "success";

    header("Location: login.php");
    exit;

} else {

    $_SESSION['message'] = "Registration failed. Try again.";
    $_SESSION['message_type'] = "error";

    header("Location: register.php");
    exit;
}