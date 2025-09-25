<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<nav style="--bs-breadcrumb-divider: '>'; font-size: 14px">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="<?= base_url('resident/dashboard') ?>" class="text-decoration-none text-dark">
                <i class="bi bi-house-door-fill me-1"></i> Dashboard
            </a>
        </li>
    </ol>
</nav>
<hr />
<h1>Resident Dashboard</h1>
<p>Welcome, <?= esc($name) ?>!</p>
<a href="<?= base_url('resident/profile') ?>" class="btn btn-success">My Profile</a>
<?= $this->endSection() ?>