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

$writers = get_writers($pdo);
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
            #writers {
                padding-top: 8rem;
                /* -webkit-backdrop-filter: blur(4px);
                backdrop-filter: blur(4px); */
                /* background-color: color(srgb 0.79 0.74 0.63 / 0.5) !important; */
                min-height: 80vh;
                height: fit-content;
            }
            .title-hr {
                margin: 2rem auto 3rem auto !important;
                border: 1px solid;
            }
            .writer {
                position: relative;
                border: 1px solid var(--purple);
                box-shadow: var(--bs-box-shadow) !important;
                top: 0;
                transition: top 0.3s ease;
            }    
            .writer:hover {
                top: -10px;
                cursor: pointer;
            }
            .writer-img-wrapper {
                border-radius: 25px;
            }
            .writer-img {
                max-height: 4rem;
                border-radius: 25px;
            }
            .writer-name {
                margin: 0;
            }
            
        </style>
    </head>
    <body>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/loader.php" ?>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/header.php" ?>

        <section id="writers" class="section bg-dark text-purple">
            <div class="container">
                <h2 class="text-center m-0">الكتاب</h2>
                <hr class="title-hr my-5 w-25">
                <div class="row g-4">
                    <?php 
                        if ($admin) {
                            echo '<div class="col-12 col-md-6 ">
                                <div class="writer bg-light d-flex justify-content-center py-3 shadow h-100" data-bs-toggle="modal" data-bs-target="#modal-admin-add">
                                    <i class="bi bi-plus-circle-fill display-3"></i>                           
                                </div>  
                            </div>';
                        }
                        
                        foreach ($writers as $writer) {
                            $admin_buttons = '';
                            if ($admin) {
                                $admin_buttons = '<div class="admin-buttons align-content-center">
                                                    <button value="' . $writer['writer_id'] . '" onclick="open_modal_delete(this)" class="del-video bi bi-trash3-fill text-danger border-0 px-1 py-0" data-bs-toggle="modal" data-bs-target="#modal-admin-delete">
                                                    </button>
                                                    <button value="' . $writer['writer_id'] . '" onclick="open_modal_update(this)" class="edit-video bi bi-pencil-fill bg-purple text-dark-yellow px-1 rounded-1 border-0" data-bs-toggle="modal" data-bs-target="#modal-admin-update">
                                                    </button>
                                                </div>';
                            }
                            echo '<div class="col-12 col-md-6 ">
                                    <div class="writer bg-light d-flex justify-content-between p-3 shadow">
                                        <div class="d-flex">
                                            <a href="writers/' . $writer["writer_id"] . '" class="writer-img-wrapper me-3">
                                                <img class="writer-img" src="../assets/images/writer-img/0.png" alt="">
                                            </a>
                                            <a href="writers/' . $writer["writer_id"] . '" class="d-flex justify-content-center align-items-center text-purple">
                                                <h6 class="writer-name text-purple"><strong>' . $writer["writer_name"] . '</strong></h6>
                                            </a>
                                        </div>
                                        ' . $admin_buttons . '
                                    </div>  
                                </div>';
                        }
                    ?>
                </div>
            </div>
        </section>
        
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/modal-add-writer.php" ?>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/modal-update-writer.php" ?>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/modal-del-writer.php" ?>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/footer.php" ?>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/js-scripts.php" ?>
        <script src="assets/js/index.js"></script>
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
                xhttp.open('GET', `parts/form-update-writer.php?writer_id=${event.target.value}`, true);
                xhttp.send();
            }
            // AFTER open 'modal-del-writer'
            const input_hidden = document.querySelector("#modal-admin-delete > div > div > div.modal-footer > form > input[name=writer_id]");
            function open_modal_delete(button) {
                input_hidden.value = button.value;
                console.log(input_hidden.value);
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
                xhttp.open('POST', `functions/update-writer.php`, true);
                xhttp.send(formData);
            }
            // submit 'add_writer'
            function add_writer(button) {
                let form = document.querySelector("#add_writer_form");
                let formData = new FormData(form);

                const xhttp = new XMLHttpRequest();
                xhttp.onload = function () {
                    if (this.readyState == 4) {
                        const msg = document.querySelector('#added_writer_msg');
                        msg.innerHTML = this.responseText;
                        msg.classList.add('show');
                        
                    }
                };
                xhttp.open('POST', `functions/add-writer.php`, true);
                xhttp.send(formData);
            }

        </script>
    </body>
</html>