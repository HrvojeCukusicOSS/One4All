<?php
    include("../Classes/autoload.php");

    $user_id = $_SESSION["one4all_userid"];
    $login = new Login();
    $user_data = $login->check_login($user_id);
    
    if(isset($_SERVER["HTTP_REFERER"]))
    {
        $return_to = $_SERVER["HTTP_REFERER"];
    }else
    {
        $return_to = "profile.php";
    }
    if(isset($_GET['type']) && isset($_GET['id']))
    {
        if(is_numeric($_GET['id']))
        {
            $allowed[]='post';
            $allowed[]='comment';
            $allowed[]='user';

            if(in_array($_GET['type'], $allowed))
            {
                $post = new Post();
                $user_class = new User();
                $single_post = false;
                if($_GET['type'] == "user")
                {
                    $post->like_post($_GET['id'], $_GET['type'], $_SESSION["one4all_userid"]);
                    $user_class->follow_user($_GET['id'], $_GET['type'], $_SESSION["one4all_userid"]);
                }
                else if($_GET['type'] == "post")
                {
                    $post->like_post($_GET['id'], $_GET['type'], $_SESSION["one4all_userid"]);
                }
            }
        }
        
    }
    

    header("Location: ".$return_to);
    