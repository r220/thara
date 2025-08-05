<?php
session_start();

if (isset($_SESSION["csrf_token"]) && $_POST["csrf_token"] == $_SESSION["csrf_token"]) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            require_once 'connection.php';
            require_once 'validator.php';
            require_once 'functions.php';

            $link = trim($_POST["link"]);
            $title = trim($_POST["title"]);
            $about = trim($_POST["about"]);

            // validate data
            $validate_video = new video_validator($link, $title, $about, $pdo);
            $validate_video->validate_data();
            add_video($pdo, $link, $title, $about);

            // finish
            header("Location: ../videos.php");
            die();
            
        } catch (PDOException $e) {
            die("Sql query failed: " . $e->getMessage());
        }
    } else {
        header("Location: ../videos.php");
        die();
    }
} else {
    header("Location: ../videos.php");
    die();
}