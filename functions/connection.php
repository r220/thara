<?php
$host = '127.0.0.1';
$dbname = 'thara';
$dbusername = 'root';
$dbpassword = '';

try {

    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "success";

} catch (PDOException $e) {
    die("Connection failed with error: " . $e->getMessage());
}