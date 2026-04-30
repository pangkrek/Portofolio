<?php
session_start();
require_once '../db.php';

if (isset($_SESSION['login'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['login'] = true;
        $_SESSION['username'] = $user['username'];

        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Admin</title>
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
<body class="flex items-center justify-center min-h-screen text-white">

<!-- CARD -->
<div class="w-full max-w-md p-8 bg-white/10 backdrop-blur-xl rounded-2xl shadow-2xl">

    <!-- HEADER -->
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold">Admin Login</h1>
        <p class="text-gray-300 text-sm">Masuk untuk mengelola portfolio</p>
    </div>

    <!-- ERROR -->
    <?php if ($error): ?>
        <div class="bg-red-500/80 text-white p-3 rounded mb-4 text-sm text-center">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <!-- FORM -->
    <form method="POST" class="space-y-5">

        <!-- USERNAME -->
        <div>
            <label class="text-sm text-gray-300">Username</label>
            <input 
                type="text" 
                name="username" 
                required
                class="w-full mt-1 p-3 rounded-lg bg-white/10 border border-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-400"
                placeholder="Masukkan username"
            >
        </div>

        <!-- PASSWORD -->
        <div>
            <label class="text-sm text-gray-300">Password</label>
            <input 
                type="password" 
                name="password" 
                required
                class="w-full mt-1 p-3 rounded-lg bg-white/10 border border-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-400"
                placeholder="Masukkan password"
            >
        </div>

        <!-- BUTTON -->
        <button 
            type="submit" 
            name="login"
            class="w-full py-3 rounded-lg bg-gradient-to-r from-blue-500 to-purple-500 hover:opacity-90 transition font-semibold"
        >
            Login
        </button>

    </form>

    <!-- FOOTER -->
    <div class="text-center mt-6 text-sm text-gray-400">
        © <?= date('Y'); ?> Pangkrek
    </div>

</div>

</body>
</html>