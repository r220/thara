<?php
session_start();

if (isset($_SESSION["csrf_token"]) && $_POST["csrf_token"] == $_SESSION["csrf_token"]) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            require_once 'connection.php';
            require_once 'functions.php';

            $blog_id = trim($_POST["blog_id"]);

            // validate data
            delete_blog($pdo, $blog_id);

            // finish
            header("Location: ../blogs.php");
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