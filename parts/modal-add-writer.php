<div id="modal-admin-add" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-light text-purple">
            <div class="modal-header">
                <h5 class="modal-title">بيانات الكاتب</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="add_writer_form" action="<?php echo $base_url?>/functions/add-writer.php" method="post">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                        <input class="form-control mb-3" type="file" name="cover-image" id="cover-image" placeholder="ارفق صورة الكاتب" disabled>
                        <input class="form-control mb-3" id="name" name="writer_name" type="text" placeholder="اسم الكاتب">
                        <textarea class="form-control mb-3" name="biography" placeholder="معلومات عن الكاتب"></textarea>
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <div id="added_writer_msg"></div>
                <div>
                    <button type="button" class="btn" data-bs-dismiss="modal">تراجع</button>
                    <button type="button" class="btn btn-danger" onclick="add_writer(this)">إضافة</button>
                </div>
            </div>
        </div>
    </div>
</div>