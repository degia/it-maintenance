<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function is_logged_in(): bool {
    return isset($_SESSION['user_id']);
}

function require_login(): void {
    if (!is_logged_in()) {
        header("Location: login.php");
        exit;
    }
}

function get_role(): string {
    return $_SESSION['user_role'] ?? '';
}

function get_full_name(): string {
    return $_SESSION['user_name'] ?? '';
}

function get_username(): string {
    return $_SESSION['username'] ?? '';
}

function role_at_least(string $min_role): bool {
    $levels = ['User' => 1, 'Viewer' => 2, 'Technician' => 3, 'Administrator' => 4];
    $user_level = $levels[get_role()] ?? 0;
    $required_level = $levels[$min_role] ?? 0;
    return $user_level >= $required_level;
}

function has_access(array $allowed_roles): bool {
    return in_array(get_role(), $allowed_roles);
}

function get_role_initial(): string {
    $name = get_full_name();
    return strtoupper(substr($name, 0, 1));
}
