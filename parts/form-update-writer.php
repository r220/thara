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
$writer = get_writer($pdo, $_GET['writer_id']);
?>
<form id="update_writer_form"  method="post">
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
    <input type="hidden" name="writer_id" value="<?php echo $writer["writer_id"]; ?>">
    <input class="form-control mb-3" type="file" name="cover-image" id="cover-image" placeholder="ارفق صورة الكاتب" disabled>
    <input class="form-control mb-3" id="name" name="writer_name" type="text" value="<?php echo $writer["writer_name"]; ?>" placeholder="اسم الكاتب">
    <textarea class="form-control mb-3" name="biography" placeholder="معلومات عن الكاتب"><?php echo $writer["biography"]; ?></textarea>
</form>