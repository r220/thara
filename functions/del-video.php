<?php
session_start();

if (isset($_SESSION["csrf_token"]) && $_POST["csrf_token"] == $_SESSION["csrf_token"]) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            require_once 'connection.php';
            require_once 'functions.php';

            $link = trim($_POST["link"]);

            // validate data
            delete_video($pdo, $link);

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