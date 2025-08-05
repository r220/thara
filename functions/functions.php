<?php
// 1- GET
// 2- ADD
// 3- UPDATE
// 4- DELETE
function get_user_email(object $pdo, string $email) {
    $query = "SELECT * FROM users WHERE email = :email;";
    $statement = $pdo->prepare($query);

    $statement->bindparam(":email", $email);
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);

    return $result;
}
function get_videos($pdo) {
    $query = "SELECT * FROM videos";
    $statement = $pdo->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
function get_video($pdo, $link) {

    if (!$link) return null;

    $query = "SELECT * FROM videos WHERE link = :link;";
    $statement = $pdo->prepare($query);
    $statement->bindparam(":link", $link);
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function get_blogs($pdo) {
    $query = "SELECT * FROM blogs";
    $statement = $pdo->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
function get_blog($pdo, $blog_id) {
    
    if (!$blog_id) return null;

    $query = "SELECT * FROM blogs WHERE blog_id = :blog_id;";
    $statement = $pdo->prepare($query);
    $statement->bindparam(":blog_id", $blog_id);
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result;
}
function get_writers($pdo) {
    $query = "SELECT * FROM writers";
    $statement = $pdo->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
function get_writer($pdo, $writer_id) {
    if (!$writer_id) return null;

    $query = "SELECT * FROM writers WHERE writer_id = :writer_id;";
    $statement = $pdo->prepare($query);
    $statement->bindparam(":writer_id", $writer_id);
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result;
}
function get_writer_blogs($pdo, $writer_id) {
    if (!$writer_id) return null;

    $query = "SELECT * FROM blogs WHERE writer_id = :writer_id;";
    $statement = $pdo->prepare($query);
    $statement->bindparam(":writer_id", $writer_id);
    $statement->execute();

    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
function add_video($pdo, $link, $title, $about) {
    $query = "INSERT INTO videos (link, title, about) VALUES
            (:link, :title, :about);";

    $statement = $pdo->prepare($query);
    $statement->bindparam(":link", $link);
    $statement->bindparam(":title", $title);
    $statement->bindparam(":about", $about);
    $statement->execute();
}
function add_blog($pdo, $writer_id, $title, $about, $content) {
    $query = "INSERT INTO blogs (writer_id, title, about, content) VALUES
            (:writer_id, :title, :about, :content);";

            $statement = $pdo->prepare($query);
            $statement->bindparam(":writer_id", $writer_id);
            $statement->bindparam(":title", $title);
            $statement->bindparam(":about", $about);
            $statement->bindparam(":content", $content);
            $statement->execute();
}
function add_writer($pdo, $writer_name, $biograghy) {
    $query = "INSERT INTO writers (writer_name, biography) VALUES (:writer_name, :biography);";
    $statement = $pdo->prepare($query);
    $statement->bindparam(":writer_name", $writer_name);
    $statement->bindparam(":biography", $biograghy);
    $statement->execute();
}
function update_video(object $pdo, string $link, string $title, string $about) {
    $query = "UPDATE videos 
              SET title = :title,
                  about = :about
              WHERE link = :link";

    $statement = $pdo->prepare($query);

    $statement->bindparam(":title", $title);
    $statement->bindparam(":about", $about);
    $statement->bindparam(":link", $link);

    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result;
}
function update_blog($pdo, $blog_id, $writer_id, $title, $about, $content) {
    $query = "UPDATE blogs 
              SET title = :title,
                  about = :about,
                  content = :content,
                  writer_id = :writer_id 
              WHERE blog_id = :blog_id";

    $statement = $pdo->prepare($query);

    $statement->bindparam(":title", $title);
    $statement->bindparam(":about", $about);
    $statement->bindparam(":content", $content);
    $statement->bindparam(":writer_id", $writer_id);
    $statement->bindparam(":blog_id", $blog_id);

    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result;
}
function update_writer($pdo, $writer_id, $writer_name, $biography) {
        $query = "UPDATE writers 
              SET writer_name = :writer_name,
                  biography = :biography
              WHERE writer_id = :writer_id";

    $statement = $pdo->prepare($query);

    $statement->bindparam(":writer_name", $writer_name);
    $statement->bindparam(":biography", $biography);
    $statement->bindparam(":writer_id", $writer_id);

    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function delete_video($pdo, $link) {
    $query = "DELETE FROM videos where link = :link";
    $statement = $pdo->prepare($query);
    $statement->bindparam(":link", $link);
    $statement->execute();
}

function delete_blog($pdo, $blog_id) {
    $query = "DELETE FROM blogs where blog_id = :blog_id";
    $statement = $pdo->prepare($query);
    $statement->bindparam(":blog_id", $blog_id);
    $statement->execute();
}
function delete_writer($pdo, $writer_id) {
    $query = "DELETE FROM writers where writer_id = :writer_id";
    $statement = $pdo->prepare($query);
    $statement->bindparam(":writer_id", $writer_id);
    $statement->execute();
}