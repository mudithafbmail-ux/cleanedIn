<?php
session_start();

/*
    CleanedIn - Register Page
    Author: Muditha Jayasundara
*/

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard_redirect.php');
    exit;
}

// Flash message system (from register_process.php)
$message = $_SESSION['message'] ?? null;
$type = $_SESSION['message_type'] ?? 'info';

unset($_SESSION['message'], $_SESSION['message_type']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register - CleanedIn</title>

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
body {
    background: linear-gradient(135deg, #ecfdf5, #ffffff);
    font-family: system-ui, sans-serif;
}

.card {
    animation: fadeIn .35s ease;
}

@keyframes fadeIn {
    from {opacity:0; transform: translateY(12px);}
    to {opacity:1; transform: translateY(0);}
}

.glow {
    box-shadow: 0 10px 30px rgba(16, 185, 129, 0.12);
}
</style>
</head>

<body class="min-h-screen flex items-center justify-center p-4">

<!-- REGISTER CARD -->
<div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md card glow">

    <!-- HEADER -->
    <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-green-700">CleanedIn</h1>
        <p class="text-sm text-gray-500 mt-1">Create your account</p>
    </div>

    <!-- FORM -->
    <form action="register_process.php" method="POST" class="space-y-4">

        <!-- FULL NAME -->
        <input type="text"
               name="name"
               placeholder="Full Name"
               required
               class="w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">

        <!-- EMAIL -->
        <input type="email"
               name="email"
               placeholder="Email"
               required
               class="w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">

        <!-- PASSWORD -->
        <input type="password"
               name="password"
               placeholder="Password"
               required
               class="w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">

        <!-- ROLE -->
        <select name="role"
                required
                class="w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">

            <option value="">Select Role</option>
            <option value="cleaner">Cleaner</option>
            <option value="contractor">Contractor</option>

        </select>

        <!-- SUBMIT -->
        <button type="submit"
                class="w-full bg-green-600 text-white py-2.5 rounded-lg font-semibold hover:bg-green-700 transition active:scale-95">
            Create Account
        </button>

    </form>

    <!-- LOGIN LINK -->
    <p class="mt-5 text-sm text-center text-gray-500">
        Already have an account?
        <a href="login.php" class="text-green-600 font-semibold hover:underline">
            Login here
        </a>
    </p>

</div>

<!-- SWEETALERT -->
<?php if ($message): ?>
<script>
Swal.fire({
    icon: '<?= htmlspecialchars($type) ?>',
    title: '<?= htmlspecialchars($message) ?>',
    confirmButtonColor: '#16a34a',
    confirmButtonText: 'OK'
});
</script>
<?php endif; ?>

</body>
</html>