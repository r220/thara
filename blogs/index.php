<?php
session_start();

// check blog_id
$array =  explode("/", $_SERVER['REQUEST_URI']);
$blog_id = end($array);
if ($blog_id === null) {
    header("Status: 404");
    // echo 'hello';
    die();
}

// fetch blog data
require_once '../functions/connection.php';
require_once '../functions/functions.php';
$blog = get_blog($pdo, $blog_id);
if (!$blog) {
    header("Status: 404");
    die();
}
$writer = get_writer($pdo, $blog['writer_id']);
$writer_name;
if (!$writer) $writer_name = "";
else {
    $writer_name = $writer["writer_name"];
    // $writer_bio = $writer["biograghy"];
}


// blog detatils
$blog_id = $blog["blog_id"];
$title = $blog["title"];
$content = $blog["content"];

$created_at =  explode(" ", $blog["created_at"])[0];
$time_read = round(count(explode(" ", $content)) / 200) ;

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
            #blog-content {
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
            #blog-content .phone-mode-writer {
                display: none !important;
                margin-bottom: 0 !important;
            }
            #blog-content .phone-nav {
                    display: none !important;
            }
            @media (max-width: 991px) {
                #blog-content .phone-mode-writer {
                    display: flex !important;
                }
                #blog-content .phone-nav {
                    display: block !important;
                }
                #blog-content .col-md-4 {
                    display: none;
                }
                #blog-content .col-md-8 {
                    width: 100%;
                }
            }
            @media (max-width: 561px) {
                #blog-content .phone-mode-writer {
                    margin-bottom: .7rem !important;
                }
            }
                 
            #blog-content .writer-img-wrapper {
                border-radius: 24px;
            }
            .writer-img {
                max-height: 3rem;
            }
            .writer-name {
                font-size: 0.9rem;
            }
            small {
                font-size: .75em;
            }
             .accordion-item {
                color: var(--purple);
                background-color: var(--light-white);
                border: 1px solid var(--purple);
            }
            .accordion-button {
                padding-right: 2.25rem;
                padding-left: 2.25rem; 
            }
            .accordion-button:focus {
                color: var(--purple);
                background-color: var(--light-purple);
                /* box-shadow: none; */
            }
            .accordion-button:not(.collapsed) {
                color: var(--purple);
                background-color: var(--light-purple);
                /* box-shadow: inset 0 calc(-1 * var(--bs-accordion-border-width)) 0 var(--bs-accordion-border-color); */
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
        </style>
    </head>
    <body>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/loader.php" ?>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/header.php" ?>
        <section id="blog-content" class="section bg-dark text-purple">
            <div class="container">
                <div class="row">

                    <div class="col-12 col-md-8">
                        <?php 
                            if ($admin){
                                echo '<a href="' . $base_url . '/admin/update-blog/' . $blog_id . '"class="a-update btn btn-lg text-purple">تعديل</a>';
                            }
                        ?>
                        <h1><?php echo $blog["title"]; ?></h1>
                        <hr class="m-0">
                        <div class="d-flex justify-content-between align-items-center flex-wrap my-3">
                            <!-- writer phone -->
                             <div class="phone-mode-writer d-flex mb-3  me-5">
                                <a href="../writers/<?php echo $writer["writer_id"]?>" class="writer-img-wrapper me-3">
                                    <img class="writer-img" src="../assets/images/writer-img/0.png" alt="">
                                </a>
                                <a href="../writers/<?php echo $writer["writer_id"]?>" class="d-flex justify-content-center align-items-center text-purple">
                                    <div class="writer-name"><strong><?php echo $writer_name;?></strong></div>
                                </a>
                            </div>  
                            <div class="d-flex justify-content-center align-items-center">
                                <small class="me-3"><strong>تاريخ النشر: </strong><time datetime="<?php echo $created_at; ?>"><?php echo $created_at; ?></time></small>
                            <small><strong>مدة القراءة: </strong><?php echo $time_read; ?> دقيقة</small>
                            </div>
                        </div>
                        <hr class="m-0">
                        <!-- <img class="blog-img" src="../assets/images/blog/0.jpeg" alt="" class="rounded-1 mt-4 mb-5"> -->
                        <!-- acc phone -->
                         <div class="accordion open phone-nav mt-4 mb-5" id="accordion">
                            <div class="accordion-item">
                                <h6 class="accordion-header" id="panelsStayOpen-headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                        محتوى المدونة
                                    </button>
                                </h6>
                                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                                    <div class="accordion-body">
                                        <nav class="nav flex-column">
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div><?php echo $blog["content"]; ?></div>
                    </div>
                    <div class="col-12 col-md-4 sticky-top h-100 pt-5">
                        <div class="d-flex w-100 mb-3">
                            <a href="../writers/<?php echo $writer["writer_id"]?>" class="writer-img-wrapper me-3">
                                <img class="writer-img" src="../assets/images/writer-img/0.png" alt="">
                            </a>
                            <a href="../writers/<?php echo $writer["writer_id"]?>" class="d-flex justify-content-center align-items-center text-purple">
                                <div class="writer-name"><strong><?php echo $writer_name;?></strong></div>
                            </a>
                        </div>
                        <div class="accordion open" id="accordion">
                            <div class="accordion-item">
                                <h6 class="accordion-header" id="panelsStayOpen-headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                        محتوى المدونة
                                    </button>
                                </h6>
                                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                                    <div class="accordion-body">
                                        <nav class="nav nav-big-screen flex-column">
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/footer.php" ?>
    
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/js-scripts.php" ?>
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
        <script src="../assets/js/index.js"></script>
        <script>
            window.onload = () => {
                const nav = document.querySelector('.accordion .nav-big-screen');
                const nav_phone = document.querySelector('.phone-nav nav');
                const h3 = document.querySelectorAll('h3');
                // alert(nav);
                h3.forEach(el => {
                    let a = document.createElement('a');
                    a.setAttribute('href','#'+ el.id);
                    a.className = 'nav-link';
                    a.textContent = el.textContent;
                    nav.appendChild(a);
                    let b = a.cloneNode(true);
                    nav_phone.appendChild(b);
                    
                });
            };
        </script>
    </body>
</html>