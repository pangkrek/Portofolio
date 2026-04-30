<?php
include 'db.php';
$profile = $conn->query("SELECT * FROM profile LIMIT 1")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Portfolio <?= htmlspecialchars($profile['name'] ?? 'Saya') ?></title>

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/lucide@latest"></script>

<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

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

<body class="text-white font-sans pt-20">

<!-- NAVBAR -->
<nav class="fixed top-0 left-0 w-full z-50 bg-gray-900/70 backdrop-blur border-b border-gray-800">
  <div class="flex justify-between items-center p-4 max-w-6xl mx-auto">
    <div class="flex items-center gap-3">
      <img src="img/<?= $profile['photo'] ?? 'profile.jpg' ?>" class="w-10 h-10 rounded-full">
      <span class="font-semibold"><?= htmlspecialchars($profile['name']) ?></span>
    </div>

    <div class="space-x-6 text-sm text-gray-300">
      <a href="#">Home</a>
      <a href="#about">About</a>
      <a href="#project">Project</a>
      <a href="#experience">Experience</a>
      <a href="#contact">Contact</a>
    </div>
  </div>
</nav>

<!-- HERO -->
<section class="max-w-6xl mx-auto grid md:grid-cols-2 gap-10 items-center px-6 py-20">

  <div data-aos="fade-right">
    <h1 class="text-5xl font-bold mb-4">
      Halo, Saya <span class="text-blue-400"><?= htmlspecialchars($profile['name']) ?></span>
    </h1>

    <p class="text-gray-300 mb-6">
      <?= htmlspecialchars($profile['description']) ?>
    </p>

    <div class="flex gap-4">
      <a href="#project" class="bg-blue-500 px-6 py-2 rounded">Project</a>

      <?php if (!empty($profile['whatsapp'])): ?>
      <a href="https://wa.me/<?= $profile['whatsapp'] ?>" target="_blank"
         class="bg-green-500 px-6 py-2 rounded">
        Hire Me
      </a>
      <?php endif; ?>
    </div>
  </div>

  <div data-aos="fade-left">
    <img src="img/<?= $profile['photo'] ?? 'profile.jpg' ?>" class="rounded-2xl">
  </div>

</section>

<!-- ABOUT -->
<section id="about" class="max-w-6xl mx-auto px-6 py-16" data-aos="fade-up">
  <h2 class="text-3xl mb-6">Tentang Saya</h2>

  <div class="bg-white/10 p-6 rounded-2xl backdrop-blur">
    <p><?= htmlspecialchars($profile['description']) ?></p>
  </div>
</section>

<!-- PROJECT -->
<section id="project" class="max-w-6xl mx-auto px-6 py-16">
<h2 class="text-3xl mb-10" data-aos="fade-up">Project Saya</h2>

<div class="grid md:grid-cols-3 gap-6">

<?php
$result = $conn->query("SELECT * FROM projects ORDER BY id DESC");

while($row = $result->fetch_assoc()):
$imagePath = "img/" . $row['image'];
if (!file_exists($imagePath)) $imagePath = "https://via.placeholder.com/400";
?>

<div class="group bg-white/10 p-5 rounded-2xl hover:scale-105 transition" data-aos="zoom-in">

  <img src="<?= $imagePath ?>" class="rounded mb-3 h-40 w-full object-cover">

  <h3 class="font-bold"><?= htmlspecialchars($row['title']) ?></h3>
  <p class="text-sm text-gray-300"><?= htmlspecialchars($row['description']) ?></p>

  <div class="opacity-0 group-hover:opacity-100">
    <a href="<?= $row['link'] ?>" target="_blank" class="text-blue-400 text-sm">
      Lihat →
    </a>
  </div>

</div>

<?php endwhile; ?>

</div>
</section>
<!-- SKILL -->
<section class="max-w-6xl mx-auto px-6 py-16" data-aos="fade-up">
  <h2 class="text-3xl mb-8">Skill</h2>

  <div class="space-y-4">
    <div>
      <p>HTML</p>
      <div class="bg-gray-700 h-2 rounded">
        <div class="bg-blue-500 h-2 rounded w-[90%]"></div>
      </div>
    </div>

    <div>
      <p>PHP</p>
      <div class="bg-gray-700 h-2 rounded">
        <div class="bg-green-500 h-2 rounded w-[80%]"></div>
      </div>
    </div>

    <div>
      <p>MySQL</p>
      <div class="bg-gray-700 h-2 rounded">
        <div class="bg-yellow-500 h-2 rounded w-[75%]"></div>
      </div>
    </div>
  </div>
</section>
<!-- EXPERIENCE -->
<section id="experience" class="max-w-6xl mx-auto px-6 py-16">
<h2 class="text-3xl mb-8" data-aos="fade-up">Pengalaman</h2>

<div class="space-y-6">

<div class="bg-white/10 p-5 rounded-xl" data-aos="fade-up">
  <h3 class="font-bold">Freelance Web Developer</h3>
  <p class="text-gray-400 text-sm">2024 - Sekarang</p>
  <p class="text-gray-300 mt-2">Membuat website untuk client.</p>
</div>

<div class="bg-white/10 p-5 rounded-xl" data-aos="fade-up">
  <h3 class="font-bold">Frontend Developer</h3>
  <p class="text-gray-400 text-sm">2023 - 2024</p>
  <p class="text-gray-300 mt-2">Fokus UI modern.</p>
</div>

</div>
</section>

<!-- EDUCATION -->
<section class="max-w-6xl mx-auto px-6 py-16">
<h2 class="text-3xl mb-8" data-aos="fade-up">Pendidikan</h2>

<div class="space-y-6">

<div class="bg-white/10 p-5 rounded-xl" data-aos="fade-up">
  <h3 class="font-bold">SMK RPL</h3>
  <p class="text-gray-400 text-sm">2020 - 2023</p>
</div>

<div class="bg-white/10 p-5 rounded-xl" data-aos="fade-up">
  <h3 class="font-bold">Belajar Web Dev</h3>
  <p class="text-gray-400 text-sm">2023 - Sekarang</p>
</div>

</div>
</section>

<!-- CONTACT -->
<section id="contact" class="text-center py-16" data-aos="fade-up">
<h2 class="text-3xl mb-6">Hubungi Saya</h2>

<div class="flex justify-center gap-6">

<?php if ($profile['facebook']): ?>
<a href="<?= $profile['facebook'] ?>" target="_blank"><i data-lucide="facebook"></i></a>
<?php endif; ?>

<?php if ($profile['instagram']): ?>
<a href="<?= $profile['instagram'] ?>" target="_blank"><i data-lucide="instagram"></i></a>
<?php endif; ?>

<?php if ($profile['whatsapp']): ?>
<a href="https://wa.me/<?= $profile['whatsapp'] ?>" target="_blank"><i data-lucide="phone"></i></a>
<?php endif; ?>

<?php if ($profile['email']): ?>
<a href="mailto:<?= $profile['email'] ?>"><i data-lucide="mail"></i></a>
<?php endif; ?>

</div>
</section>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init();
lucide.createIcons();
</script>

</body>
</html>