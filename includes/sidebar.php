<?php
$current_page = $_GET['page'] ?? 'home';
$role = get_role();
?>
<div class="sidebar">
    <div class="sidebar-header">
        <h3>IT Maintenance</h3>
        <small>Management System</small>
    </div>
    <ul class="sidebar-menu">
        <li class="menu-label">Menu</li>
        <li class="nav-item">
            <a href="?page=home" class="nav-link <?= $current_page === 'home' ? 'active' : '' ?>">
                <span class="icon">&#8962;</span> Home
            </a>
        </li>
        <?php if ($role !== 'Viewer'): ?>
        <li class="nav-item">
            <a href="?page=form" class="nav-link <?= $current_page === 'form' ? 'active' : '' ?>">
                <span class="icon">&#9998;</span> Form Pemeriksaan
            </a>
        </li>
        <?php endif; ?>

        <li class="menu-label">Maintenance</li>
        <li class="nav-item">
            <a class="nav-link <?= in_array($current_page, ['preventive', 'corrective', 'predictive']) ? 'active' : '' ?>"
               data-bs-toggle="collapse" href="#subMaintenance" role="button"
               aria-expanded="<?= in_array($current_page, ['preventive', 'corrective', 'predictive']) ? 'true' : 'false' ?>">
                <span class="icon">&#9881;</span> Maintenance
                <span class="arrow">&#9654;</span>
            </a>
            <div class="collapse <?= in_array($current_page, ['preventive', 'corrective', 'predictive']) ? 'show' : '' ?>" id="subMaintenance">
                <ul class="sub-menu">
                    <li>
                        <a href="?page=preventive" class="nav-link <?= $current_page === 'preventive' ? 'active' : '' ?>">
                            &#9672; Preventive
                        </a>
                    </li>
                    <li>
                        <a href="?page=corrective" class="nav-link <?= $current_page === 'corrective' ? 'active' : '' ?>">
                            &#9672; Corrective
                        </a>
                    </li>
                    <li>
                        <a href="?page=predictive" class="nav-link <?= $current_page === 'predictive' ? 'active' : '' ?>">
                            &#9672; Predictive
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <?php if ($role !== 'User'): ?>
        <li class="nav-item">
            <a href="?page=report" class="nav-link <?= $current_page === 'report' ? 'active' : '' ?>">
                <span class="icon">&#128202;</span> Report Maintenance
            </a>
        </li>
        <?php endif; ?>

        <?php if (in_array($role, ['Administrator', 'Technician'])): ?>
        <li class="menu-label">Database</li>
        <li class="nav-item">
            <a class="nav-link <?= in_array($current_page, ['user', 'assets', 'sites']) ? 'active' : '' ?>"
               data-bs-toggle="collapse" href="#subDatabase" role="button"
               aria-expanded="<?= in_array($current_page, ['user', 'assets', 'sites']) ? 'true' : 'false' ?>">
                <span class="icon">&#128451;</span> Database
                <span class="arrow">&#9654;</span>
            </a>
            <div class="collapse <?= in_array($current_page, ['user', 'assets', 'sites']) ? 'show' : '' ?>" id="subDatabase">
                <ul class="sub-menu">
                    <li>
                        <a href="?page=user" class="nav-link <?= $current_page === 'user' ? 'active' : '' ?>">
                            &#9672; User
                        </a>
                    </li>
                    <li>
                        <a href="?page=assets" class="nav-link <?= $current_page === 'assets' ? 'active' : '' ?>">
                            &#9672; Assets
                        </a>
                    </li>
                    <li>
                        <a href="?page=sites" class="nav-link <?= $current_page === 'sites' ? 'active' : '' ?>">
                            &#9672; Sites
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <?php endif; ?>

        <?php if (in_array($role, ['Administrator', 'Technician'])): ?>
        <li class="menu-label">Settings</li>
        <li class="nav-item">
            <a href="?page=settings" class="nav-link <?= $current_page === 'settings' || strpos($current_page, 'settings_') === 0 ? 'active' : '' ?>">
                <span class="icon">&#9881;</span> Database Settings
            </a>
        </li>
        <?php endif; ?>
    </ul>

    <div class="sidebar-footer p-3 border-top border-light border-opacity-10">
        <a href="logout.php" class="nav-link d-flex align-items-center gap-2" style="color:#94a3b8;font-size:0.85rem;">
            <span>&#10149;</span> Logout
        </a>
    </div>
</div>
