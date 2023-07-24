<?php
    include("../Classes/autoload.php");

    $user_id = $_SESSION["one4all_userid"];
    $login = new Login();
    $user_data = $login->check_login($user_id);

    
    $USER = $user_data;
    
    if(isset($_GET['id']) && is_numeric($_GET['id']))
    {
        $profile = new Profile();
        $profile_data = $profile->get_profile($_GET['id']);
        if(is_array($profile_data))
        {
            $user_data = $profile_data[0];
        }
    }

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $post = new Post();
        $result = $post->create_post($user_id, $_POST, $_FILES);
        if($result == "")
        {
            header("Location: single_post.php?id=$_GET[id]");
            die;
        }else
        {
            echo "<div style='text-align:center; font-size:12px; color:white; background-color:grey;'>";
            echo "<br>The following errors occured <br><br>";
            echo $result;
            echo "</div>";
        }
    }
    
    $error = "";
    $Post = new Post();
    $ROW = false;
    if(isset($_GET['id']))
    {
        $ROW = $Post->get_single_posts($_GET['id']);
    }else
    {
        $error = "No post found!";
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Single post | One4All</title>
    </head>
    <style type="text/css">
        #head_bar{
            height: 50px;
            background-color: #91c0ab;
            color: azure;
        }
        #search_box{
            width: 400px;
            height: 20px;
            border-radius: 5px;
            border: none;
            padding: 4px;
            font-size: 14px;
            background-image: url('../Icons/search.png');
            background-repeat: no-repeat;
            background-position: right;
            background-size: 15px;
        }
        #profile_pic{
            width: 100px;
            border-radius: 50%;
            border: solid 2px azure;
        }
        #menu_buttons{
            width: 100px;
            display: inline-block;
            margin: 2px;
        }
        #friends_img{
            width: 75px;
            float: left;
            margin: 8px;
        }
        #friends_bar{
            min-height: 400px;
            margin-top: 20px;
            padding: 8px;
            text-align: center;
            font-size: 20px;
            color: #91c0ab;
        }
        #friends{
            clear: both;
            font-size: 12px;
            font-weight: bold;
            color: #91c0ab;
        }
        textarea{
            width: 100%;
            border: none;
            font-family: tahoma;
            height: 60px;
            background-color: azure;
        }
        #post_button{
            float: right;
            background-color: #91c0ab;
            border: none;
            padding: 4px;
            font-size: 14px;
            width: 50px;
        }
        #posts_bar{
            margin-top: 20px;
            background-color: azure;
            padding: 10px;
        }
        #post{
            padding: 4px;
            font-size: 13px;
            display: flex;
            margin-bottom: 20px;
        }
</style>
<body style="font-family: tahoma; background-color: #F5FCF6;">
    <br>
    <?php include("header.php")?>
        <div style="width: 800px; margin: auto; min-height:800px;"> 
            <div style="display: flex;">
                <div id="posts_area" style="min-height: 500px; flex:2.5; padding: 20px; padding-right: 0px;">
                    <div style="border: solid thin #aaa; padding: 10px; background-color:azure"> 
                        <?php
                            $User = new User();
                            $image_class=new Image();
                            if(is_array($ROW))
                            {
                                $user = new User();
                                $ROW_USER = $user->get_user($ROW['userid']);
                                include("post.php");
                            }
                        ?>
                        <br style="clear: both;">
                        <div style="border: solid thin #aaa; padding: 10px; background-color:azure">
                            <form method="post" enctype="multipart/form-data">
                                <textarea name="post" placeholder="Post a comment" cols="30" rows="5"></textarea>
                                <input type="hidden" name="parent" value="<?php echo $ROW['postid']?>">
                                <input type="file" name="file">
                                <input id="post_button" type="submit" value="Post" >
                                <br>
                            </form>
                        </div>
                        <?php 
                            $page_number = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                            $page_number = ($page_number < 1) ? 1 : $page_number;
                            $pg = pagination_link();
                            $comments = $Post->get_comments($ROW['postid'], $page_number);
                            if(is_array($comments))
                            {
                                foreach ($comments as $COMMENT) {
                                    include("comment.php");
                                }
                            }
                            
                        ?>
                        <a href="<?php echo $pg['prev_page']?>">
                            <input id="post_button" type="button" value="Previous page" style="float: left; width: 100px;">
                        </a>
                        <a href="<?php echo $pg['next_page']?>">
                            <input id="post_button" type="button" value="Next page" style="float: right; width: 100px;">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>