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
        if(isset($_POST['first_name']))
        {
            $settings_class=new Settings();
            $settings_class->save_settings($_POST, $user_id);
        }else
        {
            $post = new Post();
            $result = $post->create_post($user_id, $_POST, $_FILES);
            if($result == "")
            {
                header("Location: profile.php");
                die;
            }else
            {
                echo "<div style='text-align:center; font-size:12px; color:white; background-color:grey;'>";
                echo "<br>The following errors occured <br><br>";
                echo $result;
                echo "</div>";
            }
        }
        
    }
    $id = $user_data['userid'];
    $post = new Post();
    $posts = $post->get_posts($id);

    $user = new User();
    $friends = $user->get_following($id, "user");

    $image_class = new Image();
?>
<html>
    <head>
        <title>Profile | One4All</title>
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
        #textbox{
            width: 100%;
            height: 20px;
            border-radius: 5px;
            border: none;
            padding: 4px;
            font-size: 14px;
            border: solid thin grey;
            margin: 10px;
        }
        #profile_pic{
            width: 100px;
            margin-top: -85px;
            border-radius: 50%;
            border: solid 2px azure;
        }
        #menu_buttons{
            width: 100px;
            display: inline-block;
            margin: 2px;
            color: #91c0ab;
        }
        #friends_img{
            width: 75px;
            float: left;
            margin: 8px;
        }
        #friends_bar{
            background-color: azure;
            min-height: 400px;
            margin-top: 20px;
            color: #aaa;
            padding: 8px;
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
            min-width: 50px;
            cursor: pointer;
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
            <div id="cover_area" style="background-color: azure; text-align: center; color: #91c0ab">
            	<?php
                    $image = "../Icons/cover.jpg";
                    if(file_exists($user_data['cover_image']))
                    {
                       $image = $image_class->get_thumb_cover($user_data['cover_image']);
                    }
                ?>    
                <img src="<?php echo $image?>" style="width:100%;">
                
                <?php 
                    $image = "../Icons/default.jpg";
                    if(file_exists($user_data['profile_image']))
                    {
                            
                       $image = $image_class->get_thumb_profile( $user_data['profile_image']);
                    }
                ?>
                
                <span>
                    <img id="profile_pic" src="<?php echo $image?>"><br>
                    <a href="change_pfp.php?change=profile" style="font-size:12px; text-decoration: none; color:aquamarine;">
                        Change pfp
                    </a> |
                    <a href="change_pfp.php?change=cover" style="font-size:12px; text-decoration: none; color:aquamarine;">
                        Change cover
                    </a>
                </span>
                <br>
                <div style="font-size: 20px;">
                    <a href="profile.php?id=<?php echo $user_data['userid'];?>" style="text-decoration: none; color:#91c0ab;">
                        <?php echo htmlspecialchars($user_data["first_name"]) . " " . htmlspecialchars($user_data["last_name"])?> <br>
                    </a>
                    <?php
                        $followers= "";
                        if($user_data['likes'] > 0)
                        {
                            $followers = "(" . $user_data['likes'] . " Friends)";
                        }
                    ?>
                    <a href="like.php?type=user&id=<?php echo $user_data['userid']?>">
                        <input id="post_button" type="button" value="Friend <?php echo $followers?>" style="margin-right: 10px; width: auto;">
                    </a>
                </div>
                <br>
                

                <a href="index.php"><div id="menu_buttons">Timeline</div></a>
                <a href="profile.php?section=about&id=<?php echo $user_data['userid'];?>"><div id="menu_buttons">About</div></a>
                <a href="profile.php?section=followers&id=<?php echo $user_data['userid'];?>"><div id="menu_buttons">Mutuals</div></a>
                <a href="profile.php?section=following&id=<?php echo $user_data['userid'];?>"><div id="menu_buttons">Friends</div></a>
                <a href="profile.php?section=photos&id=<?php echo $user_data['userid'];?>"><div id="menu_buttons">Photos</div></a>
                <?php
                    if($user_data['userid'] == $user_id)
                    {
                        echo '<a href="profile.php?section=settings&id='.$user_data['userid'].'"><div id="menu_buttons">Settings</div></a>';

                    }
                ?>
                
            </div>
            <?php
                $section = "default";
                if(isset($_GET['section']))
                {
                    $section = $_GET['section'];
                }
                if($section == "default")
                {
                    include("profile_content_default.php");
                }else if($section == "photos")
                {
                    include("profile_content_photos.php");
                }else if($section == "followers")
                {
                    include("profile_content_followers.php");
                }else if($section == "following")
                {
                    include("profile_content_following.php");
                }else if($section == "about")
                {
                    include("profile_content_about.php");
                }else if($section == "settings")
                {
                    include("profile_content_settings.php");
                }
                
            ?>
        </div>
    </body>
</html>