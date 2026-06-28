<?php
session_start();
require 'db.php';

// Ensure contractor is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'contractor') {
    header('Location: login.php');
    exit;
}

$contractor_id = $_SESSION['user_id'];

/* ================= JOB LIST ================= */
$sql = "
SELECT j.*,
    (SELECT COUNT(*) FROM job_applications ja WHERE ja.job_id=j.id) AS applicants,
    (SELECT u.name FROM job_applications ja
        JOIN users u ON ja.cleaner_id=u.id
        WHERE ja.job_id=j.id AND ja.status='assigned' LIMIT 1
    ) AS assigned_cleaner
FROM jobs j
WHERE j.contractor_id = ?
AND j.deleted_at IS NULL
ORDER BY j.created_at DESC
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $contractor_id);
$stmt->execute();
$result = $stmt->get_result();

/* ================= NOTIFICATIONS ================= */
$notif_sql = "
SELECT COUNT(*) AS c
FROM job_applications ja
JOIN jobs j ON ja.job_id=j.id
WHERE j.contractor_id=?
AND ja.viewed_by_contractor=0
";
$stmt_notif = $conn->prepare($notif_sql);
$stmt_notif->bind_param("i", $contractor_id);
$stmt_notif->execute();
$notif = $stmt_notif->get_result()->fetch_assoc()['c'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contractor Dashboard - CleanedIn</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="icon" href="favicon.png">
<style>
/* Fonts & card styling for app-like feel */
body { font-family: 'Inter', sans-serif; background: #f8fafc; }
.card { border-radius: 20px; padding: 1.5rem; background: white; box-shadow: 0 6px 16px rgba(0,0,0,0.08); transition: transform 0.2s; }
.card:hover { transform: translateY(-2px); }
.card h2 { font-weight: 700; font-size: 1.25rem; color: #111827; }
.card p { font-size: 1rem; color: #374151; }
.card p span { font-weight: 600; }
.btn { padding: 0.6rem 1.2rem; border-radius: 14px; font-weight: 600; text-align: center; transition: all 0.2s; font-size: 0.95rem; }
.btn-green { border: 2px solid #10b981; color: #10b981; background: transparent; }
.btn-green:hover { background: #10b981; color: white; }
.btn-gray { border: 2px solid #9ca3af; color: #374151; background: transparent; }
.btn-gray:hover { background: #9ca3af; color: white; }
.btn-amber { border: 2px solid #f59e0b; color: #f59e0b; background: transparent; }
.btn-amber:hover { background: #f59e0b; color: white; }
.btn-red { border: 2px solid #ef4444; color: #ef4444; background: transparent; }
.btn-red:hover { background: #ef4444; color: white; }
</style>
</head>
<body>

<!-- HEADER -->
<header class="bg-green-600 text-white p-5 font-semibold flex justify-between items-center shadow-md">
    <span class="text-xl">Contractor Dashboard</span>
    <div class="flex items-center gap-5">
        <!-- Notifications -->
        <div class="relative text-2xl cursor-pointer">🔔
            <?php if($notif>0): ?>
                <span class="absolute -top-2 -right-3 bg-red-500 text-white text-xs font-bold rounded-full px-2">
                    <?= $notif ?>
                </span>
            <?php endif; ?>
        </div>
        <a href="logout.php" class="bg-white text-green-600 px-4 py-2 rounded-xl hover:bg-green-50 text-sm font-semibold">Logout</a>
    </div>
</header>

<main class="max-w-6xl mx-auto p-5 space-y-8">

    <!-- Job Actions -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Your Posted Jobs</h1>
        <a href="post_job.php" class="bg-green-600 text-white px-5 py-3 rounded-xl hover:bg-green-700 font-semibold shadow-md">Post New Job</a>
    </div>

    <!-- Job Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php while($job = $result->fetch_assoc()): ?>
            <div class="card flex flex-col justify-between">
                <div class="space-y-3">
                    <h2><?= htmlspecialchars($job['title']) ?></h2>
                    <p><span>Location:</span> <?= htmlspecialchars($job['city']) ?><?= $job['suburb'] ? ", " . htmlspecialchars($job['suburb']) : "" ?></p>
                    <p class="text-green-600 font-semibold"><?= ucfirst($job['urgency']) ?> | <?= ucfirst(str_replace('_',' ',$job['job_type'])) ?></p>
                    <p><span>Applicants:</span> <?= $job['applicants'] ?></p>
                    <?php if(!empty($job['assigned_cleaner'])): ?>
                        <p><span>Assigned Cleaner:</span> <?= htmlspecialchars($job['assigned_cleaner']) ?></p>
                    <?php else: ?>
                        <p class="text-gray-500"><span>Assigned Cleaner:</span> None</p>
                    <?php endif; ?>
                    <p><span>Status:</span> <?= ucfirst($job['status']) ?></p>
                </div>
                <div class="mt-5 flex flex-wrap gap-3">
                    <a href="view_applicants.php?job_id=<?= $job['id'] ?>" class="btn btn-green">Applicants</a>
                    <a href="edit_job.php?job_id=<?= $job['id'] ?>" class="btn btn-gray">Edit</a>
                    <a href="toggle_status.php?id=<?= $job['id'] ?>" class="btn btn-amber">Toggle</a>
                    <a href="soft_delete_job.php?id=<?= $job['id'] ?>" class="btn btn-red">Delete</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

</main>

</body>
</html>