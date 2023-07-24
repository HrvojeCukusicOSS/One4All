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
    
    $DB = new Database();
    $error = "";
    $Post = new Post();
    $User = new User();
    $image_class = new Image();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Notifications | One4All</title>
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
        #notification
        {
            height: 40px;
            background-color: #e6f5f5;
            color: #666;
            border: 1px solid #aaa;
            margin: 6px;
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
                            $DB = new Database();
                            $id = esc($_SESSION['one4all_userid']);
                            $query = "select * from notifications where userid != '$id' and content_owner = '$id' order by id desc limit 30";
                            $data = $DB->read($query);
                        ?>

                        <?php if(is_array($data)): ?>
                            <?php 
                                foreach ($data as $notif_row)
                                {
                                    include("single_notification.php");
                                }
                            ?>
                        <?php else : ?>
                            No notifications were found!
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>