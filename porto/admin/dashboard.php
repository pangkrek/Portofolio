<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

require_once '../db.php';

// data
$projects = $conn->query("SELECT * FROM projects ORDER BY id DESC");
$totalProject = $conn->query("SELECT COUNT(*) as total FROM projects")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Portfolio CMS Dashboard</title>

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/lucide@latest"></script>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
body {
  font-family: 'Inter', sans-serif;
  background: #0f172a;
}
</style>
</head>

<body class="text-white">

<div class="flex min-h-screen">

<!-- SIDEBAR -->
<aside class="w-64 bg-gray-900 border-r border-white/10 p-6">

    <!-- BRAND -->
    <div class="flex items-center gap-3 mb-10">

        <div class="w-10 h-10 bg-blue-500/20 rounded-xl flex items-center justify-center text-blue-400">
            <i data-lucide="layout-dashboard"></i>
        </div>

        <div>
            <h2 class="text-lg font-semibold">DevFolio</h2>
            <p class="text-xs text-gray-400">CMS Panel</p>
        </div>

    </div>

    <!-- MENU -->
    <nav class="flex flex-col gap-2 text-sm">

        <a href="dashboard.php" class="flex items-center gap-3 px-3 py-2 rounded bg-blue-500/20 text-blue-400">
            <i data-lucide="layout-grid"></i> Dashboard
        </a>

        <a href="tambah.php" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-white/10">
            <i data-lucide="plus-circle"></i> Tambah Project
        </a>

        <a href="edit_profile.php" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-white/10">
            <i data-lucide="user"></i> Edit Profile
        </a>

        <a href="../index.php" target="_blank" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-white/10">
            <i data-lucide="eye"></i> View Portfolio
        </a>

        <a href="logout.php" class="flex items-center gap-3 px-3 py-2 rounded text-red-400 hover:bg-red-500 hover:text-white">
            <i data-lucide="log-out"></i> Logout
        </a>

    </nav>

</aside>

<!-- MAIN -->
<main class="flex-1 p-8">

<!-- HEADER -->
<div class="flex justify-between items-center mb-8">

    <div>
        <h1 class="text-4xl font-bold">Dashboard</h1>
        <p class="text-gray-400 text-sm">Kelola portfolio kamu dari satu tempat</p>
    </div>

    <div class="flex items-center gap-3">
        <div class="text-right">
            <p class="text-sm"><?= $_SESSION['username'] ?? 'Admin' ?></p>
            <p class="text-xs text-gray-400">Online</p>
        </div>
        <img src="../img/profile.jpg" class="w-9 h-9 rounded-full object-cover">
    </div>

</div>

<!-- QUICK ACTION -->
<div class="grid md:grid-cols-4 gap-4 mb-8">

    <a href="tambah.php" class="bg-blue-500/20 p-4 rounded-xl flex items-center gap-3 hover:scale-[1.02] transition">
        <i data-lucide="plus"></i> Add Project
    </a>

    <a href="edit_profile.php" class="bg-purple-500/20 p-4 rounded-xl flex items-center gap-3 hover:scale-[1.02] transition">
        <i data-lucide="user"></i> Profile
    </a>

    <a href="../index.php" target="_blank" class="bg-green-500/20 p-4 rounded-xl flex items-center gap-3 hover:scale-[1.02] transition">
        <i data-lucide="eye"></i> Preview
    </a>

    <a href="#" class="bg-yellow-500/20 p-4 rounded-xl flex items-center gap-3 hover:scale-[1.02] transition">
        <i data-lucide="settings"></i> Settings
    </a>

</div>

<!-- STATS -->
<div class="grid md:grid-cols-3 gap-6 mb-8">

    <div class="bg-white/10 p-6 rounded-2xl flex justify-between">
        <div>
            <p class="text-gray-400 text-sm">Total Project</p>
            <h2 class="text-3xl font-bold"><?= $totalProject ?></h2>
        </div>
        <i data-lucide="folder" class="text-blue-400"></i>
    </div>

    <div class="bg-white/10 p-6 rounded-2xl flex justify-between">
        <div>
            <p class="text-gray-400 text-sm">Status</p>
            <h2 class="text-green-400 font-bold">Active</h2>
        </div>
        <i data-lucide="check-circle" class="text-green-400"></i>
    </div>

    <div class="bg-white/10 p-6 rounded-2xl flex justify-between">
        <div>
            <p class="text-gray-400 text-sm">System</p>
            <h2 class="font-bold">Portfolio CMS</h2>
        </div>
        <i data-lucide="cpu" class="text-purple-400"></i>
    </div>

</div>

<!-- LIVE PREVIEW -->
<div class="bg-white/10 p-4 rounded-2xl mb-8">
    <div class="flex justify-between mb-2">
        <h3 class="font-semibold">Live Portfolio Preview</h3>
        <a href="../index.php" target="_blank" class="text-blue-400 text-sm">Open</a>
    </div>

    <iframe src="../index.php" class="w-full h-64 rounded-xl"></iframe>
</div>

<!-- TABLE -->
<div class="bg-white/10 rounded-2xl overflow-hidden">

    <div class="p-5 border-b border-white/10 flex justify-between items-center">
        <h2 class="font-semibold">Projects</h2>

        <input type="text" placeholder="Search..."
               class="bg-gray-800 px-3 py-2 rounded text-sm">
    </div>

    <?php if ($totalProject == 0): ?>
        <div class="text-center py-10 text-gray-400">
            No project yet 😢
        </div>
    <?php else: ?>

    <div class="overflow-x-auto">
    <table class="w-full text-sm">

        <thead class="bg-white/5 text-gray-300">
            <tr>
                <th class="p-3 text-left">Image</th>
                <th class="p-3 text-left">Title</th>
                <th class="p-3 text-left">Description</th>
                <th class="p-3 text-left">Action</th>
            </tr>
        </thead>

        <tbody>

        <?php while($row = $projects->fetch_assoc()): ?>

        <tr class="border-t border-white/10 hover:bg-white/5 transition">

            <td class="p-3">
                <img src="../img/<?= $row['image'] ?>"
                     class="w-16 h-12 object-cover rounded">
            </td>

            <td class="p-3 font-medium">
                <?= htmlspecialchars($row['title']) ?>
            </td>

            <td class="p-3 text-gray-400 max-w-xs truncate">
                <?= htmlspecialchars($row['description']) ?>
            </td>

            <td class="p-3 flex gap-2">

                <a href="edit.php?id=<?= $row['id'] ?>"
                   class="bg-yellow-500 px-3 py-1 rounded text-xs">
                   Edit
                </a>

                <a href="hapus.php?id=<?= $row['id'] ?>"
                   onclick="return confirm('Delete this project?')"
                   class="bg-red-500 px-3 py-1 rounded text-xs">
                   Delete
                </a>

            </td>

        </tr>

        <?php endwhile; ?>

        </tbody>

    </table>
    </div>

    <?php endif; ?>

</div>

</main>

</div>

<script>
lucide.createIcons();
</script>

</body>
</html>