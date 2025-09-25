<?= $this->include('layouts/auth_header') ?>

<h4 class="mb-3">Resident Registration</h4>

<?php if (session()->getFlashdata('message')) : ?>
    <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<form method="post" action="<?= base_url('register') ?>">
    <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <div class="input-group">
            <input type="password" name="password" class="form-control" required>
            <button type="button" class="btn btn-outline-secondary toggle-password">👁</button>
        </div>
    </div>
    <button type="submit" class="btn btn-success w-100">Register</button>
    <div class="mt-3 text-center">
        <a href="<?= base_url('login') ?>">Already have an account? Login</a>
    </div>
</form>

<?= $this->include('layouts/auth_footer') ?>