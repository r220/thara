<div id="modal-admin-delete" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-light text-purple">
            <div class="modal-header">
                <h5 class="modal-title">متأكدة من الحذف ؟</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal">تراجع</button>
                <form action="<?php echo $base_url;?>/functions/del-video.php" method="post" class="m-0">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                    <input type="hidden" name="link">
                    <button type="submit" class="btn btn-danger">متأكدة</button>
                </form>
            </div>
        </div>
    </div>
</div>