<!-- Delete Confirmation Modal -->
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
                <form id="deleteForm" method="post" action="">
                    <?= csrf_field() ?>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Open delete modal dynamically
    function openDeleteModal(url, message = "Are you sure you want to delete this record?") {
        document.getElementById("deleteForm").action = url;
        document.getElementById("deleteModalMessage").innerText = message;
        let modal = new bootstrap.Modal(document.getElementById("deleteModal"));
        modal.show();
    }
</script>