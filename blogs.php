<?php
session_start();

$admin = false;
if (isset($_SESSION["user"]) && $_SESSION["user"]["user_type"] == 'admin') {
    $admin = true;
}

if (!isset($_SESSION['csrf_token']))
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

$base_url = "http://" . $_SERVER['HTTP_HOST'];

require_once 'functions/connection.php';
require_once 'functions/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/views.php';


$blogs = get_blogs($pdo);
// print_r($blogs);
// foreach ($videos as $video) {
//     print_r($video);
// }
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ثرى</title>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/head.php" ?>
        <link rel="stylesheet" href="assets/css/index.css">
        <style>
            header {
                top: 1rem;
            }
            #blogs {
                padding-top: 8rem;
                -webkit-backdrop-filter: blur(4px);
                backdrop-filter: blur(4px);
                background-color: color(srgb 0.79 0.74 0.63 / 0.5) !important;
                min-height: 80vh;
                height: fit-content;
            }
            .title-hr {
                margin: 2rem auto 3rem auto !important;
                border: 1px solid;
            }
            
            .blog-card {
                height: 100%;
                background-color: var(--light-white);
                box-shadow: 2px 1px 12px 2px rgb(255 255 255 / 50%);
            }
            
            .blog-card:hover {
                    background-color: #efe8da;
            }
        </style>
    </head>
    <body>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/loader.php" ?>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/header.php" ?>
        <section class="hero-background" data-aos="zoom-out" data-aos-duration="1000"> 
        </section>
        <section id="blogs" class="section bg-dark text-purple">
            <div class="container">
                <h2 class="text-center m-0">المدونات</h2>
                <hr class="title-hr my-5 w-25">
                <div class="row g-3" data-aos="fade-up" data-aos-duration="600">
                    <?php 
                        if ($admin) {
                            echo '<div class="col-12">
                                <a href="' . $base_url . '/admin/add-blog.php" class="blog-card d-block text-purple bg-card-light d-flex justify-content-center align-items-center p-4">
                                    <i class="bi bi-plus-circle-fill display-1"></i>
                                </a>
                            </div>';
                        }
                        foreach ($blogs as $blog) {
                            $admin_buttons = '';
                            if ($admin) {
                                $admin_buttons = '<div class="admin-buttons">
                                                    <button value="' . $blog['blog_id'] . '" onclick="open_modal_delete(this)" class="bi bi-trash3-fill text-danger border-0" data-bs-toggle="modal" data-bs-target="#modal-admin-delete">
                                                    </button>
                                                    <a href="' . $base_url . '/admin/update-blog/' . $blog['blog_id'] . '"  class="bi bi-pencil-fill px-1 rounded-1">
                                                    </a>
                                                </div>';
                            }
                            echo '<div class="col-sm-12 col-md-6" data-aos="fade-up" data-aos-duration="600">
                                    <div class="blog-card d-flex">
                                        <a href="' . $base_url . '/blogs/' . $blog['blog_id'] . '" class="img-wrapper">
                                            <img  src="' . $base_url . '/assets/images/blog/0.jpeg" alt="' . $blog['title'] . '">
                                        </a>
                                        <div class="blog-text p-3 d-flex flex-column justify-content-between">
                                            <a href="' . $base_url . '/blogs/' . $blog['blog_id'] . '" class="mb-2 text-purple">                                               
                                                <h6 class="text-truncate mb-1">' . $blog['title'] . '</h6>            
                                                <p class="text-truncate-multiline m-0">' . $blog['about'] . '</p>
                                            </a>  
                                            <div class="d-flex justify-content-between">
                                                <a href="' . $base_url . '/blogs/' . $blog['blog_id'] . '">
                                                    <p class="p-date m-0">
                                                        <i class="fa-solid fa-calendar me-1"></i>
                                                        6 يوليو 2025
                                                    </p>
                                                </a>
                                                ' . $admin_buttons . '
                                            </div>   
                                        </div>
                                    </div>
                                </div>';
                        }
                    ?>
                </div>
            </div>
        </section>
        
        <?php if ($admin) require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/modal-del-blog.php"; ?>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/footer.php" ?>
    

        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/js-scripts.php" ?>
        <script src="assets/js/index.js"></script>
        <script>
            // AFTER (open modal-del-blog)
            const input_hidden = document.querySelector("#modal-admin-delete > div > div > div.modal-footer > form > input[name=blog_id]");
            function open_modal_delete(button) {
                input_hidden.value = button.value;
                console.log(input_hidden.value);
            }
        </script>
    </body>
</html>