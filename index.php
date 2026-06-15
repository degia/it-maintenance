<?php
$page = $_GET['page'] ?? 'home';

$page_title_map = [
    'home'        => 'Dashboard',
    'form'        => 'Form Pemeriksaan Perangkat IT',
    'preventive'  => 'Maintenance Preventive',
    'corrective'  => 'Maintenance Corrective',
    'predictive'  => 'Maintenance Predictive',
    'report'      => 'Report Maintenance',
    'user'        => 'Database User',
    'assets'      => 'Database Assets',
    'sites'       => 'Database Sites',
];

$page_path_map = [
    'home'        => __DIR__ . '/pages/home.php',
    'form'        => __DIR__ . '/pages/form.php',
    'preventive'  => __DIR__ . '/pages/maintenance/preventive.php',
    'corrective'  => __DIR__ . '/pages/maintenance/corrective.php',
    'predictive'  => __DIR__ . '/pages/maintenance/predictive.php',
    'report'      => __DIR__ . '/pages/report_maintenance.php',
    'user'        => __DIR__ . '/pages/database/user.php',
    'assets'      => __DIR__ . '/pages/database/assets.php',
    'sites'       => __DIR__ . '/pages/database/sites.php',
];

$title = $page_title_map[$page] ?? 'Dashboard';
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
                <div class="user-info">
                    <span>Administrator</span>
                    <div class="avatar">A</div>
                </div>
            </div>

            <div class="content-area">
                <?php
                $page_path = $page_path_map[$page] ?? (__DIR__ . '/pages/' . $page . '.php');
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
