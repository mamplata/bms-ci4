<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!-- Breadcrumb -->
<nav style="--bs-breadcrumb-divider: '>'; font-size: 14px">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="<?= base_url('admin/dashboard') ?>" class="text-decoration-none text-dark">
                <i class="bi bi-house-door-fill me-1"></i> Dashboard
            </a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            <i class="bi bi-person-circle me-1"></i> Manage Staff
        </li>
    </ol>
</nav>
<hr />

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0"><i class="bi bi-people-fill me-2"></i>Manage Staff</h3>
        <a href="<?= site_url('admin/create-staff') ?>" class="btn btn-success">
            <i class="bi bi-person-plus-fill me-1"></i> Add Staff
        </a>
    </div>

    <!-- Flash messages -->
    <?php if (session()->getFlashdata('message')) : ?>
        <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
    <?php elseif (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <?= view('components/base_table', [
                'id' => 'staffTable',
                'ajaxUrl' => site_url('admin/staff-data'),
                'columns' => [
                    ['data' => 'name', 'title' => 'Name'],
                    ['data' => 'email', 'title' => 'Email'],
                    ['data' => 'created_at', 'title' => 'Created At', 'type' => 'date'],
                    ['data' => 'id', 'title' => 'Actions', 'type' => 'actions', 'actions' => [
                        ['type' => 'edit', 'url' => site_url('admin/edit-staff')],
                        ['type' => 'delete', 'url' => site_url('admin/delete-staff'), 'confirm' => 'Delete {name}?']
                    ]]
                ]
            ]) ?>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>