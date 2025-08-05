<?php
session_start();

$array =  explode("/", $_SERVER['REQUEST_URI']);
$writer_id = end($array);
if ($writer_id === null) {
    header("Status: 404");
    die();
}

require_once '../functions/connection.php';
require_once '../functions/functions.php';
$writer = get_writer($pdo, $writer_id);
if (!$writer) {
    echo "noo";
    header("Status: 404");
    die();
}
// print_r($writer);
$writer_id = $writer["writer_id"];
$writer_name = $writer["writer_name"];
$biography = $writer["biography"];
$blogs = get_writer_blogs($pdo, $writer_id);
// print_r($blogs);
// $created_at =  explode(" ", $writer["created_at"])[0];

$admin = false;
if (isset($_SESSION["user"]) && $_SESSION["user"]["user_type"] == 'admin') {
    $admin = true;
}
$base_url = "http://" . $_SERVER['HTTP_HOST'];


?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <title>ثرى</title>
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.bubble.css" rel="stylesheet" />
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/head.php" ?>
        <style>
            .container-edit-blog {
                    width: 100%;
                    max-width: 800px;
                    padding-left: 15px;
                    padding-right: 15px;
                    margin-left: auto;
                    margin-right: auto;
            }
            @media (min-width: 768px) {
                .container-edit-blog {
                    max-width: 600px;
                }
            }
            @media (min-width: 1200px) {
                .container-edit-blog {
                    max-width: 800px;
                }
            }
            header {
                top: 1rem;
            }
            #writer {
                padding-top: 8rem;
                min-height: 80vh;
                height: fit-content;
                text-align: justify;
                line-height: 1.66;
            }
             .a-update {
                border: 1px solid var(--purple);
                font-weight: bold;
            }
            .a-update:hover {
                background-color: var(--purple);
                color: var(--yellow);  
            }
            #blog-content .title-hr {
                margin: 1rem auto !important;
                border: 0.5px solid;
            }
                 
            .writer-img-wrapper {
                border-radius: 24px;
            }
            .writer-img {
                max-height: 6rem;
                
            }
            .writer-name {
                font-size: 1.5rem;
                text-align: right;
            }
            small {
                font-size: .75em;
            }
            
            #blog-content .blog-img {
                width: 100%;
                box-shadow: 1px 2px 3px 0px #00000088;
                max-height: 25rem;
                height: 24rem;
                margin: 1.5rem auto;
            }
            #blog-content h1, #blog-content h2, #blog-content h3, #blog-content h4 {
                font-weight: bold;
                line-height: 1.56;
                margin: 1rem 0;
                text-align: initial;
            }
            #blog-content h1 {
                font-size: 3rem;
                line-height: 1.36;
                margin-bottom: 1.5rem;
            }
            #blog-content p {
                font-size: 1.2em;
                line-height: 1.66;
            }
            #blog-content li {
                list-style-type: disc;
                margin-bottom: 0.5rem;
            }
            .blog-card {
                height: 100%;
                background-color: var(--light-white);
                box-shadow: 2px 2px 6px 0px rgb(0 0 0 / 12%);
            }
            .blog-card img {
                height: 100%;
                width: 100%;
            }
            .blog-card .img-wrapper {
                width: 30%;
            }
            .blog-card:hover {
                    background-color: #efe8da;
            }
            .bi-trash3-fill {
                background-color: #00000000 !important;
                font-size: 1.2em;
            }
            button.btn-danger:hover {
                background-color: #d13141;
            }
            @media (min-width: 576px) and (max-width: 767px) {
                .blog-card .img-wrapper {
                    width: 25%;
                }
                .blog-card .blog-text {
                    width: 75%;
                }
            }
            @media (min-width: 768px) and (max-width: 991px) {
                .blog-card .img-wrapper {
                    width: 20%;
                }
                .blog-card .blog-text {
                    width: 80%;
                }
            }
            #writer > div > h6 {
                line-height: 1.66;
            }
            
        </style>
    </head>
    <body>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/loader.php" ?>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/header.php" ?>
        <?php 
            if ($admin) require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/modal-update-writer.php";               
            
        ?>
        <section id="writer" class="section bg-dark text-purple">
            <div class="container-edit-blog">
                <?php 
                    if ($admin) echo '<button class="a-update btn btn-lg text-purple mb-3" onclick="open_modal_update(this)" value="' . $writer_id . '" data-bs-toggle="modal" data-bs-target="#modal-admin-update">تعديل</button>';
                ?>
                <div class="d-flex mb-3  me-5">
                    <div class="writer-img-wrapper me-3">
                        <img class="writer-img" src="../assets/images/writer-img/0.png" alt="">
                    </div>
                    <div class="d-flex justify-content-center align-items-center text-purple">
                        <div class="writer-name"><strong><?php echo $writer_name;?></strong></div>
                    </div>
                </div>  
                <h6><?php echo $biography;?></h6> 
                <hr class="mt-4 mb-5">
                <div class="row g-3">
                    <?php 
                        foreach ($blogs as $blog) {
                            $admin_buttons = '';
                            if ($admin) {
                                $admin_buttons = '<div class="admin-buttons">
                                                    <button value="' . $blog['blog_id'] . '" onclick="open_modal_delete(this)" class="del-video bi bi-trash3-fill text-danger border-0 px-1 py-0" data-bs-toggle="modal" data-bs-target="#modal-admin-delete">
                                                    </button>
                                                    <a href="admin/update-blog/' . $blog['blog_id'] . '"  class="edit-video bi bi-pencil-fill bg-purple text-dark-yellow px-1 rounded-1 border-0">
                                                    </a>
                                                </div>';
                            }
                            echo '<div class="col-sm-12 col-lg-6" data-aos="fade-up" data-aos-duration="600">
                                    <div class="blog-card d-flex">
                                        <a href="/blogs/' . $blog['blog_id'] . '" class="img-wrapper">
                                            <img  src="../assets/images/blog/0.jpeg" alt="' . $blog['title'] . '">
                                        </a>
                                        <div class="blog-text  p-3 d-flex flex-column justify-content-between">
                                            <a href="/blogs/' . $blog['blog_id'] . '" class="mb-2 text-purple">                                               
                                                <h6 class="text-truncate mb-1">' . $blog['title'] . '</h6>            
                                                <p class="text-truncate-multiline m-0">' . $blog['about'] . '</p>
                                            </a>  
                                            <div class="d-flex justify-content-between">
                                                <a href="/blogs/' . $blog['blog_id'] . '">
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

        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/footer.php" ?>
    
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/js-scripts.php" ?>
        <script src="../assets/js/index.js"></script>
        <script>
            // AFTER open 'modal-update-writer' (get form)
            function open_modal_update(button) {
                const xhttp = new XMLHttpRequest();
                xhttp.onload = function () {
                    if (this.readyState == 4) {
                        const modal_edit = document.querySelector('#modal-admin-update > div > div > div.modal-body');                                    
                        modal_edit.innerHTML = this.responseText;
                    }
                };
                xhttp.open('GET', `../parts/form-update-writer.php?writer_id=${button.value}`, true);
                xhttp.send();
            }
            // submit 'update_writer'
            function update_writer(button) {
                let form = document.querySelector("#update_writer_form");
                let formData = new FormData(form);

                const xhttp = new XMLHttpRequest();
                xhttp.onload = function () {
                    if (this.readyState == 4) {
                        const msg = document.querySelector('#updated_writer_msg');
                        msg.innerHTML = this.responseText;
                        msg.classList.add('show');
                        
                    }
                };
                xhttp.open('POST', `../functions/update-writer.php`, true);
                xhttp.send(formData);
            }
        </script>
    </body>
</html>