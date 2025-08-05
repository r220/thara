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


$videos = get_videos($pdo);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <title>ثرى</title>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/head.php" ?>
        <style>
            header {
                top: 1rem;
            }
            #podcasts {
                padding-top: 8rem;
                -webkit-backdrop-filter: blur(4px);
                backdrop-filter: blur(4px);
                background-color: color(srgb 0.79 0.74 0.63 / 0.5) !important;
                min-height: 80vh;
            }
            .title-hr {
                margin: 2rem auto 3rem auto !important;
                border: 1px solid;
            }
            #podcasts .row > * {
                height: 22rem;
            }
            .episode-card {
                background-color: var(--light-white);
                box-shadow: 2px 1px 12px 2px rgb(255 255 255 / 50%);
            }
            .episode-card:hover {
                background-color: #efe8da;
            }
            .episode-card a {
                display: block;
            }
            @media (min-width: 550px) and (max-width: 767px) {
                .col-sm-6 {
                    flex: 0 0 auto;
                    width: 50%;
                }
            }
            .vid-img-wrapper {
                display: block;
                width: 100%;
                height: 65%;
                /* height: 12rem; */
                border-radius: 20px 20px 0 0;
            }
           
            .vid-img-wrapper img {
                width: 100%;
                height: 100%;
            }
            .vid-text-bottom {
                align-items: self-end;
            }
            .bi-trash3-fill {
                background-color: #00000000 !important;
            }
            label[for="video-title"], label[for="video-about"] {
                font-size: 0.8rem;
            }
            .link-wrapper {
                position: relative;
            }
            label[for="video-link"] {
                position: absolute;
                padding: 0rem 0.5rem;
                font-size: x-large;
                border-left: 1px solid #dfe2e6;
                height: -webkit-fill-available;
                align-content: center;
                -webkit-align-content: center;
            }
            input[name="link"] {
                    padding-right: 3rem;
            }
            button.btn-danger:hover {
                background-color: #d13141;
            }
        </style>
    </head>
    <body>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/loader.php" ?>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/header.php" ?>

        <section class="hero-background" data-aos="zoom-out" data-aos-duration="1000"> 
        </section>

        <section id="podcasts" class="section bg-dark text-purple">
            <div class="container">
                <h2 class="text-center m-0">الإذاعـــــــة</h2>
                <hr class="title-hr my-5 w-25">
                <div class="row g-3" data-aos="fade-up" data-aos-duration="400">
                    
                    <?php 
                        if ($admin) {
                            echo '<div class="col-12 col-sm-6 col-md-4 col-lg-3 h-auto" data-aos="fade-up" data-aos-duration="600">
                                <div class="episode-card d-block text-purple bg-card-light d-flex justify-content-center align-items-center p-4 h-100" data-bs-toggle="modal" data-bs-target="#modal-admin-add">
                                    <i class="bi bi-plus-circle-fill display-1"></i>
                                </div>
                            </div>';
                        }
                        foreach ($videos as $video) {
                            $admin_buttons = '';
                            $admin_vid_height = '';
                            if ($admin) {
                                $admin_buttons = '<div class="admin-buttons text-end">
                                                    <button value="' . $video['link'] . '" onclick="open_modal_delete(this)" class="bi bi-trash3-fill text-danger border-0" data-bs-toggle="modal" data-bs-target="#modal-admin-delete">
                                                    </button>
                                                    <button value="' . $video['link'] . '" onclick="open_modal_edit(this)" class="bi bi-pencil-fill px-1 rounded-1" data-bs-toggle="modal" data-bs-target="#modal-admin-update">
                                                    </button>
                                                </div>';
                            }
                            echo '<div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                        <div class="episode-card d-block text-purple bg-card-light h-100">
                                            <a class="vid-img-wrapper" href="' . $video['link'] . '">
                                                <img  src="' . $base_url  . '/assets/images/video/0.jpeg" alt="' . $video['title'] . '">
                                            </a>
                                            <div class="episode-text p-3">
                                                <a href="' . $video['link'] . '" class="text-purple">                                               
                                                        <h6 class="text-truncate-multiline mb-1">' . $video['title'] . '</h6>            
                                                        <p class="text-truncate m-0">' . $video['about'] . '</p>
                                                </a>
                                                <div class="vid-text-bottom d-flex justify-content-between mt-2">
                                                    <a href="' . $video['link'] . '">
                                                        <p class="p-date m-0 justify-content-end">
                                                            <i class="fa-solid fa-calendar me-1"></i>
                                                            ' . explode(' ', $video['added_at'])[0] . '
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
        <?php 
            if ($admin) {
                require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/modal-add-vid.php";
                require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/modal-update-vid.php";
                require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/modal-del-vid.php";
            } 
        ?>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/footer.php" ?>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/js-scripts.php" ?>
        <script src="assets/js/index.js"></script>
        <script>
            // open edit modal
            function open_modal_edit(button) {
                const xhttp = new XMLHttpRequest();
                xhttp.onload = function () {
                    if (this.readyState == 4) {
                        const modal_edit = document.querySelector('#modal-admin-update > div > div > div.modal-body');                                    
                        modal_edit.innerHTML = this.responseText;
                    }
                };
                xhttp.open('GET', `parts/form-update-vid.php?link=${event.target.value}`, true);
                xhttp.send();
            }
            // open delete modal
            const input_hidden = document.querySelector("#modal-admin-delete > div > div > div.modal-footer > form > input[name=link]");
            function open_modal_delete(button) {
                input_hidden.value = button.value;
                console.log(input_hidden.value);
            }
        </script>
    </body>
</html>