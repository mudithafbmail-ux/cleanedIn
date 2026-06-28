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

.bg-soft {
    background: linear-gradient(135deg, #ecfdf5, #ffffff);
}
</style>
</head>

<body class="bg-soft min-h-screen flex items-center justify-center px-4">

<!-- LOGIN CARD -->
<div class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg w-full max-w-md card">

    <!-- HEADER -->
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-green-700">CleanedIn</h1>
        <p class="text-sm text-gray-500 mt-1">Sign in to continue</p>
    </div>

    <!-- FORM -->
    <form id="loginForm" action="login_process.php" method="POST" class="space-y-4">

        <!-- EMAIL -->
        <div>
            <input id="email"
                   type="email"
                   name="email"
                   placeholder="Email address"
                   required
                   class="input w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-green-500">

            <p id="emailError" class="text-red-500 text-xs mt-1 hidden"></p>
        </div>

        <!-- PASSWORD -->
        <div class="relative">
            <input id="password"
                   type="password"
                   name="password"
                   placeholder="Password"
                   required
                   class="input w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-green-500">

            <button type="button"
                    id="toggleBtn"
                    class="absolute right-3 top-2.5 text-sm text-gray-500">
                Show
            </button>

            <p id="passError" class="text-red-500 text-xs mt-1 hidden"></p>
        </div>

        <!-- REMEMBER -->
        <label class="flex items-center space-x-2 text-sm text-gray-600">
            <input type="checkbox" name="remember" class="accent-green-600">
            <span>Remember me</span>
        </label>

        <!-- SUBMIT -->
        <button id="submitBtn"
                type="submit"
                class="w-full bg-green-600 text-white py-2.5 rounded-lg font-medium hover:bg-green-700 transition flex items-center justify-center gap-2">

            <span id="btnText">Login</span>

            <svg id="spinner"
                 class="animate-spin h-5 w-5 hidden"
                 xmlns="http://www.w3.org/2000/svg"
                 fill="none"
                 viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"
                        stroke="currentColor"
                        stroke-width="4"
                        class="opacity-25"></circle>
                <path fill="currentColor"
                      class="opacity-75"
                      d="M4 12a8 8 0 018-8v8z"></path>
            </svg>

        </button>
    </form>

    <!-- FOOTER -->
    <p class="mt-5 text-sm text-center text-gray-500">
        No account?
        <a href="register.php" class="text-green-600 font-medium hover:underline">
            Create one
        </a>
    </p>

</div>

<script>
// PASSWORD TOGGLE
document.getElementById("toggleBtn").addEventListener("click", function(){
    const input = document.getElementById("password");

    if(input.type === "password"){
        input.type = "text";
        this.textContent = "Hide";
    } else {
        input.type = "password";
        this.textContent = "Show";
    }
});

// FORM VALIDATION + LOADING STATE
document.getElementById("loginForm").addEventListener("submit", function(e){

    let valid = true;

    const email = document.getElementById("email");
    const pass = document.getElementById("password");

    const emailErr = document.getElementById("emailError");
    const passErr = document.getElementById("passError");

    emailErr.classList.add("hidden");
    passErr.classList.add("hidden");

    if(!email.value.includes("@")){
        emailErr.textContent = "Enter a valid email address";
        emailErr.classList.remove("hidden");
        valid = false;
    }

    if(pass.value.length < 4){
        passErr.textContent = "Password is too short";
        passErr.classList.remove("hidden");
        valid = false;
    }

    if(!valid){
        e.preventDefault();
        return;
    }

    document.getElementById("btnText").textContent = "Signing in...";
    document.getElementById("spinner").classList.remove("hidden");
    document.getElementById("submitBtn").disabled = true;
});
</script>

</body>
</html>