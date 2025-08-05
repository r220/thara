<?php

class LoginValidator
{

    private $email;
    private $password;
    private $pdo;

    function __construct(string $email, string $password,  object $pdo)
    {
        $this->email = $email;
        $this->password = $password;
        $this->pdo = $pdo;
    }

    function get_user_data()
    {
        return get_user_email($this->pdo, $this->email);
    }

    function validate_data()
    {

        $errors = [];

        if (empty($this->email) || empty($this->password)) {
            $errors["incomplete_form"] = "* يرجى ملء جميع الحقول";
        }

        $user = $this->get_user_data();

        if (!$user) {
            $errors["invalid_username"] = "* تم إدخال بريد إلكتروني غير صالح";
        }

        // if ($user &&  !password_verify($this->password, $user["pwd"])) {
        //     $errors["invalid_password"] = "* تم إدخال كلمة مرور غير صالحة";
        // }

        if ($user &&  $this->password != $user["pwd"]) {
            $errors["invalid_password"] = "* تم إدخال كلمة مرور غير صالحة";
        }
        if (!empty($errors)) {
            $_SESSION["login_errors"] = $errors;
            header("Location: ../login.php");
            die();
        }
    }
};

class video_validator {
    private $link;
    private $title;
    private $about;
    private $pdo;

    function __construct(string $link, string $title, string $about,  object $pdo)
    {
        $this->link = $link;
        $this->title = $title;
        $this->about = $about;
        $this->pdo = $pdo;
    }
    function video_exist() {
        return get_video($this->pdo, $this->link);
    }
    function validate_data()
    {

        $errors = [];

        if (empty($this->link) || empty($this->title)) {
            $errors["incomplete_form"] = "* يرجى ملء جميع الحقول الإلزامية";
        }

        if (!empty($errors)) {
            $_SESSION["video_errors"] = $errors;
            $_SESSION["open_modal"] = true;
            header("Location: ../videos.php");
            die();
        }
    }
}

class blog_validator {
    private $title;
    private $content;
    private $pdo;

    function __construct(string $title, string $content,  object $pdo)
    {
        $this->title = $title;
        $this->content = $content;
        $this->pdo = $pdo;
    }
    
    function validate_data()
    {

        $errors = [];

        if (empty($this->link) || empty($this->title)) {
            $errors["incomplete_form"] = "* يرجى ملء جميع الحقول الإلزامية";
        }

        if (!empty($errors)) {
            $_SESSION["video_errors"] = $errors;
            $_SESSION["open_modal"] = true;
            header("Location: ../videos.php");
            die();
        }
    }
}