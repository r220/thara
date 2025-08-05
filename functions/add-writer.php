<?php
session_start();
if (isset($_SESSION["csrf_token"]) && $_POST["csrf_token"] == $_SESSION["csrf_token"]) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            require_once 'connection.php';
            require_once 'validator.php';
            require_once 'functions.php';

            // $writer = trim($_POST["writer"]);
            // $image = trim($_POST["cover-image"]);
            $writer_name = trim($_POST["writer_name"]);
            $biography = trim($_POST["biography"]);
            // $user_type = 'writer';
            // $email = 'idk@idk';
            // $pwd = 'idk';
            // validate data
            // $validate_writer = new video_validator($title, $text, $pdo);
            // $validate_writer->validate_data();
            // add_user($pdo, $user_type, $email, $pwd);
            // $user_id = get_user()['user_id'];
            add_writer($pdo, $writer_name, $biography);
            echo '<p class="text-success m-0">تمت الإضافة<i class="bi bi-emoji-laughing ms-2"></i></p>';
            // finish
            // header("Location: ../writers.php");
            // die();
            
        } catch (PDOException $e) {
            die("Sql query failed: " . $e->getMessage());
        }
    } else {
        header("Location: ../writers.php");
        die();
    }
} else {
    header("Location: ../writers.php");
    die();
}