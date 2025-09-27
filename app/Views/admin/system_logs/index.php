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
            <i class="bi bi-person-circle me-1"></i> System Logs
        </li>
    </ol>
</nav>
<hr />

<div class="container-fluid py-4">
    <h3 class="mb-3"><i class="bi bi-card-checklist me-2"></i>System Logs</h3>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <?= view('components/base_table', [
                'id' => 'logsTable',
                'ajaxUrl' => site_url('admin/logs-data'),
                'columns' => [
                    ['data' => 'user_name', 'title' => 'User Name'],
                    ['data' => 'action', 'title' => 'Action'],
                    ['data' => 'ip_address', 'title' => 'IP Address'],
                    ['data' => 'user_agent', 'title' => 'User Agent'],
                    ['data' => 'created_at', 'title' => 'Created At', 'type' => 'date']
                ]
            ]) ?>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>