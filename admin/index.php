<?php
session_start();
$admin = false;
if (!isset($_SESSION["user"]) || $_SESSION["user"]["user_type"] != 'admin') {
    header("Status: 404");
    die();
}
$base_url = "http://" . $_SERVER['HTTP_HOST'];

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <title>ثرى</title>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/head.php" ?>
        <style>
            #admin-section {
                height: 100vh;
            }
            .buttons-wrapper {
                width: fit-content;
                justify-self: center;
            }
            a {
                background-color: var(--dark-yellow) !important;
                color: var(--purple) !important;
                font-weight: bold;
                box-shadow: inset 5px 5px 7px 0px #ffffff87;
                transition: background-color 0.3s;
                transition: font-weight 1s;
            }
            a:hover {
                background-color: #ffe8a2 !important;
            }
            hr {
            }
        </style>
    </head>
    <body>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/loader.php" ?>
        <?php
        //  require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/header.php" 
        ?>
        <section id="admin-section" class="section bg-purple text-dark d-flex flex-column align-content-center justify-content-center w-100">
            <div class="container w-75">
                <h1 class="text-center ">أدمـــن فـقـــط *_*</h1>
                <hr class="w-50 mx-auto my-5 text-white">
                <div class="row g-2 buttons-wrapper d-flex flex-column">
                    <a href="../index.html" class="btn btn-lg">الصفحة الرئيسية</a>
                    <a href="../videos.php" class="btn btn-lg">الحلقات</a>
                    <a href="../blogs.php" class="btn btn-lg">المدونات</a>
                    <a href="../writers.php" class="btn btn-lg">الكُتاب</a>
                </div>
            </div>
        </section>

        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/js-scripts.php" ?>
        <script src="../assets/js/index.js"></script>
    </body>
</html>