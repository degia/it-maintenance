<?php
$host = 'localhost';
$dbname = 'it_maintenance'; // Pastikan nama ini sama dengan database yang Anda buat
$username = 'root';         // Ganti jika username Anda berbeda (default XAMPP: root)
$password = '';             // Ganti jika Anda memberi password (default XAMPP: kosong)

try {
    // Mencoba membuat koneksi menggunakan PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

    // Mengatur mode error agar mudah dideteksi jika ada masalah
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Jika berhasil, tampilkan pesan sukses
    echo "<h3 style='color: green;'>✅ SUKSES: Koneksi ke database '{$dbname}' berhasil!</h3>";
    echo "<p>Server MySQL berjalan dengan baik di host: {$host}</p>";
} catch (PDOException $e) {
    // Jika gagal, tampilkan pesan error
    echo "<h3 style='color: red;'>❌ GAGAL: Koneksi ke database gagal!</h3>";
    echo "<p><strong>Pesan Error:</strong> " . $e->getMessage() . "</p>";
    echo "<p>Silakan periksa kembali nama database, username, password, atau pastikan service MySQL sudah dijalankan.</p>";
}
