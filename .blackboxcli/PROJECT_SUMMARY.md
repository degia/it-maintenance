# Project Conversation History

**Last updated**: 2026-06-14T17:05:05.493Z

## Session — 2026-06-14T17:05:05.490Z

**Assistant:** [Empty message]

**User:** Tampilkan kode lengkap untuk file db.php yang terhubung ke database XAMPP

**Assistant:** [Empty message]

**Assistant:** [Empty message]

**Assistant:** [Empty message]

**Assistant:** Here's the complete `db.php` file that connects to your XAMPP MySQL database:

```php
<?php
$host = 'localhost';
$dbname = 'it_maintenance';
$username = 'root'; // Ganti dengan username database Anda
$password = '';     // Ganti dengan password database Anda

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMe

