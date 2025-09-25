<?= $this->include('layouts/auth_header') ?>

<h4 class="mb-3">Reset Password</h4>

<?php if (session()->getFlashdata('message')) : ?>
    <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<form method="post" action="<?= base_url('reset-password') ?>">
    <input type="hidden" name="token" value="<?= $token ?>">
    <div class="mb-3">
        <label class="form-label">New Password</label>
        <div class="input-group">
            <input type="password" name="password" class="form-control" required>
            <button type="button" class="btn btn-outline-secondary toggle-password">👁</button>
        </div>
    </div>
    <button type="submit" class="btn btn-success w-100">Update Password</button>
    <div class="mt-3 text-center">
        <a href="<?= base_url('/') ?>">Back to Login</a>
    </div>
</form>

<?= $this->include('layouts/auth_footer') ?>