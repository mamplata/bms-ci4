<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h3>System Logs</h3>

    <?php if (session()->getFlashdata('message')) : ?>
        <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
    <?php elseif (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <?php
    $headers = ['User ID', 'Action', 'IP Address', 'User Agent', 'Date'];
    $rows = '';
    foreach ($logs as $log) {
        $rows .= '<tr>';
        $rows .= '<td>' . esc($log['user_id']) . '</td>';
        $rows .= '<td>' . esc($log['action']) . '</td>';
        $rows .= '<td>' . esc($log['ip_address']) . '</td>';
        $rows .= '<td>' . esc($log['user_agent']) . '</td>';
        $rows .= '<td>' . esc($log['created_at']) . '</td>';
        $rows .= '</tr>';
    }
    ?>

    <?= $this->include('components/datatable', [
        'id' => 'logsTable',
        'headers' => $headers,
        'rows' => $rows
    ]) ?>
</div>

<?= $this->endSection() ?>