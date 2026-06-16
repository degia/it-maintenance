<?php
require_once __DIR__ . '/../db.php';

$users = [
    ['admin',   'admin123',   'Administrator',    'Administrator'],
    ['teknisi', 'teknisi123', 'Fransiskus Simson', 'Technician'],
    ['viewer',  'viewer123',  'Nurcahyo S. Utomo', 'Viewer'],
    ['user',    'user123',    'Regil Yanwar F.',   'User'],
];

$stmt = $pdo->prepare("INSERT IGNORE INTO users (username, password, full_name, role) VALUES (?, ?, ?, ?)");

foreach ($users as $u) {
    $hashed = password_hash($u[1], PASSWORD_DEFAULT);
    $stmt->execute([$u[0], $hashed, $u[2], $u[3]]);
    echo "User '{$u[0]}' ({$u[3]}) created.\n";
}

echo "\nDone. All users seeded.\n";
