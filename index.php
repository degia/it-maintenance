<?php
require_once 'includes/auth.php';
require_login();

$page = $_GET['page'] ?? 'home';

$page_title_map = [
    'home'        => 'Dashboard',
    'form'        => 'Form Pemeriksaan Perangkat IT',
    'preventive'  => 'Maintenance Preventive',
    'corrective'  => 'Maintenance Corrective',
    'predictive'  => 'Maintenance Predictive',
    'report'      => 'Report Maintenance',
    'user'          => 'Database User',
    'assets'        => 'Database Assets',
    'sites'         => 'Database Sites',
    'settings'      => 'Database Settings',
    'settings_table'=> 'Settings',
];

$page_path_map = [
    'home'          => __DIR__ . '/pages/home.php',
    'form'          => __DIR__ . '/pages/form.php',
    'preventive'    => __DIR__ . '/pages/maintenance/preventive.php',
    'corrective'    => __DIR__ . '/pages/maintenance/corrective.php',
    'predictive'    => __DIR__ . '/pages/maintenance/predictive.php',
    'report'        => __DIR__ . '/pages/report_maintenance.php',
    'user'          => __DIR__ . '/pages/database/user.php',
    'assets'        => __DIR__ . '/pages/database/assets.php',
    'sites'         => __DIR__ . '/pages/database/sites.php',
    'settings'      => __DIR__ . '/pages/settings.php',
    'settings_table'=> __DIR__ . '/pages/settings_table.php',
];

$title = $page_title_map[$page] ?? 'Dashboard';
$role = get_role();
$current_user = get_full_name();
$role_initial = get_role_initial();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?> - IT Maintenance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="wrapper">
        <?php include 'includes/sidebar.php'; ?>

        <div class="main-content">
            <div class="top-header">
                <div class="page-title">
                    <h4><?= htmlspecialchars($title) ?></h4>
                    <small><?= date('d F Y') ?></small>
                </div>
                <div class="user-info dropdown">
                    <a href="#" class="d-flex align-items-center gap-2 text-decoration-none" data-bs-toggle="dropdown">
                        <span class="text-end">
                            <strong class="d-block text-dark" style="font-size:0.9rem;"><?= htmlspecialchars($current_user) ?></strong>
                            <small class="text-muted"><?= htmlspecialchars($role) ?></small>
                        </span>
                        <div class="avatar"><?= $role_initial ?></div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <li><span class="dropdown-item-text"><strong><?= htmlspecialchars(get_username()) ?></strong></span></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>

            <div class="content-area">
                <?php
                // Handle settings_<table> pattern
                if (strpos($page, 'settings_') === 0) {
                    $table_name = substr($page, 9);
                    $_GET['table'] = $table_name;
                    $page_path = __DIR__ . '/pages/settings_table.php';
                } else {
                    $page_path = $page_path_map[$page] ?? (__DIR__ . '/pages/' . $page . '.php');
                }
                if (file_exists($page_path)) {
                    include $page_path;
                } else {
                    echo '<div class="alert alert-warning">Halaman tidak ditemukan.</div>';
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
