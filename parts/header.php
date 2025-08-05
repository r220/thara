<?php 
$base_url = "http://" . $_SERVER['HTTP_HOST'];
?>

<header class="d-flex justify-content-center z-3">
    <nav id="navbar" class="navbar navbar-expand-lg container bg-light rounded-3">
        <div class="container-fluid">
            <a class="navbar-brand text-purple" href="<?php echo $base_url;?>/index.php">LOGO</a>
            <button class="navbar-toggler text-purple" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon text-purple"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav text-center">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $base_url;?>/index.php">الرئيسية</a>
                    </li>
                    <hr class="my-0">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $base_url;?>/videos.php">الإذاعة</a>
                    </li>
                    <hr class="my-0">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $base_url;?>/blogs.php">المدونة</a>
                    </li>
                    <hr class="my-0">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $base_url;?>/us.php">من نحن</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>