<?php
include 'db.php';
$nama=$_POST['nama'];
$email=$_POST['email'];
$pesan=$_POST['pesan'];
$conn->query("INSERT INTO messages (nama,email,pesan) VALUES ('$nama','$email','$pesan')");
echo "<script>alert('Pesan terkirim');window.location='index.php';</script>";
?>