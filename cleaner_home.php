<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require 'db.php';
session_start();
require 'db.php';

// Only cleaners can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'cleaner') {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch all open jobs (not assigned yet)
$available_sql = "
SELECT j.*, u.name AS contractor_name
FROM jobs j
LEFT JOIN users u ON j.contractor_id = u.id
WHERE j.status='open'
AND j.id NOT IN (SELECT job_id FROM job_assignments)
ORDER BY j.created_at DESC
";
$available_result = $conn->query($available_sql);

// Fetch assigned jobs for this cleaner
$assigned_sql = "
SELECT j.*, u.name AS contractor_name
FROM jobs j
JOIN job_assignments ja ON ja.job_id = j.id
LEFT JOIN users u ON j.contractor_id = u.id
WHERE ja.cleaner_id = $user_id
ORDER BY j.updated_at DESC
";
$assigned_result = $conn->query($assigned_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cleaner Dashboard - CleanedIn</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="icon" href="favicon.png">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
/* Loader overlay */
#loader {
    position: fixed;
    inset: 0;
    background: #f1f5f9;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 50;
    flex-direction: column;
}
.loader-circle {
    position: relative;
    width: 140px;
    height: 140px;
}
.loader-circle svg {
    transform: rotate(-90deg);
}
.loader-circle circle.bg {
    fill: none;
    stroke-width: 12;
    stroke: #d1fae5;
}
.loader-circle circle.fg {
    fill: none;
    stroke-width: 12;
    stroke: #10b981;
    stroke-linecap: round;
    stroke-dasharray: 376.99;
    stroke-dashoffset: 376.99;
    transition: stroke-dashoffset 0.3s linear;
}
.loader-logo {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 60px;
    height: 60px;
    transform: translate(-50%, -50%);
}
</style>
</head>
<body class="bg-slate-50 min-h-screen">

<!-- LOADER -->
<div id="loader">
    <div class="loader-circle">
        <svg width="140" height="140">
            <circle class="bg" r="60" cx="70" cy="70"></circle>
            <circle class="fg" r="60" cx="70" cy="70"></circle>
        </svg>
        <img src="favicon.png" class="loader-logo">
    </div>
    <p class="mt-4 text-slate-600">Loading your dashboard...</p>
</div>

<!-- DASHBOARD CONTENT -->
<div id="content" class="hidden">
<header class="bg-green-600 text-white p-4 font-semibold flex justify-between items-center">
    <span>Cleaner Dashboard</span>
    <a href="logout.php" class="bg-white text-green-600 px-3 py-1 rounded-lg hover:bg-green-50 text-sm">Logout</a>
</header>

<main class="max-w-6xl mx-auto p-4">

    <!-- Available Jobs -->
    <h1 class="text-2xl font-semibold mb-4">Available Jobs</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php if ($available_result && $available_result->num_rows > 0): ?>
            <?php while ($job = $available_result->fetch_assoc()): ?>
                <div class="bg-white p-4 rounded-xl shadow hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <h2 class="font-semibold text-lg"><?= htmlspecialchars($job['title']) ?></h2>
                        <p class="text-sm text-slate-500"><?= htmlspecialchars($job['city'] ?: 'Location not listed') ?></p>
                        <p class="text-xs mt-1 text-green-600"><?= ucfirst($job['urgency']) ?> | <?= ucfirst($job['job_type']) ?></p>
                        <p class="text-xs mt-1">Posted by: <?= htmlspecialchars($job['contractor_name']) ?></p>
                    </div>
                    
                    <!-- APPLY FORM -->
                    <form method="POST" action="apply_job.php" id="applyForm<?= $job['id'] ?>">
                        <input type="hidden" name="job_id" value="<?= $job['id'] ?>">
                        <button type="button" onclick="confirmApply(<?= $job['id'] ?>)"
                            class="mt-4 bg-green-600 text-white text-sm py-2 rounded-lg hover:bg-green-700 active:scale-95 transition">
                            Apply
                        </button>
                    </form>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-slate-500 col-span-2">No open jobs available at the moment.</p>
        <?php endif; ?>
    </div>

    <!-- Assigned Jobs -->
    <h1 class="text-2xl font-semibold mb-4 mt-8">Your Assigned Jobs</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php if ($assigned_result && $assigned_result->num_rows > 0): ?>
            <?php while ($job = $assigned_result->fetch_assoc()): ?>
                <div onclick="window.location='workrecords.php?job_id=<?= $job['id'] ?>'"
                     class="bg-white p-4 rounded-xl shadow hover:shadow-md transition cursor-pointer flex flex-col justify-between">
                    <div>
                        <h2 class="font-semibold text-lg"><?= htmlspecialchars($job['title']) ?></h2>
                        <p class="text-sm text-slate-500"><?= htmlspecialchars($job['city'] ?: 'Location not listed') ?></p>
                        <p class="text-xs mt-1 text-green-600"><?= ucfirst($job['urgency']) ?> | <?= ucfirst($job['job_type']) ?></p>
                        <p class="text-xs mt-1">Posted by: <?= htmlspecialchars($job['contractor_name']) ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-slate-500 col-span-2">You have no assigned jobs yet.</p>
        <?php endif; ?>
    </div>

</main>
</div>

<script>
// Loader animation
const loader = document.getElementById('loader');
const content = document.getElementById('content');
const fgCircle = document.querySelector('.loader-circle circle.fg');
let progress = 0;
const total = 376.99; // circumference for r=60

function animateLoader() {
    progress += 5; // speed
    if (progress > total) progress = total;
    fgCircle.style.strokeDashoffset = total - progress;

    if(progress < total){
        requestAnimationFrame(animateLoader);
    } else {
        setTimeout(() => {
            loader.style.display = 'none';
            content.classList.remove('hidden');
        }, 300);
    }
}

requestAnimationFrame(animateLoader);

// Confirm and submit apply form
function confirmApply(jobId){
    Swal.fire({
        title: 'Apply for this job?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Apply',
        cancelButtonText: 'Cancel'
    }).then((result)=>{
        if(result.isConfirmed){
            document.getElementById('applyForm'+jobId).submit();
        }
    });
}
</script>

</body>
</html>