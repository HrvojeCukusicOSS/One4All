<?php

    session_start();
    if(isset($_SESSION["one4all_userid"]))
    {
        $_SESSION["one4all_userid"] = NULL;
        unset($_SESSION["one4all_userid"]);
    }
    
    header("Location: login.php");
    die;