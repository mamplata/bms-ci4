<!-- app/Views/layouts/main.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard' ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        /* Sidebar for desktop */
        #sidebarDesktop {
            width: 250px;
            min-height: 100vh;
        }

        @media (max-width: 767.98px) {

            #mainContent .mobile-header {
                width: 100%;
                /* full width */
            }
        }
    </style>
</head>

<body>
    <div class="d-flex">

        <!-- Desktop Sidebar -->
        <div id="sidebarDesktop" class="d-none d-md-flex flex-column flex-shrink-0 p-3 bg-success text-white">
            <h3>
                <i class="bi bi-house me-2"></i>BMS
            </h3>

            <hr />

            <ul class="nav nav-pills flex-column mb-auto">
                <?php if (session()->get('role_id') == 1) : // Resident 
                ?>
                    <li class="nav-item">
                        <a href="<?= base_url('resident/dashboard') ?>" class="nav-link text-white">
                            <i class="bi bi-house-door-fill me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('resident/profile') ?>" class="nav-link text-white">
                            <i class="bi bi-person-fill me-2"></i> My Profile
                        </a>
                    </li>
                <?php elseif (session()->get('role_id') == 2) : // Staff 
                ?>
                    <li class="nav-item">
                        <a href="<?= base_url('staff/manage-residents') ?>" class="nav-link text-white">
                            <i class="bi bi-people-fill me-2"></i> Manage Residents
                        </a>
                    </li>
                <?php elseif (session()->get('role_id') == 3) : // Admin 
                ?>
                    <li class="nav-item">
                        <a href="<?= base_url('admin/dashboard') ?>" class="nav-link text-white">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('admin/manage-staff') ?>" class="nav-link text-white">
                            <i class="bi bi-person-badge-fill me-2"></i> Manage Staff
                        </a>
                    </li>
                <?php endif; ?>
            </ul>

            <hr>
            <div class="mt-auto">
                <span class="d-block mb-2">
                    <i class="bi bi-person-circle me-1"></i>
                    <?= esc(session()->get('name')) ?>
                </span>

                <a href="<?= base_url('logout') ?>" class="btn btn-outline-light btn-sm w-100">Logout</a>
            </div>
        </div>


        <!-- Mobile Sidebar (Offcanvas) -->
        <div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="sidebarMobile">
            <div class="offcanvas-header bg-success text-white">
                <h5 class="offcanvas-title">Barangay Management System</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body p-0 bg-success text-white d-flex flex-column">
                <ul class="nav nav-pills flex-column mb-auto p-3">
                    <?php if (session()->get('role_id') == 1) : // Resident 
                    ?>
                        <li class="nav-item">
                            <a href="<?= base_url('resident/dashboard') ?>" class="nav-link text-white">
                                <i class="bi bi-house-door-fill me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('resident/profile') ?>" class="nav-link text-white">
                                <i class="bi bi-person-fill me-2"></i> My Profile
                            </a>
                        </li>
                    <?php elseif (session()->get('role_id') == 2) : // Staff 
                    ?>
                        <li class="nav-item">
                            <a href="<?= base_url('staff/manage-residents') ?>" class="nav-link text-white">
                                <i class="bi bi-people-fill me-2"></i> Manage Residents
                            </a>
                        </li>
                    <?php elseif (session()->get('role_id') == 3) : // Admin 
                    ?>
                        <li class="nav-item">
                            <a href="<?= base_url('admin/dashboard') ?>" class="nav-link text-white">
                                <i class="bi bi-speedometer2 me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('admin/manage-staff') ?>" class="nav-link text-white">
                                <i class="bi bi-person-badge-fill me-2"></i> Manage Staff
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>

                <div class="mt-auto p-3">
                    <span class="d-block mb-2">
                        <i class="bi bi-person-circle me-1"></i>
                        <?= esc(session()->get('name')) ?>
                    </span>
                    <a href="<?= base_url('logout') ?>" class="btn btn-outline-light btn-sm w-100">Logout</a>
                </div>
            </div>
        </div>


        <!-- Main content -->
        <div id="mainContent" class="flex-fill bg-light">
            <div class="p-2 d-md-none d-flex align-items-center text-white bg-success">
                <a href="#" class="text-white" data-bs-toggle="offcanvas" data-bs-target="#sidebarMobile">
                    <i class="bi bi-list fs-3"></i>
                </a>
                <span class="ms-3">
                    <h4 class="mb-0"> <i class="bi bi-house me-2"></i> BMS</h4>
                </span>
            </div>

            <div class="p-4">
                <?= $this->renderSection('content') ?>
            </div>
        </div>

    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>