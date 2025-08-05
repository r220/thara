<?php
session_start();

$admin = false;
if (isset($_SESSION["user"]) && $_SESSION["user"]["user_type"] == 'admin') {
    $admin = true;
}
else {
    header("Status: 404");
    die();
}

if (!isset($_SESSION['csrf_token']))
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/views.php';

// check blog_id
$array =  explode("/", $_SERVER['REQUEST_URI']);
$blog_id = end($array);
if ($blog_id === null) {
    header("Status: 404");
    die();
}

// fetch blog data
$blog = get_blog($pdo, $blog_id);

if (!$blog) {
    echo "noo";
    header("Status: 404");
    die();
}

// blog detatils
$title = $blog["title"];
$content = $blog["content"];
$writer_id = $blog["writer_id"];
$writer_name = get_writer($pdo, $writer_id)["writer_name"];
$writers = get_writers($pdo);
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
            /* @media (min-width: 992px) {
                .container {
                    max-width: 600px;
                }
            } */
            @media (min-width: 1200px) {
                .container-edit-blog {
                    max-width: 800px;
                }
            }
            header {
                top: 1rem;
            }
            /* footer {
                
            } */
            #blog-content {
                padding-top: 8rem;
                min-height: 80vh;
                height: fit-content;
                text-align: justify;
                line-height: 1.66;
                font-size: revert;
            }
            #blog-content img {
                width: 100%;
                box-shadow: 1px 2px 3px 0px #00000088;
                max-height: 25rem;
            }
            .title-hr {
                margin: 2rem auto 3rem auto !important;
                border: 1px solid;
            }
            .bi-plus::before {
                font-size: 2em;
            }
            #added_writer_msg {
                opacity: 0;
            }
            #added_writer_msg.show {
            animation: anime 4s 1;
            }
            @keyframes anime {
                0% {
                    opacity: 0;
                }
                25% {
                    opacity: 1;
                }
                75% {
                    opacity: 1;
                }
                100% {
                    opacity: 0;
                }
            }
            #blog-content h1, #blog-content h2, #blog-content h3, #blog-content h4 {
                font-weight: bold;
                line-height: 1.66;
                margin: 1rem 0;
                text-align: initial;
            }
            #blog-content h1 {
                font-size: 2rem;
            }
            #blog-content h3 {
                font-size: calc(1.3rem + .6vw);
            }
            #blog-content h4 {
                font-size: calc(1.275rem + .3vw);
            }
            #blog-content p {
                font-size: 1.2em;
                line-height: 1.66;
            }
            #blog-content li {
                    /* list-style-type: disc; */
                    margin-bottom: 0.5rem;
            }
            #editor {
                font-family: "Noto Kufi Arabic", sans-serif;;
            }
            /* start RTL */
            .ql-editor.ql-blank::before { 
                text-align-last: right;
                font-weight: bold;
                font-family: "Noto Kufi Arabic", sans-serif;
                font-size: 1.2em;
                margin: 1rem 0;
            }
            .ql-editor .ql-direction-rtl {
                direction: rtl;
                text-align: right;
            }
            /* end RTL */
            .ql-bubble .ql-editor blockquote {
                border-left: none;
                padding-left: 0px;
                border-right: 4px solid #ccc;
                padding-right: 16px;
            }
            .ql-bubble .ql-color-picker .ql-picker-options {
                padding: 3px 5px;
                width: 92px;
            }
            .ql-bubble .ql-tooltip-editor input[type=text] {
                padding: 10px 40px 10px 20px;
                direction: ltr;
            }
            .ql-editor p, .ql-editor ol, .ql-editor pre, .ql-editor blockquote, .ql-editor h1, .ql-editor h2, .ql-editor h3, .ql-editor h4, .ql-editor h5, .ql-editor h6 {
                margin: revert;
            }
            .bi-trash3-fill {
                background-color: #00000000 !important;
                font-size: 1.2em;
            }
            button.btn-danger:hover {
                background-color: #d13141;
            }
            button.btn:hover {
                background-color: var(--purple);
                color: var(--light-white);
            }

        </style>
    </head>
    <body>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/loader.php" ?>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/header.php" ?>
        <section id="blog-content" class="section bg-light text-purple">
            <div class="container-edit-blog">
                <!-- <h2 class="text-center m-0">المدونات</h2>
                <hr class="title-hr my-5 w-25"> -->
                <form action="../../functions/update-blog.php" method="post">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                    <input type="hidden" name="blog_id" value="<?php echo $blog_id; ?>">
                    <div class="p-3 rounded-3 bg-light-purple mb-3">
                        <div class="d-flex">
                            <select class="form-select mb-3 me-2" id="writer" name="writer_id">
                                <option value="<?php echo $writer_id; ?>" selected hidden><?php echo $writer_name; ?></option>
                                <?php
                                    foreach ($writers as $writer) {
                                        # code...
                                        echo '<option value="' . $writer['writer_id'] . '">' . $writer['writer_name'] . '</option>';
                                    }
                                ?>
                            </select>
                            <button class="btn form-button bg-purple text-yellow mb-3 p-0" type="button" data-bs-toggle="modal" data-bs-target="#modal-admin-add">
                                <i class="bi bi-plus d-flex align-items-center"></i>
                            </button>
                        </div>
                        <input class="form-control mb-3" type="file" name="cover-image" id="cover-image" placeholder="اختر صورة العرض" disabled>
                        <input class="form-control mb-3" id="title" name="title" type="text" placeholder="العنوان" value="<?php echo $blog["title"]; ?>">
                        <input class="form-control mb-3" name="about" type="text" placeholder="نبذة عن الموضوع" value="<?php echo $blog["about"]; ?>">
                    </div>
                    <div class="form-group mb-5">
                        <h6 class="text-light bg-purple text-center p-3 mb-4 rounded-2">نص المدونة</h6>
                        <div id="editor">
                            <div class="ql-editor" contenteditable="true" data-placeholder="اضغط هنا للكتابة ..." value=<?php echo $blog['content'];?></div>
                        </div>
                    </div>
                    <button type="submit" class="btn border-1 text-purple border-purple w-100" style="border: 1px solid var(--purple);">إنشاء</button>
                </form>
            </div>
        </section>
        
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/modal-add-writer.php" ?>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/footer.php" ?>
    
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/parts/js-scripts.php" ?>
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
        <script src="../../assets/js/index.js"></script>
        <script>
            const quill = new Quill('#editor', {
                modules: {
                    toolbar: [
                    ['bold', 'italic'],
                    [{ header: '3' }, {header: '4'}],
                    [{ 'color': ['#000', '#616161', '#8f80b2', '#492E87', '#198754', '#dc3545', '#ffc107', '#d97706'] }],
                    ['link', 'blockquote', { list: 'bullet' }]
                    
                ],
                clipboard: {
                    matchVisual: false
                },
                },
                placeholder: 'اضغط هنا للكتابة ...',
                theme: 'bubble',
            });

            quill.format('direction', 'rtl');
            quill.format('align', 'right');
            quill.format('font-family', "'Noto Kufi Arabic', sans-serif");

            const form = document.querySelector('form');
            form.addEventListener('formdata', (event) => {
                // Append Quill content before submitting
                let h3 = document.querySelectorAll('h3');
                for (let index = 0; index < h3.length; index++) {
                    h3[index].id = index;
                }
                var quillHtml = quill.root.innerHTML.trim();
                event.formData.append('content', quillHtml);
            });
            function add_writer(button) {

                let form = document.querySelector("#add_writer_form");
                let formData = new FormData(form);

                const xhttp = new XMLHttpRequest();
                xhttp.onload = function () {
                    if (this.readyState == 4) {
                        const msg = document.querySelector('#added_writer_msg');
                        // msg.classList.add('show');
                        msg.innerHTML = this.responseText;
                        msg.classList.add('show');
                        
                    }
                };
                xhttp.open('POST', `../../functions/add-writer.php`, true);
                xhttp.send(formData);
            }
        </script>
    </body>
</html>