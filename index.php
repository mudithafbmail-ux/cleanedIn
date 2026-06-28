<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CleanedIn – Cleaning Operations Platform</title>

  <!-- Muditha Jayasundara -->

  <link rel="icon" type="image/png" href="favicon.png">
  <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css"/>
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700,900" rel="stylesheet"/>

  <style>
    body {
      font-family: 'Source Sans Pro', sans-serif;
    }

    .gradient {
      background: linear-gradient(90deg, #064e3b 0%, #10b981 100%);
    }

    /* ===== LOADER ===== */
    #loader {
      display: flex;
      justify-content: center;
      align-items: center;
      position: fixed;
      inset: 0;
      background: #ecfdf5;
      z-index: 9999;
    }

    .spinner-ring {
      border-width: 8px;
      border-style: solid;
      border-color: #bbf7d0 #bbf7d0 #10b981 #bbf7d0;
      border-radius: 9999px;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    /* ===== HERO EFFECTS ===== */
    .glow-grid {
      background-image:
        linear-gradient(rgba(255,255,255,0.05) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.05) 1px, transparent 1px);
      background-size: 60px 60px;
      animation: gridMove 12s linear infinite;
    }

    @keyframes gridMove {
      0% { transform: translateY(0px); }
      100% { transform: translateY(60px); }
    }

    .floating-orb {
      position: absolute;
      filter: blur(60px);
      animation: float 10s ease-in-out infinite;
    }

    @keyframes float {
      0% { transform: translate(0px,0px) scale(1); }
      50% { transform: translate(40px,-30px) scale(1.1); }
      100% { transform: translate(0px,0px) scale(1); }
    }

    .hero-parallax {
      transition: transform 0.1s linear;
    }

    /* ===== DASHBOARD GLASS ===== */
    .glass-card {
      background: rgba(255, 255, 255, 0.08);
      backdrop-filter: blur(18px);
      -webkit-backdrop-filter: blur(18px);
      border: 1px solid rgba(255, 255, 255, 0.15);
      color: white;
      animation: glowPulse 4s ease-in-out infinite;
    }

    @keyframes glowPulse {
      0% { box-shadow: 0 0 25px rgba(16,185,129,0.10); }
      50% { box-shadow: 0 0 55px rgba(16,185,129,0.25); }
      100% { box-shadow: 0 0 25px rgba(16,185,129,0.10); }
    }

    .hero-dashboard {
      animation: dashFloat 6s ease-in-out infinite;
    }

    @keyframes dashFloat {
      0% { transform: translateY(0px); }
      50% { transform: translateY(-10px); }
      100% { transform: translateY(0px); }
    }

    .hidden { display: none; }
  </style>
</head>

<body>

<!-- LOADER -->
<div id="loader">
  <div class="relative w-24 h-24">
    <div class="spinner-ring absolute inset-0 rounded-full"></div>
    <img src="favicon.png" class="w-16 h-16 absolute inset-0 m-auto">
  </div>
</div>

<!-- CONTENT -->
<div id="realContent" class="hidden">

  <!-- NAV -->
  <nav class="fixed top-0 w-full z-50 gradient text-white shadow-md">
    <div class="max-w-6xl mx-auto flex justify-between items-center px-6 py-4">
      <div class="text-2xl font-black tracking-wider">CLEANEDIN</div>

      <div class="space-x-4">
        <a href="login.php" class="bg-white text-green-800 px-6 py-2 rounded-full font-bold hover:scale-105 transition">
          Login
        </a>

        <a href="register.php" class="bg-green-800 text-white px-6 py-2 rounded-full font-bold hover:bg-green-900 transition">
          Register
        </a>
      </div>
    </div>
  </nav>

  <!-- HERO -->
  <section class="relative overflow-hidden gradient text-white pt-40 pb-28">

    <div class="absolute inset-0 opacity-20 glow-grid"></div>

    <div class="floating-orb w-72 h-72 bg-green-300 rounded-full top-10 left-10"></div>
    <div class="floating-orb w-96 h-96 bg-emerald-400 rounded-full bottom-10 right-10"></div>

    <div id="heroContent" class="relative max-w-5xl mx-auto px-6 text-center hero-parallax">

      <p class="uppercase tracking-widest text-green-100 text-sm mb-4">
        Built for Cleaning Operators
      </p>

      <h1 class="text-5xl md:text-6xl font-black leading-tight mb-6">
        Run Cleaning Jobs<br/>Without the Chaos
      </h1>

      <p class="text-lg md:text-xl text-green-100 max-w-3xl mx-auto mb-10">
        CleanedIn helps manage recurring shifts, track hours, and automate invoicing in one system.
      </p>

      <div class="space-x-4">
        <a href="login.php"
           class="bg-white text-green-800 font-bold px-8 py-4 rounded-full shadow-xl hover:scale-105 transition">
          Login
        </a>

        <a href="register.php"
           class="bg-green-800 text-white font-bold px-8 py-4 rounded-full shadow-xl hover:bg-green-900 transition">
          Get Started
        </a>
      </div>

      <!-- DASHBOARD PREVIEW -->
      <div class="mt-14 mx-auto max-w-4xl hero-dashboard">
        <div class="glass-card p-6 rounded-3xl shadow-2xl">

          <div class="flex justify-between mb-6">
            <div class="flex space-x-2">
              <span class="w-3 h-3 bg-red-400 rounded-full"></span>
              <span class="w-3 h-3 bg-yellow-400 rounded-full"></span>
              <span class="w-3 h-3 bg-green-400 rounded-full"></span>
            </div>
            <div class="text-xs text-white/70">CleanedIn Dashboard</div>
          </div>

          <div class="grid md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white/10 p-4 rounded-xl">
              <p class="text-xs text-white/60">Active Cleaners</p>
              <p class="text-2xl font-bold">128</p>
            </div>

            <div class="bg-white/10 p-4 rounded-xl">
              <p class="text-xs text-white/60">Hours This Week</p>
              <p class="text-2xl font-bold">3,482</p>
            </div>

            <div class="bg-white/10 p-4 rounded-xl">
              <p class="text-xs text-white/60">Invoices Pending</p>
              <p class="text-2xl font-bold">19</p>
            </div>
          </div>

          <div class="space-y-3 text-sm text-left">
            <div class="bg-white/10 p-3 rounded-lg flex justify-between">
              <span>Alex clocked in – Site A</span>
              <span class="text-green-200">Now</span>
            </div>

            <div class="bg-white/10 p-3 rounded-lg flex justify-between">
              <span>Invoice batch generated</span>
              <span class="text-green-200">2m ago</span>
            </div>

            <div class="bg-white/10 p-3 rounded-lg flex justify-between">
              <span>Maria completed shift</span>
              <span class="text-green-200">14m ago</span>
            </div>
          </div>

        </div>
      </div>

    </div>
  </section>

  <!-- FEATURES -->
  <section class="bg-white py-24 text-gray-800">
    <div class="max-w-6xl mx-auto px-6 text-center">

      <h2 class="text-4xl font-bold mb-16">Everything You Need</h2>

      <div class="grid md:grid-cols-3 gap-10">

        <div class="bg-gray-50 p-8 rounded-2xl">
          <h3 class="text-green-700 font-bold mb-2">Recurring Shifts</h3>
          <p>Assign once. Repeat automatically.</p>
        </div>

        <div class="bg-gray-50 p-8 rounded-2xl">
          <h3 class="text-green-700 font-bold mb-2">Hour Tracking</h3>
          <p>Real-time verified work logs.</p>
        </div>

        <div class="bg-gray-50 p-8 rounded-2xl">
          <h3 class="text-green-700 font-bold mb-2">Automation</h3>
          <p>Invoices generated every 14 days.</p>
        </div>

      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="gradient text-green-100 text-center py-10">
    © 2026 CleanedIn Pty Ltd · Built in Australia
  </footer>

</div>

<!-- PARALLAX -->
<script>
document.addEventListener("mousemove", (e) => {
  const hero = document.getElementById("heroContent");
  if (!hero) return;

  const x = (window.innerWidth / 2 - e.clientX) * 0.02;
  const y = (window.innerHeight / 2 - e.clientY) * 0.02;

  hero.style.transform = `translate(${x}px, ${y}px)`;
});
</script>

<!-- LOADER -->
<script>
setTimeout(() => {
  const loader = document.getElementById('loader');
  loader.style.opacity = '0';
  setTimeout(() => loader.classList.add('hidden'), 500);
}, 2000);

setTimeout(() => {
  document.getElementById('realContent').classList.remove('hidden');
}, 2500);
</script>

</body>
</html>