<?php

/**
 * Dynamic Base Table Component
 * Params:
 * - $id: string, table ID
 * - $ajaxUrl: string, server-side ajax URL
 * - $columns: array, column definitions:
 *      [
 *          'data' => 'field_name', // key from JSON
 *          'title' => 'Column Title',
 *          'type' => 'text|badge|date|actions', // optional, default 'text'
 *          'badgeClass' => 'bg-primary', // if type=badge
 *          'actions' => [              // if type=actions
 *              ['type'=>'edit', 'url'=>'/edit-url'],
 *              ['type'=>'delete', 'url'=>'/delete-url', 'confirm'=>'Delete {name}?']
 *          ]
 *      ]
 * - $scrollY: optional, default '400px'
 * - $searchPlaceholder: optional, default 'Search...'
 */
?>

<table id="<?= $id ?>" class="table table-hover table-striped align-middle nowrap" style="width:100%">
    <thead class="table-success">
        <tr>
            <?php foreach ($columns as $col) : ?>
                <th><?= $col['title'] ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
</table>

<script>
    $(document).ready(function() {
        const isMobile = window.innerWidth < 768;

        function renderColumn(col) {
            switch (col.type) {
                case 'badge':
                    return function() {
                        return `<span class="badge <?= $col['badgeClass'] ?? 'bg-primary' ?>">${col.data}</span>`;
                    };
                case 'date':
                    return function(data) {
                        return new Date(data).toISOString().slice(0, 10);
                    };
                case 'actions':
                    return function(data, type, row) {
                        let html = '';
                        if (col.actions) {
                            col.actions.forEach(action => {
                                if (action.type === 'edit') {
                                    html += `<a href="${action.url}/${data}" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="bi bi-pencil-square"></i>
                                         </a>`;
                                }
                                if (action.type === 'delete') {
                                    const msg = action.confirm.replace('{name}', row.name);
                                    html += `<button type="button" class="btn btn-sm btn-outline-danger" onclick="openDeleteModal('${action.url}/${data}', '${msg}')">
                                            <i class="bi bi-trash"></i>
                                         </button>`;
                                }
                            });
                        }
                        return html;
                    };
                default:
                    return {
                        data: col.data
                    }; // text
            }
        }

        const dtColumns = <?= json_encode($columns) ?>.map(c => {
            const render = renderColumn(c);
            return (typeof render === 'function') ? {
                data: c.data,
                render: render,
                orderable: false,
                searchable: c.type === 'actions' ? false : true,
                className: c.type === 'actions' ? 'text-center' : ''
            } : render;
        });

        $('#<?= $id ?>').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?= $ajaxUrl ?>",
                type: "POST",
                data: function(d) {
                    let csrfToken = $('meta[name="csrf_token"]').attr('content');
                    let csrfHash = $('meta[name="csrf_hash"]').attr('content');
                    d[csrfToken] = csrfHash;
                },
                dataSrc: function(json) {
                    if (json.csrf) {
                        $('meta[name="csrf_token"]').attr('content', json.csrf.token);
                        $('meta[name="csrf_hash"]').attr('content', json.csrf.hash);
                    }
                    return json.data;
                }
            },
            columns: dtColumns,
            responsive: true,
            scrollX: true,
            scrollY: "<?= $scrollY ?? '400px' ?>",
            scrollCollapse: true,
            paging: true,
            language: {
                search: "",
                searchPlaceholder: "<?= $searchPlaceholder ?? '🔍 Search...' ?>"
            },
            columnDefs: [{
                targets: isMobile ? 1 : -1,
                orderable: false,
                searchable: false,
                responsivePriority: 1
            }]
        });
    });
</script>
<?= view('components/delete_modal') ?>