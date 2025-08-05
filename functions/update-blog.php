<?php
session_start();

if (isset($_SESSION["csrf_token"]) && $_POST["csrf_token"] == $_SESSION["csrf_token"]) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            require_once 'connection.php';
            require_once 'validator.php';
            require_once 'functions.php';

            $writer_id = trim($_POST["writer_id"]);
            // $image = trim($_POST["cover-image"]);
            $blog_id = trim($_POST["blog_id"]);
            $title = trim($_POST["title"]);
            $about = trim($_POST["about"]);
            $content = trim($_POST["content"]);
            // validate data
            // $validate_blog = new video_validator($title, $text, $pdo);
            // $validate_blog->validate_data();
            update_blog($pdo, $blog_id, $writer_id, $title, $about, $content);

            // finish
            header("Location: ../blogs/" . $blog_id);
            die();
            
        } catch (PDOException $e) {
            die("Sql query failed: " . $e->getMessage());
        }
    } else {
        header("Location: ../blogs.php");
        die();
    }
} else {
    header("Location: ../blogs.php");
    die();
}