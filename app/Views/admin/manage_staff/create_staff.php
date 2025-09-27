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
        <li class="breadcrumb-item">
            <a href="<?= base_url('admin/manage-staff') ?>" class="text-decoration-none text-dark">
                <i class="bi bi-people-fill me-1"></i> Manage Staff
            </a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            <i class="bi bi-person-plus-fill me-1"></i> Create Staff
        </li>
    </ol>
</nav>
<hr />

<!-- Flash messages -->
<?php if (session()->getFlashdata('message')) : ?>
    <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
<?php elseif (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<?php
$fields = [
    ['name' => 'name', 'label' => 'Full Name', 'type' => 'text', 'value' => old('name'), 'required' => true],
    ['name' => 'email', 'label' => 'Email Address', 'type' => 'email', 'value' => old('email'), 'required' => true],
    ['name' => 'password', 'label' => 'Password', 'type' => 'password', 'value' => '', 'required' => true]
];

$buttons = [
    ['type' => 'link', 'class' => 'btn-secondary', 'icon' => 'bi-arrow-left', 'text' => 'Back', 'url' => base_url('admin/manage-staff')],
    ['type' => 'submit', 'class' => 'btn-success', 'icon' => 'bi-check-circle', 'text' => 'Save']
];
?>

<div class="container-fluid py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-success text-white"><i class="bi bi-person-plus-fill me-2"></i> Create Staff</div>
        <div class="card-body">
            <?= view('components/base_form', [
                'action' => site_url('admin/create-staff'),
                'fields' => $fields,
                'buttons' => $buttons,
                'validation' => $validation ?? null
            ]) ?>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>