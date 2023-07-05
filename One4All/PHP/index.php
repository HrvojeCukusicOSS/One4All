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
            header("Location: index.php");
            die;
        }else
        {
            echo "<div style='text-align:center; font-size:12px; color:white; background-color:grey;'>";
            echo "<br>The following errors occured <br><br>";
            echo $result;
            echo "</div>";
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Timeline | One4All</title>
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
                <div id="friends_bar"> 
                <?php 
                    $image = "../Icons/default.jpg";
                    if(file_exists($user_data['profile_image']))
                    {
                            
                       $image = $image_class->get_thumb_profile( $user_data['profile_image']);
                    }
                ?>
                <span>
                    <img id="profile_pic" src="<?php echo $image?>">
                    <br>
                    <a href="profile.php" style="color: #91c0ab; text-decoration: none;">
                        <?php echo htmlspecialchars($user_data['first_name']) . "<br>" . htmlspecialchars($user_data['last_name'])?>
                    </a>
                </span>
                </div>
                <div id="posts_area" style="min-height: 500px; flex:2.5; padding: 20px; padding-right: 0px;">
                    <div style="border: solid thin #aaa; padding: 10px; background-color:azure">
                        <form method="post" enctype="multipart/form-data">
                            <textarea name="post" placeholder="What's on your mind?" cols="30" rows="5"></textarea>
                            <input type="file" name="file">
                            <input id="post_button" type="submit" value="Post" >
                            <br>
                        </form>
                    </div>
                    <div id="posts_bar">
                    <?php                                 
                            $DB = new Database();
                            $user_class = new User();
                            $image_class = new Image();
                            $myuserid = $_SESSION['one4all_userid'];
                            $followers = $user_class->get_following($myuserid, "user");
                            $sql = "select * from posts where userid = '$myuserid' order by id desc limit 30";
                            $posts = $DB->read($sql);
                            $follower_ids = false;
                            if(is_array($followers))
                            {                                    
                                $follower_ids = array_column($followers, "userid");
                                $follower_ids = implode("','", $follower_ids);
                            }
                            if($follower_ids)
                            {
                                $sql = "select * from posts where userid = '$myuserid' or userid in('" . $follower_ids . "') order by id desc limit 30";
                                $posts = $DB->read($sql);
                            }
                             
                            if($posts)
                            {
                                    
                                foreach ($posts as $ROW) 
                                {    
                                    $user = new User();
                                    $ROW_USER = $user->get_user($ROW["userid"]); 
                                    include("post.php");
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>