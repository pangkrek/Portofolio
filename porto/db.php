
<?php
$conn = new mysqli("localhost", "root", "", "porto");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>