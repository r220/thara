<?php

function render_login_messages()
{

    // if (isset($_SESSION["signup_success"])) {
    //     echo '<p style="color:green">' . $_SESSION["signup_success"] . '</p>';
    //     unset($_SESSION["signup_success"]);
    // }

    if (isset($_SESSION["login_errors"])) {
        foreach ($_SESSION["login_errors"] as $error) {
            echo '<p style="color: #fff200">' . $error . '</p>';
        }
        unset($_SESSION["login_errors"]);
    }
}