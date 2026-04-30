<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

require_once '../db.php';

if (isset($_POST['submit'])) {

    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $link = htmlspecialchars($_POST['link']);

    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    $folder = "../img/";
    $newImage = time() . "_" . $image;

    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    move_uploaded_file($tmp, $folder . $newImage);

    $conn->query("INSERT INTO projects (title, description, image, link)
                  VALUES ('$title', '$description', '$newImage', '$link')");

    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tambah Project</title>

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

    <div class="flex items-center gap-3 mb-10">
        <div class="w-10 h-10 bg-blue-500/20 rounded-xl flex items-center justify-center text-blue-400">
            <i data-lucide="layout-dashboard"></i>
        </div>
        <div>
            <h2 class="text-lg font-semibold">DevFolio</h2>
            <p class="text-xs text-gray-400">CMS Panel</p>
        </div>
    </div>

    <nav class="flex flex-col gap-2 text-sm">

        <a href="dashboard.php" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-white/10">
            <i data-lucide="layout-grid"></i> Dashboard
        </a>

        <a href="tambah.php" class="flex items-center gap-2 px-3 py-2 rounded bg-blue-500/20 text-blue-400">
            <i data-lucide="plus-circle"></i> Tambah Project
        </a>

        <a href="edit_profile.php" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-white/10">
            <i data-lucide="user"></i> Edit Profile
        </a>
        <a href="logout.php"
           class="flex items-center gap-2 px-3 py-2 rounded text-red-400 hover:bg-red-500 hover:text-white transition mt-4">
          <i data-lucide="log-out"></i>
           Keluar
         </a>
    </nav>

</aside>

<!-- MAIN -->
<main class="flex-1 p-10">

    <h1 class="text-3xl font-bold mb-2">Tambah Project</h1>
    <p class="text-gray-400 mb-8">Tambahkan project baru ke portfolio kamu</p>

    <!-- FORM CARD -->
    <form action="" method="POST" enctype="multipart/form-data"
          class="bg-white/10 backdrop-blur-xl border border-white/10 p-8 rounded-2xl space-y-6 max-w-2xl">

        <!-- TITLE -->
        <div>
            <label class="text-sm text-gray-300 flex items-center gap-2">
                <i data-lucide="type"></i> Judul Project
            </label>
            <input type="text" name="title" required
                   class="w-full mt-2 p-3 pl-10 rounded bg-gray-800 outline-none relative">
        </div>

        <!-- DESCRIPTION -->
        <div>
            <label class="text-sm text-gray-300 flex items-center gap-2">
                <i data-lucide="file-text"></i> Deskripsi
            </label>
            <textarea name="description" required
                      class="w-full mt-2 p-3 rounded bg-gray-800 outline-none h-28"></textarea>
        </div>

        <!-- LINK -->
        <div>
            <label class="text-sm text-gray-300 flex items-center gap-2">
                <i data-lucide="link"></i> Link Project
            </label>
            <input type="text" name="link"
                   class="w-full mt-2 p-3 rounded bg-gray-800 outline-none">
        </div>

        <!-- IMAGE -->
        <div>
            <label class="text-sm text-gray-300 flex items-center gap-2">
                <i data-lucide="image"></i> Gambar Project
            </label>
            <input type="file" name="image" required
                   class="w-full mt-2 p-3 rounded bg-gray-800">
        </div>

        <!-- BUTTON -->
        <button type="submit" name="submit"
                class="w-full bg-blue-500 py-3 rounded-xl hover:bg-blue-600 transition flex items-center justify-center gap-2">

            <i data-lucide="save"></i>
            Simpan Project

        </button>

    </form>

</main>

</div>

<script>
lucide.createIcons();
</script>

</body>
</html>