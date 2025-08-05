<?php
require_once 'connection.php';
$query = "DELETE FROM writers WHERE writer_id = 16;";
$statement = $pdo->prepare($query);
// $statement->bindparam(":writer_id", $writer_id);
$statement->execute();
$result = $statement->fetch(PDO::FETCH_ASSOC);
print_r($result);
?>