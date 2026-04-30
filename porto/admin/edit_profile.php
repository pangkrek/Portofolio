<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

require_once '../db.php';

// ambil data profile (asumsi 1 row)
$profile = $conn->query("SELECT * FROM profile WHERE id=1")->fetch_assoc();

if (isset($_POST['update'])) {

    $name = htmlspecialchars($_POST['name']);
    $desc = htmlspecialchars($_POST['description']);
    $ig = htmlspecialchars($_POST['instagram']);
    $fb = htmlspecialchars($_POST['facebook']);
    $wa = htmlspecialchars($_POST['whatsapp']);
    $email = htmlspecialchars($_POST['email']);

    // foto
    $photo = $_FILES['photo']['name'];
    $tmp = $_FILES['photo']['tmp_name'];

    if ($photo) {
        $newPhoto = time() . "_" . $photo;
        move_uploaded_file($tmp, "../img/" . $newPhoto);

        $conn->query("UPDATE profile SET 
            name='$name',
            description='$desc',
            instagram='$ig',
            facebook='$fb',
            whatsapp='$wa',
            email='$email',
            photo='$newPhoto'
            WHERE id=1
        ");
    } else {
        $conn->query("UPDATE profile SET 
            name='$name',
            description='$desc',
            instagram='$ig',
            facebook='$fb',
            whatsapp='$wa',
            email='$email'
            WHERE id=1
        ");
    }

    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Profile</title>

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

        <a href="tambah.php" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-white/10">
            <i data-lucide="plus-circle"></i> Tambah Project
        </a>

        <a href="edit_profile.php" class="flex items-center gap-2 px-3 py-2 rounded bg-blue-500/20 text-blue-400">
            <i data-lucide="user"></i> Edit Profile
        </a>

        <a href="logout.php" class="flex items-center gap-2 px-3 py-2 rounded text-red-400 hover:bg-red-500 hover:text-white">
            <i data-lucide="log-out"></i> Logout
        </a>

    </nav>

</aside>

<!-- MAIN -->
<main class="flex-1 p-10">

    <h1 class="text-3xl font-bold mb-2">Edit Profile</h1>
    <p class="text-gray-400 mb-8">Ubah informasi personal portfolio kamu</p>

    <!-- FORM -->
    <form action="" method="POST" enctype="multipart/form-data"
          class="bg-white/10 backdrop-blur-xl border border-white/10 p-8 rounded-2xl space-y-5 max-w-2xl">

        <!-- FOTO -->
        <div>
            <label class="flex items-center gap-2 text-sm text-gray-300">
                <i data-lucide="image"></i> Foto Profile
            </label>

            <input type="file" name="photo"
                   class="w-full mt-2 p-3 rounded bg-gray-800">
        </div>

        <!-- NAME -->
        <div>
            <label class="flex items-center gap-2 text-sm text-gray-300">
                <i data-lucide="user"></i> Nama
            </label>

            <input type="text" name="name"
                   value="<?= $profile['name'] ?? '' ?>"
                   class="w-full mt-2 p-3 rounded bg-gray-800 outline-none">
        </div>

        <!-- DESC -->
        <div>
            <label class="flex items-center gap-2 text-sm text-gray-300">
                <i data-lucide="file-text"></i> Deskripsi
            </label>

            <textarea name="description"
                      class="w-full mt-2 p-3 rounded bg-gray-800 h-24"><?= $profile['description'] ?? '' ?></textarea>
        </div>

        <!-- SOCIAL -->
        <div class="grid grid-cols-2 gap-4">

            <div>
                <label class="flex items-center gap-2 text-sm text-gray-300">
                    <i data-lucide="instagram"></i> Instagram
                </label>
                <input type="text" name="instagram"
                       value="<?= $profile['instagram'] ?? '' ?>"
                       class="w-full mt-2 p-3 rounded bg-gray-800">
            </div>

            <div>
                <label class="flex items-center gap-2 text-sm text-gray-300">
                    <i data-lucide="facebook"></i> Facebook
                </label>
                <input type="text" name="facebook"
                       value="<?= $profile['facebook'] ?? '' ?>"
                       class="w-full mt-2 p-3 rounded bg-gray-800">
            </div>

        </div>

        <div>
            <label class="flex items-center gap-2 text-sm text-gray-300">
                <i data-lucide="phone"></i> WhatsApp
            </label>

            <input type="text" name="whatsapp"
                   value="<?= $profile['whatsapp'] ?? '' ?>"
                   class="w-full mt-2 p-3 rounded bg-gray-800">
        </div>

        <div>
            <label class="flex items-center gap-2 text-sm text-gray-300">
                <i data-lucide="mail"></i> Email
            </label>

            <input type="text" name="email"
                   value="<?= $profile['email'] ?? '' ?>"
                   class="w-full mt-2 p-3 rounded bg-gray-800">
        </div>

        <!-- BUTTON -->
        <button type="submit" name="update"
                class="w-full bg-blue-500 py-3 rounded-xl flex items-center justify-center gap-2 hover:bg-blue-600">

            <i data-lucide="save"></i>
            Simpan Perubahan

        </button>

    </form>

</main>

</div>

<script>
lucide.createIcons();
</script>

</body>
</html>