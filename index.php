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
$blogs = get_blogs($pdo);

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <title>ثرى</title>
        <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.3/dist/css/splide.min.css"> -->
        <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/head.php" ?>

        <style>
            html, body {
                overflow-x: hidden;
                overflow-x: clip; 
            }
            header {
                top: -4rem;
            }

            hr {
                color: #0000001f;
            }
            .episode-card a {
                display: block;
            }
            
            .vid-img-wrapper {
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
        </style>
    </head>
    <body>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/loader.php" ?>
        <div class="hero-nav container-fluid d-flex justify-content-center my-4 z-3" data-aos="slide-up" data-aos-duration="1000">
            <a class="nav-link me-4" href="index.php">الرئيسية</a>  
            <a class="nav-link me-4" href="podcasts.php">الإذاعة</a>
            <a class="nav-link me-4" href="index.php">LOGO</a>
            <a class="nav-link me-4" href="blogs.php">المدونات</a>
            <a class="nav-link" href="us.php">من نحن</a>
        </div>
        <section id="hero" class="hero-background d-flex justify-content-center z-0" data-aos="zoom-out" data-aos-duration="1000">
            <div class="hero-content container text-right px-4 z-2 " data-aos="fade-left" data-aos-duration="900" data-aos-delay="200">
                <h1>حياكم الله في مبادرة ثرى</h1>
                <p class="w-md-75 w-lg-50"> كلام تعريفي لكن بطابق مختصر بحيث ما يغطي الكلام على الفيديوكلام تعريفي لكن بطابق مختصر بحيث ما يغطي الكلام على الفيديو</p>
                <a href="#about" class="btn btn-lg mt-1">استمع الآن</a>
            </div>
        </section>

        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/header.php" ?>

        <div class="spacer"></div>

        <section id="about" class="section bg-purple text-center">
            <div class="container">
                <h2 class="mb-4">ثـــــرى  LOGO</h2>
                <p class="lead mb-4">
                    نؤمن أن القانون ليس مجرد مسار أكاديمي، بل هو رحلة مهنية تحتاج إلى جذور راسخة ورؤية واقعية.

                    ومن هنا، جاءت “ثَرى” لنقدّم محتوى قانونيًا موثوقًا، يتصل بالتجربة، ويعبر عن احتياج، ويصنع فارقًا حقيقيًا في جاهزية طلاب القانون لمواجهة سوق العمل.
                </p> 
                <a href="us.php" class="btn btn-lg mt-1 px-4 py-2 rounded-1">تــعـرف عـلـيــنا !</a>
            </div>
        </section>

        <section id="platform-sections" class="section bg-dark text-purple text-center">
            <div class="container">
                <h2 class="mb-5">أقسام المنصة</h2>
                <div class="row g-4">
                    <div class="col-12 col-sm-6" data-aos="fade-left" data-aos-duration="800">
                        <div class="p-4 bg-section-card rounded shadow">
                            <img src="assets/gif/microphone.gif" alt="إذاعة" class="img-fluid">
                            <h4>الإذاعة</h4>
                            <p>استمع إلى حلقات متنوعة من إعداد وتقديم الطلاب حول مواضيع ثقافية، علمية، اجتماعية وأكثر.</p>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6" data-aos="fade-right" data-aos-duration="800">
                        <div class="p-4 bg-section-card rounded shadow">
                            <img src="assets/gif/analytics.gif" alt="مدونات" class="img-fluid">
                            <h4>المدونات</h4>
                            <p>اقرأ مقالات ومشاركات فكرية وإبداعية كتبها طلاب في مجالات متعددة تعكس آرائهم وتجاربهم.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="episodes" class="section bg-light text-purple">
            <div class="container">
                <h2 class="text-center mb-5">أحدث الحلقات</h2>
                <div class="row">
                    <div class="col-sm-12">
                        <div id="splide_episodes" class="splide">
                            <div class="splide__arrows">
                                <button class="splide__arrow splide__arrow--prev" type="button" aria-label="Previous slide" aria-controls="splide_episodes-track">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" width="40" height="40">
                                        <path d="m15.5 0.932-4.3 4.38 14.5 14.6-14.5 14.5 4.3 4.4 14.6-14.6 4.4-4.3-4.4-4.4-14.6-14.6z"></path>
                                    </svg>
                                </button>
                                <button class="splide__arrow splide__arrow--next" type="button" aria-label="Next slide" aria-controls="splide_episodes-track">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" width="40" height="40">
                                        <path d="m15.5 0.932-4.3 4.38 14.5 14.6-14.5 14.5 4.3 4.4 14.6-14.6 4.4-4.3-4.4-4.4-14.6-14.6z"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="splide__slider" data-aos="fade-up" data-aos-duration="600">
                                <div class="splide__track">
                                    <ul class="splide__list">
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
                            echo '<li class="splide__slide">
                                        <div class="episode-card d-block text-purple bg-card-light">
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
                                    </li>';
                        }
                    ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="blogs" class="section bg-dark text-purple">
            <div class="container">
                <h2 class="text-center mb-5">أحدث المدونات</h2>
                <div class="row">
                    <div class="col-sm-12">
                        <div id="splide_blogs" class="splide">
                            <div class="splide__arrows">
                                <button class="splide__arrow splide__arrow--prev" type="button" aria-label="Previous slide" aria-controls="splide_blogs-track">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" width="40" height="40">
                                        <path d="m15.5 0.932-4.3 4.38 14.5 14.6-14.5 14.5 4.3 4.4 14.6-14.6 4.4-4.3-4.4-4.4-14.6-14.6z"></path>
                                    </svg>
                                </button>
                                <button class="splide__arrow splide__arrow--next" type="button" aria-label="Next slide" aria-controls="splide_blogs-track">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" width="40" height="40">
                                        <path d="m15.5 0.932-4.3 4.38 14.5 14.6-14.5 14.5 4.3 4.4 14.6-14.6 4.4-4.3-4.4-4.4-14.6-14.6z"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="splide__slider" data-aos="fade-up" data-aos-duration="600">
                                <div class="splide__track">
                                    <ul class="splide__list">
                                        <?php 
                        if ($admin) {
                            echo '<div class="col-12" data-aos="fade-up" data-aos-duration="600">
                                <a href="admin/add-blog.php" class="blog-card d-block text-purple bg-card-light d-flex justify-content-center align-items-center p-4">
                                    <i class="bi bi-plus-circle-fill display-1"></i>
                                </a>
                            </div>';
                        }
                        foreach ($blogs as $blog) {
                            $admin_buttons = '';
                            if ($admin) {
                                $admin_buttons = '<div class="admin-buttons">
                                                    <button value="' . $blog['blog_id'] . '" onclick="open_modal_delete(this)" class="del-video bi bi-trash3-fill text-danger border-0 px-1 py-0" data-bs-toggle="modal" data-bs-target="#modal-admin-delete">
                                                    </button>
                                                    <a href="' . $base_url . '/admin/update-blog/' . $blog['blog_id'] . '"  class="edit-video bi bi-pencil-fill bg-purple text-dark-yellow px-1 rounded-1 border-0">
                                                    </a>
                                                </div>';
                            }
                            echo '<li class="splide__slide">
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
                                </li>';
                        }
                    ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/modal-del-blog.php" ?>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/footer.php" ?>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/js-scripts.php" ?>
        <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
        <script src="assets/js/index.js"></script>
        <script>
            var splide_episodes = new Splide('#splide_episodes', {
                type: 'loop',
                direction: 'rtl',
                pagination: false,
                drag: 'free',
                autoplay: false,
                interval: 2000,
                speed: 600,

                perPage: 4,
                focus: 4,
                height: "23rem",
                gap: 20,
                padding: {
                left: 10,
                right: 10,
                },
            
                breakpoints: {
                1280: {
                    perPage: 4,
                    focus: 4,
                    height: "22rem",
                    gap: 20,
                    padding: {
                    left: 10,
                    right: 10,
                    }
                },
                992: {
                    perPage: 3,
                    focus: 3,
                    height: "22rem",
                    gap: 13,
                    padding: {
                    left: 10,
                    right: 10,
                    }
                },
                768: {
                    perPage: 2,
                    focus: 2,
                    height: "24rem",
                    gap: 20,
                    padding: {
                    left: 10,
                    right: 10,
                    }
                },

                600: {
                    perPage: 1,
                    height: "25rem",
                    focus: 'center',
                    gap: 20,
                    padding: {
                    left: 80,
                    right: 80,
                    }
                },
                450: { 
                    perPage: 1,
                    height: "22rem",
                    focus: 'center',
                    gap: 20,
                    padding: {
                    left: 30,
                    right: 30,
                    }
                }
                }
            });

            splide_episodes.mount();

            var splide_blogs = new Splide('#splide_blogs', {
                type: 'loop',
                direction: 'rtl',
                pagination: false,
                drag: 'free',
                // autoplay: true,
                interval: 2000,
                speed: 600,

                perPage: 2,
                focus: 2,
                height: "8rem",
                gap: 20,
                padding: {
                    left: 10,
                    right: 10,
                },

                breakpoints: {
                    991: {
                    perPage: 1,
                    focus: 'center',
                    },
                }
            });

            splide_blogs.mount();
        </script>
    </body>
</html>