<!-- app/Views/layouts/main.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=7">
    <meta name="csrf_token" content="<?= csrf_token() ?>">
    <meta name="csrf_hash" content="<?= csrf_hash() ?>">
    <title><?= $title ?? 'Dashboard' ?> | BMS</title>

    <!-- Bootstrap & Icons -->
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/bootstrap-icons.css') ?>" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.6/css/responsive.bootstrap5.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/main.css') ?>">
</head>

<body class="bg-light">

    <!-- Desktop Sidebar -->
    <div id="sidebarDesktop" class="d-none d-md-flex flex-column p-3">
        <div class="d-flex align-items-center mb-3">
            <img src="<?= base_url('assets/img/logo.svg') ?>" alt="BMS Logo" class="logo-img me-2">
            <div class="d-flex flex-column text-center brand-title">
                <span>BARANGAY</span>
                <span>MS</span>
            </div>
        </div>
        <hr />

        <ul class="nav nav-pills flex-column mb-auto">
            <?php
            $roleId = session()->get('role_id');
            $currentUrl = current_url();
            function isActive($url, $currentUrl)
            {
                return strpos($currentUrl, $url) !== false ? 'active' : '';
            }
            ?>

            <?php if ($roleId == 1) : ?>
                <li>
                    <a href="<?= base_url('resident/dashboard') ?>" class="nav-link text-white sidebar-link <?= isActive('resident/dashboard', $currentUrl) ?>">
                        <i class="bi bi-house-door-fill me-2"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('resident/profile') ?>" class="nav-link text-white sidebar-link <?= isActive('resident/profile', $currentUrl) ?>">
                        <i class="bi bi-person-fill me-2"></i> My Profile
                    </a>
                </li>
            <?php elseif ($roleId == 2) : ?>
                <li>
                    <a href="<?= base_url('staff/manage-residents') ?>" class="nav-link text-white sidebar-link <?= isActive('staff/manage-residents', $currentUrl) ?>">
                        <i class="bi bi-people-fill me-2"></i> Manage Residents
                    </a>
                </li>
            <?php elseif ($roleId == 3) : ?>
                <li>
                    <a href="<?= base_url('admin/dashboard') ?>" class="nav-link text-white sidebar-link <?= isActive('admin/dashboard', $currentUrl) ?>">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/manage-staff') ?>" class="nav-link text-white sidebar-link <?= isActive('admin/manage-staff', $currentUrl) ?>">
                        <i class="bi bi-person-badge-fill me-2"></i> Manage Staff
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/system-logs') ?>" class="nav-link text-white sidebar-link <?= isActive('admin/system-logs', $currentUrl) ?>">
                        <i class="bi bi-card-checklist me-2"></i> System Logs
                    </a>
                </li>
            <?php endif; ?>
        </ul>

        <hr>
        <div class="mt-auto">
            <div class="d-flex align-items-center mb-2">
                <i class="bi bi-person-circle me-2 fs-5"></i>
                <span><?= esc(session()->get('name')) ?></span>
            </div>
            <a href="<?= base_url('logout') ?>" class="btn btn-outline-light btn-sm w-100">Logout</a>
        </div>
    </div>

    <!-- Mobile Sidebar (Offcanvas) -->
    <div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="sidebarMobile">
        <div class="offcanvas-header bg-success text-white">
            <img src="<?= base_url('assets/img/logo.svg') ?>" alt="BMS Logo" class="logo-img-sm me-2">
            <span class="brand-title-sm">BARANGAY MS</span>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-0 bg-success text-white d-flex flex-column">
            <ul class="nav nav-pills flex-column p-3">
                <!-- same links as desktop -->
                <?php if ($roleId == 1) : ?>
                    <li>
                        <a href="<?= base_url('resident/dashboard') ?>" class="nav-link text-white sidebar-link <?= isActive('resident/dashboard', $currentUrl) ?>">
                            <i class="bi bi-house-door-fill me-2"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('resident/profile') ?>" class="nav-link text-white sidebar-link <?= isActive('resident/profile', $currentUrl) ?>">
                            <i class="bi bi-person-fill me-2"></i> My Profile
                        </a>
                    </li>
                <?php elseif ($roleId == 2) : ?>
                    <li>
                        <a href="<?= base_url('staff/manage-residents') ?>" class="nav-link text-white sidebar-link <?= isActive('staff/manage-residents', $currentUrl) ?>">
                            <i class="bi bi-people-fill me-2"></i> Manage Residents
                        </a>
                    </li>
                <?php elseif ($roleId == 3) : ?>
                    <li>
                        <a href="<?= base_url('admin/dashboard') ?>" class="nav-link text-white sidebar-link <?= isActive('admin/dashboard', $currentUrl) ?>">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('admin/manage-staff') ?>" class="nav-link text-white sidebar-link <?= isActive('admin/manage-staff', $currentUrl) ?>">
                            <i class="bi bi-person-badge-fill me-2"></i> Manage Staff
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('admin/system-logs') ?>" class="nav-link text-white sidebar-link <?= isActive('admin/system-logs', $currentUrl) ?>">
                            <i class="bi bi-card-checklist me-2"></i> System Logs
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
            <div class="p-3">
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-person-circle me-2 fs-5"></i>
                    <span><?= esc(session()->get('name')) ?></span>
                </div>
                <a href="<?= base_url('logout') ?>" class="btn btn-outline-light btn-sm w-100">Logout</a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div id="mainContent">
        <!-- Mobile Header -->
        <div class="p-2 d-md-none d-flex align-items-center text-white bg-success">
            <a href="#" class="text-white me-2" data-bs-toggle="offcanvas" data-bs-target="#sidebarMobile">
                <i class="bi bi-list fs-3"></i>
            </a>
            <img src="<?= base_url('assets/img/logo.svg') ?>" alt="BMS Logo" class="logo-img-sm me-2">
            <span class="brand-title-sm">BARANGAY MS</span>
        </div>


        <!-- Scripts -->
        <script src="<?= base_url('assets/js/jquery-3.7.1.min.js') ?>"></script>
        <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
        <script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.js"></script>
        <script src="https://cdn.datatables.net/responsive/3.0.6/js/dataTables.responsive.js"></script>
        <script src="https://cdn.datatables.net/responsive/3.0.6/js/responsive.bootstrap5.js"></script>

        <!-- Page Content -->
        <div class="p-4">
            <?= $this->renderSection('content') ?>
        </div>
    </div>

</body>

</html>