<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard_redirect.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - CleanedIn</title>

<!-- Muditha Jayasundara -->

<script src="https://cdn.tailwindcss.com"></script>

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

.input:focus {
    transform: scale(1.01);
    transition: .12s ease;
}

.glow {
    box-shadow: 0 10px 30px rgba(16, 185, 129, 0.15);
}
</style>
</head>

<body class="min-h-screen flex items-center justify-center px-4">

<!-- LOGIN CARD -->
<div class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg w-full max-w-md card glow">

    <!-- HEADER -->
    <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-green-700">CleanedIn</h1>
        <p class="text-sm text-gray-500 mt-1">Sign in to continue</p>
    </div>

    <!-- FORM -->
    <form action="login_process.php" method="POST" class="space-y-4">

        <!-- EMAIL -->
        <div>
            <input id="email"
                   type="email"
                   name="email"
                   placeholder="Email address"
                   required
                   class="input w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">

        </div>

        <!-- PASSWORD -->
        <div class="relative">
            <input id="password"
                   type="password"
                   name="password"
                   placeholder="Password"
                   required
                   class="input w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">

            <button type="button"
                    id="toggleBtn"
                    class="absolute right-3 top-2.5 text-sm text-gray-500 hover:text-green-700 font-medium">
                Show
            </button>
        </div>

        <!-- SUBMIT -->
        <button type="submit"
                class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
            Sign In
        </button>
    </form>

    <!-- FOOTER -->
    <p class="text-center text-sm text-gray-500 mt-5">
        Don’t have an account?
        <a href="register.php" class="text-green-600 font-semibold hover:underline">
            Register
        </a>
    </p>

</div>

<!-- JAVASCRIPT -->
<script>
const passwordInput = document.getElementById('password');
const toggleBtn = document.getElementById('toggleBtn');

// Toggle password visibility
toggleBtn.addEventListener('click', () => {
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleBtn.textContent = 'Hide';
    } else {
        passwordInput.type = 'password';
        toggleBtn.textContent = 'Show';
    }
});
</script>

</body>
</html>