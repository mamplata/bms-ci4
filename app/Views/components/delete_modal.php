<!-- components/delete_modal.php -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-sm">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="deleteModalMessage">Are you sure you want to delete this record?</p>
            </div>
            <div class="modal-footer">
                <form id="deleteForm" method="POST" action="">
                    <?= csrf_field() ?>
                    <!-- Spoof DELETE method -->
                    <input type="hidden" name="_method" value="DELETE">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    /**
     * Open delete modal with dynamic URL and message
     * @param {string} url - form action URL
     * @param {string} message - confirmation message
     */
    function openDeleteModal(url, message = "Are you sure you want to delete this record?") {
        const form = document.getElementById("deleteForm");
        form.action = url;
        document.getElementById("deleteModalMessage").innerText = message;

        // Update CSRF token dynamically from meta tags if present
        let csrfToken = $('meta[name="csrf_token"]').attr('content');
        let csrfHash = $('meta[name="csrf_hash"]').attr('content');
        if (csrfToken && csrfHash) {
            $(form).find('input[name="' + csrfToken + '"]').val(csrfHash);
        }

        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }
</script>