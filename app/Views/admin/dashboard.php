<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Breadcrumb -->
<nav style="--bs-breadcrumb-divider: '>'; font-size: 14px">
    <ol class="breadcrumb mb-2">
        <li class="breadcrumb-item">
            <a href="<?= base_url('admin/dashboard') ?>" class="text-decoration-none text-dark">
                <i class="bi bi-house-door-fill me-1"></i> Dashboard
            </a>
        </li>
    </ol>
</nav>

<hr />

<!-- Page Header -->
<h1 class="h3 mb-3">Admin Dashboard</h1>
<p class="mb-4">Welcome, <?= esc(session()->get('name')) ?>!</p>

<?= $this->endSection() ?>