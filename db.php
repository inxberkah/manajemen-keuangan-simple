<?php

$host = 'localhost'; // Ganti dengan nama host database Anda
$username = 'root'; // Ganti dengan nama pengguna database Anda
$password = ''; // Ganti dengan kata sandi database Anda
$database = 'keuangan'; // Ganti dengan nama database Anda

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Koneksi Gagal: " . $conn->connect_error);
}

// Buat tabel keuangan jika belum ada
$query = "CREATE TABLE IF NOT EXISTS keuangan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tanggal DATE NOT NULL,
    keterangan VARCHAR(255),
    pemasukan DECIMAL(10, 2),
    pengeluaran DECIMAL(10, 2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$conn->query($query);

?>
