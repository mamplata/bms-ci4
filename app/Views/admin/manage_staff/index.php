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
            <table id="staffTable" class="table table-hover table-striped align-middle nowrap" style="width: 100%">
                <thead class="table-success">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created At</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        let isMobile = window.innerWidth < 768;
        $('#staffTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?= site_url('admin/staff-data') ?>",
                type: "POST",
                data: function(d) {
                    // Always grab the latest token from meta
                    let csrfToken = $('meta[name="csrf_token"]').attr('content');
                    let csrfHash = $('meta[name="csrf_hash"]').attr('content');
                    d[csrfToken] = csrfHash;
                },
                dataSrc: function(json) {
                    // Update the CSRF hash after each response
                    if (json.csrf) {
                        $('meta[name="csrf_token"]').attr('content', json.csrf.token);
                        $('meta[name="csrf_hash"]').attr('content', json.csrf.hash);
                    }
                    return json.data;
                }
            },
            columns: [{
                    data: 'name'
                },
                {
                    data: 'email'
                },
                {
                    data: null,
                    render: function() {
                        return `<span class="badge bg-primary">Staff</span>`;
                    }
                },
                {
                    data: 'created_at',
                    render: function(data) {
                        return new Date(data).toISOString().slice(0, 10);
                    }
                },
                {
                    data: 'id',
                    className: "text-center",
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `
                        <a href="<?= site_url('admin/edit-staff') ?>/${data}" 
                           class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <button type="button" 
                                class="btn btn-sm btn-outline-danger"
                                onclick="openDeleteModal('<?= site_url('admin/delete-staff') ?>/${data}', 'Delete ${row.name}?')">
                            <i class="bi bi-trash"></i>
                        </button>`;
                    }
                }
            ],
            responsive: true,
            scrollX: true,
            scrollY: "400px",
            scrollCollapse: true,
            paging: true,
            language: {
                search: "",
                searchPlaceholder: "🔍 Search staff...",
            },
            columnDefs: [{
                targets: isMobile ? 1 : -1, // last column (actions)
                orderable: false,
                searchable: false,
                responsivePriority: 1,
            }]
        });
    });
</script>

<?= view('components/delete_modal') ?>
<?= $this->endSection(); ?>