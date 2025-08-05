<div id="modal-admin-add" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-light text-purple">
            <div class="modal-header">
                <h5 class="modal-title">بيانات الحلقة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo $base_url;?>/functions/add-video.php" method="post">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                    <div class="mb-3">
                        <label for="video-title" class="col-form-label">*العنوان</label>
                        <input type="text" class="form-control" name="title" id="video-title">
                    </div>
                    <div class="link-wrapper mb-3">
                        <label for="video-link" class="col-form-label me-3">
                            <i class="bi bi-youtube text-danger"></i>
                        </label>
                        <input type="text" class="form-control" name="link" id="video-link" dir="ltr" placeholder="https://www.youtube.com/">
                    </div>
                    <div class="mb-3">
                        <label for="video-about" class="col-form-label">نبذة عن الحلقة (غير إلزامي)</label>
                        <textarea class="form-control" name="about" id="video-about"></textarea>
                    </div>
                    <div class="modal-footer px-0 pb-0">
                        <button type="button" class="btn" data-bs-dismiss="modal">تراجع</button>
                        <button type="submit" class="btn btn-danger">إضافة</button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</div>