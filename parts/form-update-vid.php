<?php 
session_start();
require_once '../functions/connection.php';
require_once '../functions/functions.php';

$admin = false;
if (isset($_SESSION["user"]) && $_SESSION["user"]["user_type"] == 'admin') {
    $admin = true;
}

if (!isset($_SESSION['csrf_token']))
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

$base_url = "http://" . $_SERVER['HTTP_HOST'];

$video = get_video($pdo, $_GET['link']);
?>

<form action="<?php echo $base_url;?>/functions/update-video.php" method="post">
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
    <div class="mb-3">
        <label for="video-title" class="col-form-label">*العنوان</label>
        <input type="text" class="form-control" name="title" id="video-title" value="<?php echo $video["title"]; ?>">
    </div>
    <div class="link-wrapper mb-3">
        <label for="video-link" class="col-form-label me-3">
            <i class="bi bi-youtube text-danger"></i>
        </label>
        <input type="text" class="form-control" name="link" id="video-link" value="<?php echo $video["link"]; ?>" dir="ltr" placeholder="https://www.youtube.com/">
    </div>
    <div class="mb-3">
        <label for="video-about" class="col-form-label">نبذة عن الحلقة (غير إلزامي)</label>
        <textarea class="form-control" name="about" id="video-about"><?php echo $video["about"]; ?></textarea>
    </div>
    <div class="modal-footer px-0 pb-0">
        <button type="button" class="btn" data-bs-dismiss="modal">تراجع</button>
        <button type="submit" class="btn btn-danger">تعديل</button>
    </div>
</form>