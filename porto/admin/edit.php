<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

require_once '../db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: dashboard.php");
    exit;
}

// ambil data lama
$stmt = $conn->prepare("SELECT * FROM projects WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    header("Location: dashboard.php");
    exit;
}

$error = "";
$success = "";

if (isset($_POST['update'])) {

    $title = trim($_POST['title']);
    $desc  = trim($_POST['desc']);
    $link  = trim($_POST['link']);

    $oldImage = $data['image'];
    $newName = $oldImage;

    // cek upload baru
    if (!empty($_FILES['image']['name'])) {

        $imageName = $_FILES['image']['name'];
        $tmpName   = $_FILES['image']['tmp_name'];

        $allowed = ['jpg','jpeg','png','webp'];
        $ext = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            $error = "Format gambar tidak didukung!";
        } else {

            $newName = time() . '_' . uniqid() . '.' . $ext;
            $targetDir = __DIR__ . "/../img/";

            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            if (move_uploaded_file($tmpName, $targetDir . $newName)) {

                // hapus gambar lama
                if (!empty($oldImage) && file_exists($targetDir . $oldImage)) {
                    unlink($targetDir . $oldImage);
                }

            } else {
                $error = "Gagal upload gambar!";
            }
        }
    }

    if (!$error) {
        $stmt = $conn->prepare("UPDATE projects SET title=?, description=?, image=?, link=? WHERE id=?");
        $stmt->bind_param("ssssi", $title, $desc, $newName, $link, $id);

        if ($stmt->execute()) {
            $success = "Project berhasil diupdate!";
            header("Refresh:1; url=dashboard.php");
        } else {
            $error = "Gagal update data!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Project</title>

<script src="https://cdn.tailwindcss.com"></script>

<style>
body {
  background: linear-gradient(270deg, #0f172a, #1e3a8a, #9333ea, #0f172a);
  background-size: 800% 800%;
  animation: gradientMove 15s ease infinite;
}
@keyframes gradientMove {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}
</style>

</head>

<body class="bg-gray-950 text-white">

<div class="flex min-h-screen">

  <!-- SIDEBAR -->
  <aside class="w-64 bg-gray-900 border-r border-gray-800 flex flex-col p-6">

      <div class="flex items-center gap-3 mb-10">
          <img src="../img/logo.png" class="w-10 h-10 rounded">
          <h2 class="text-xl font-bold">PangkrekPanel</h2>
      </div>

      <nav class="flex flex-col gap-3 text-sm text-gray-400">

          <a href="dashboard.php" class="px-3 py-2 rounded hover:bg-gray-800 hover:text-white">
              🏠 Dashboard
          </a>

          <a href="tambah.php" class="px-3 py-2 rounded hover:bg-gray-800 hover:text-white">
              ➕ Tambah Project
          </a>

          <a href="edit_profile.php" class="px-3 py-2 rounded hover:bg-gray-800 hover:text-white">
              👤 Edit Profile
          </a>

          <a href="logout.php" class="px-3 py-2 rounded text-red-400 hover:bg-red-500 hover:text-white">
              🚪 Logout
          </a>

      </nav>

  </aside>

  <!-- MAIN -->
  <main class="flex-1 p-8">

    <h1 class="text-3xl font-bold mb-6">Edit Project</h1>

    <?php if ($error): ?>
        <div class="bg-red-500 p-3 rounded mb-4"><?= $error ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="bg-green-500 p-3 rounded mb-4"><?= $success ?></div>
    <?php endif; ?>

    <div class="bg-white/10 backdrop-blur-xl p-6 rounded-2xl max-w-xl">

        <form method="POST" enctype="multipart/form-data" class="space-y-5">

            <div>
                <label class="text-sm text-gray-300">Judul Project</label>
                <input type="text" name="title" required
                    value="<?= htmlspecialchars($data['title']) ?>"
                    class="w-full mt-1 p-3 rounded bg-gray-800 border border-gray-700">
            </div>

            <div>
                <label class="text-sm text-gray-300">Deskripsi</label>
                <textarea name="desc" rows="4"
                    class="w-full mt-1 p-3 rounded bg-gray-800 border border-gray-700"><?= htmlspecialchars($data['description']) ?></textarea>
            </div>

            <div>
                <label class="text-sm text-gray-300">Link</label>
                <input type="text" name="link"
                    value="<?= htmlspecialchars($data['link']) ?>"
                    class="w-full mt-1 p-3 rounded bg-gray-800 border border-gray-700">
            </div>

            <div>
                <label class="text-sm text-gray-300">Gambar Sekarang</label>
                <img src="../img/<?= $data['image'] ?>" 
                     class="w-full h-40 object-cover rounded mb-2">
            </div>

            <div>
                <label class="text-sm text-gray-300">Ganti Gambar</label>
                <input type="file" name="image" accept="image/*"
                       onchange="previewImage(event)">
            </div>

            <img id="preview" class="hidden w-full h-40 object-cover rounded">

            <div class="flex gap-4">
                <button name="update"
                    class="bg-yellow-500 px-6 py-2 rounded hover:bg-yellow-600">
                    Update
                </button>

                <a href="dashboard.php"
                    class="bg-gray-700 px-6 py-2 rounded hover:bg-gray-600">
                    Kembali
                </a>
            </div>

        </form>

    </div>

  </main>

</div>

<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('preview');

    if (input.files && input.files[0]) {
        preview.src = URL.createObjectURL(input.files[0]);
        preview.classList.remove('hidden');
    }
}
</script>

</body>
</html>