<?php

// function to secure page
function secure()
{
    if (!isset($_SESSION['id'])) { //if session is not set...
        set_message('Please login first to view this page.');
        header('location: /'); //if not logged in, redirect to the login page.
        die();
    }
}

function set_message($message)
{
    $_SESSION["message"] = $message;
}

function get_message()
{
    if (isset($_SESSION["message"])) {
        echo "<script type = 'text/javascript'> 
            showToast( ' " . $_SESSION["message"] . " ' , 'top right', 'success')
        </script>";

        unset($_SESSION["message"]);

    }
}



