<?php
session_start();
if (!isset($_SESSION['csrf_token']))
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

include_once $_SERVER['DOCUMENT_ROOT'] . '/functions/views.php';

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
            button {
                background-color: var(--dark-yellow) !important;
                color: #493d9e;
                font-weight: bold;
                box-shadow: inset 5px 5px 7px 0px #ffffff87;
                transition: background-color 0.3s;
            }
            hr {
                color: #0000001f;
            }
        </style>
    </head>
    <body>
         <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/loader.php" ?>

        <section id="admin-section" class="section bg-purple text-dark d-flex flex-column align-content-center justify-content-center w-100">
            <div class="container">
                <h2 class="text-center mb-5">موقع ثرى</h2>
                <form action="functions/login.php" method="post" class="row g-2 buttons-wrapper d-flex flex-column">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                    <input type="email" name="email" id="email" placeholder="enter@email.com" class="form-control ">
                    <input type="password" name="pwd" id="pwd" dir="ltr" placeholder="password" class="form-control">
                    <button type="submit" class="btn btn-lg mb-4">تسجيل دخول</button>
                    <?php render_login_messages(); ?>
                </form>
            </div>
        </section>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/js-scripts.php" ?>
        <script src="../assets/js/index.js"></script>
    </body>
</html>