<?php

session_start();

// $admin = false;
// if (isset($_SESSION["user"]) && $_SESSION["user"]["user_type"] == 'admin') {
//     $admin = true;
// }

// if (!isset($_SESSION['csrf_token']))
//   $_SESSION['csrf_token'] = bin2hex(random_bytes(32));


$base_url = "http://" . $_SERVER['HTTP_HOST'];

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <title>Document</title>
        <?php require_once __DIR__  . "/parts/head.php" ?>
        <style>
            #error-section {
                height: 100vh;
            }
            h1 {
                font-weight: bold;
            }
            a {
                color: var(--dark-white);
            }
        </style>
    </head>
    <body>
        
        <?php 
        // require_once __DIR__ . "/parts/header.php" 
        ?>
        <section id="error-section" class="section bg-purple text-yellow">
            <div class="container h-100">
                <div class="d-flex justify-content-center align-items-center h-100">
                    <div>
                        <h1>الصفحة غير موجودة</h1>
                        <a href="<?php echo $base_url;?>">عد للصفحة الرئيسية</a>
                    </div>
                    
                </div>
            </div>
        </section>
        <?php
        //  require_once __DIR__  . "/parts/footer.php" 
         ?>
    </body>
</html>