<?php
    include("../Classes/autoload.php");

    $user_id = $_SESSION["one4all_userid"];
    $login = new Login();
    $user_data = $login->check_login($user_id);
    
    $DB = new Database();
    $error = "";
    $Post = new Post();
    if(isset($_GET['id']))
    {
        
        $ROW = $Post->get_single_posts($_GET['id']);
        if(!$ROW){
            $error = "No such post exists!";
        }else
        {
            if($ROW['userid'] != $_SESSION["one4all_userid"])
            {
                $error = "Acces denied!";
            }
        }
    }else
    {
        $error = "No such post exists!";
    }

    if($_SERVER['REQUEST_METHOD']=="POST")
    {
        $Post->delete_post($_POST['postid']);
        header("Location: profile.php");
        die;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Delete | One4All</title>
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
                        <form method="post">
                            
                            <?php
                                if($error != "")
                                {
                                    echo $error;
                                }else
                                {
                                    echo "Are you sure you want to delete this post?<br><br>";
                                    $user = new User();
                                    $ROW_USER=$user->get_user($ROW['userid']);
                                    include("post_delete.php");
                                    echo "<input name='postid' type='hidden' value='$ROW[postid]'>";
                                    echo "<input id='post_button' type='submit' value='Delete' >";
                                }
                                
                            ?>
                            
                            <br>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>