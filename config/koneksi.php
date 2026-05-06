<?php
// Ubah "localhost" jadi "127.0.0.1" agar tidak bentrok socket di Mac
$host = "127.0.0.1"; 
$user = "root";
$pass = ""; // Kosongkan jika belum pernah ganti password di PHPMyAdmin
$db   = "db_absensi";

// Tambahkan port 3306 (default MySQL XAMPP) jika perlu
$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    // Ini akan kasih tau error spesifiknya apa
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>