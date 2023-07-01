<?php
    include("../Classes/autoload.php");

    $user_id = $_SESSION["one4all_userid"];
    $login = new Login();
    $user_data = $login->check_login($user_id);
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
                    <img id="profile_pic" src="../Icons/selfie.jpg" alt=""><br>
                    <a href="profile.php" style="color: #91c0ab; text-decoration: none;">
                        <?php echo htmlspecialchars($user_data['first_name']) . "<br>" . htmlspecialchars($user_data['last_name'])?>
                    </a>
                </div>
                <div id="posts_area" style="min-height: 500px; flex:2.5; padding: 20px; padding-right: 0px;">
                    <div style="border: solid thin #aaa; padding: 10px; background-color:azure">
                        <textarea placeholder="What's on your mind?" cols="30" rows="5"></textarea>
                        <input id="post_button" type="submit" value="Post" >
                        <br>
                    </div>
                    <div id="posts_bar">
                        <div id="post">
                            <div >
                                <img src="../Icons/user1.jpg" style="width: 75px; margin: 4px;">                 
                            </div>
                            <div>
                                <div style="font-weight: bold; color: #91c0ab">First user</div>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget venenatis enim. Aliquam sit amet vulputate nisi, eu malesuada lacus. Donec sit amet magna vitae nunc scelerisque iaculis. Fusce mattis tempus nisl, vitae semper tellus. Nulla nec orci euismod, tincidunt mauris sit amet, malesuada odio. Donec sit amet nulla est. Etiam aliquet blandit magna sed congue. Aenean eleifend, lacus ac feugiat commodo, felis sapien interdum felis, et pulvinar diam odio vitae ante. Aliquam ornare egestas lectus mollis auctor. Maecenas ut dui risus. Suspendisse at tellus ante. Nam bibendum aliquam risus, vel scelerisque metus porttitor ut. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque a condimentum magna, ut euismod mi. Praesent egestas vulputate rhoncus.
                                <br><br>
                                <a href="">Like</a> . <a href="">Comment</a> . <span style="color: #999;">April 24. 2020</span>
                            </div>
                        </div>

                        <div id="post">
                            <div >
                                <img src="../Icons/user2.jpg" style="width: 75px; margin: 4px;">                 
                            </div>
                            <div>
                                <div style="font-weight: bold; color: #91c0ab">Second user</div>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget venenatis enim. Aliquam sit amet vulputate nisi, eu malesuada lacus. Donec sit amet magna vitae nunc scelerisque iaculis. Fusce mattis tempus nisl, vitae semper tellus. Nulla nec orci euismod, tincidunt mauris sit amet, malesuada odio. Donec sit amet nulla est. Etiam aliquet blandit magna sed congue. Aenean eleifend, lacus ac feugiat commodo, felis sapien interdum felis, et pulvinar diam odio vitae ante. Aliquam ornare egestas lectus mollis auctor. Maecenas ut dui risus. Suspendisse at tellus ante. Nam bibendum aliquam risus, vel scelerisque metus porttitor ut. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque a condimentum magna, ut euismod mi. Praesent egestas vulputate rhoncus.
                                <br><br>
                                <a href="">Like</a> . <a href="">Comment</a> . <span style="color: #999;">April 24. 2020</span>
                            </div>
                        </div>

                        <div id="post">
                            <div >
                                <img src="../Icons/user3.jpg" style="width: 75px; margin: 4px;">                 
                            </div>
                            <div>
                                <div style="font-weight: bold; color: #91c0ab">Third user</div>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget venenatis enim. Aliquam sit amet vulputate nisi, eu malesuada lacus. Donec sit amet magna vitae nunc scelerisque iaculis. Fusce mattis tempus nisl, vitae semper tellus. Nulla nec orci euismod, tincidunt mauris sit amet, malesuada odio. Donec sit amet nulla est. Etiam aliquet blandit magna sed congue. Aenean eleifend, lacus ac feugiat commodo, felis sapien interdum felis, et pulvinar diam odio vitae ante. Aliquam ornare egestas lectus mollis auctor. Maecenas ut dui risus. Suspendisse at tellus ante. Nam bibendum aliquam risus, vel scelerisque metus porttitor ut. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque a condimentum magna, ut euismod mi. Praesent egestas vulputate rhoncus.
                                <br><br>
                                <a href="">Like</a> . <a href="">Comment</a> . <span style="color: #999;">April 24. 2020</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>