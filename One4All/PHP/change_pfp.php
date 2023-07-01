<?php
    include("../Classes/autoload.php");

    $user_id = $_SESSION["one4all_userid"];
    $login = new Login();
    $user_data = $login->check_login($user_id);
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != "")
        {
            if($_FILES['file']['type'] == "image/jpeg")
            {
                $alowed_size = (1024*1024) * 3;
                if($_FILES['file']['size'] < $alowed_size)
                {
                    $folder = "../Uploads/" . $user_data['userid'] . "/";

                    if(!file_exists($folder))
                    {
                        mkdir($folder, 0777, true);
                    }

                    $image = new Image();

                    $filename = $folder . $image->generate_filename(15) . ".jpg";
                    move_uploaded_file($_FILES['file']['tmp_name'], $filename);
                    $change = "profile";

                    if(isset($_GET['change']))
                    {
                        $change = $_GET['change'];
                    }
                    
                    $file = $filename;

                    if($change == "cover")
                    {
                        if(file_exists($user_data['cover_image']))
                        {
                            unlink($user_data['cover_image']);
                        }
                        $image->resize_image($file, $file, 1500, 1500);
                    }else
                    {
                        if(file_exists($user_data['profile_image']))
                        {
                            unlink($user_data['profile_image']);
                        }
                        $image->resize_image($file, $file, 1500, 1500);
                    }
                
                    if(file_exists($file))
                    {
                        $user_id = $user_data['userid'];

                        if($change == "cover")
                        {
                            $query = "update users set cover_image = '$filename' where userid = '$user_id' limit 1";
                            $_POST['is_cover'] = 1;
                        }else
                        {
                            $query = "update users set profile_image = '$filename' where userid = '$user_id' limit 1";
                            $_POST['is_profile'] = 1;
                        }
                        
                        $DB = new Database();
                        $DB->save($query);

                        $post = new Post();
                        $result = $post->create_post($user_id, $_POST, $file);

                        header("Location: profile.php");
                        die;
                    }
                }else
                {
                    echo "<div style='text-align:center; font-size:12px; color:white; background-color:grey;'>";
                    echo "<br>The following errors occured <br><br>";
                    echo "Only images below 3mb!";
                    echo "</div>";
                }
            }else
            {
                echo "<div style='text-align:center; font-size:12px; color:white; background-color:grey;'>";
                echo "<br>The following errors occured <br><br>";
                echo "Please add valid image file to upload!";
                echo "</div>";
            }
        }else
        {
            echo "<div style='text-align:center; font-size:12px; color:white; background-color:grey;'>";
            echo "<br>The following errors occured <br><br>";
            echo "Please add image to upload!";
            echo "</div>";
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Change pfp | One4All</title>
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
        #post_button{
            float: right;
            background-color: #91c0ab;
            border: none;
            padding: 4px;
            font-size: 14px;
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
            <form method="post" enctype="multipart/form-data">    
                <div id="posts_bar" style="min-height: 500px; flex:2.5; padding: 20px; padding-right: 0px;">
                        <div style="border: solid thin #aaa; padding: 10px; background-color:azure">
                            <input type="file" name="file">    
                            <input id="post_button" type="submit" value="Change" >
                            <br>
                            <div style="text-align: center;">
                                <br><br>
                                <?php
                                    $change = "profile";

                                    if(isset($_GET['change']) && $_GET['change'] == "cover")
                                    {
                                    $change = "cover";
                                    echo "<img src = '$user_data[cover_image]' style = 'max-width:500px'>";
                                    }else
                                    {
                                        echo "<img src = '$user_data[profile_image]' style = 'max-width:500px'>";
                                    }
                                    
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>