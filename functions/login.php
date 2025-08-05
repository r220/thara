<?php
session_start();
if (isset($_SESSION["csrf_token"]) && htmlspecialchars($_POST["csrf_token"]) == $_SESSION["csrf_token"]) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    echo "hello";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $email = $_POST["email"];
        $password = $_POST["pwd"];

        try {
            require_once 'connection.php';
            require_once 'functions.php';
            require_once 'validator.php';

            $validate_user = new LoginValidator($email, $password, $pdo);
            $validate_user->validate_data();
            $_SESSION["user"] = $validate_user->get_user_data();
            header("Location: ../admin/index.php");
            die();
        }
        catch (PDOException $e) {
            die("Sql query failed: " . $e->getMessage());
        }
    } else {
        header("Location: ../index.php");
        die();
    }
}