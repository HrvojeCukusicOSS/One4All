<?php
    $User = new User();
    $actor = $User->get_user($notif_row['userid']);
    $owner = $User->get_user($notif_row['content_owner']);
    $id=esc($_SESSION['one4all_userid']);
    $link = "";
    if($notif_row['content_type'] == "post")
    {
        $link = "single_post.php?id=$notif_row[contentid]" . "&notif=" . $notif_row['id'];
    }else if($notif_row['content_type'] == "profile")
    {
        $link = "profile.php?id=" . $notif_row['userid'] . "&notif=" . $notif_row['id'];
    }else if($notif_row['content_type'] == "comment")
    {
        $link = "single_post.php?id=$notif_row[contentid]" . "&notif=" . $notif_row['id'];
    }

    $color = "#e6f5f5";
    $query = "select * from  notification_seen where userid = '$id' and notificationid = '$notif_row[id]' limit 1";
    $seen = $DB->read($query);
    if(is_array($seen))
    {
       $color = "#a8efff"; 
    }
    
    
?>

<a href="<?php echo $link?>" style="text-decoration: none;">
    <div id="notification" style="background-color: <?= $color ?>">
        
        <?php
            if(is_array($actor) && is_array($owner))
            {
                $image = "../Icons/default.jpg";
                if(file_exists($actor['profile_image']))
                {
                    $image = $image_class->get_thumb_profile($actor['profile_image']);
                }

                echo "<img src='$image' style='width:36px; margin:2px; float: left;'>";
                
                if($actor['userid'] != $id)
                {
                    echo $actor['first_name'] . " " . $actor['last_name'];
                }else
                {
                    echo "You"; 
                }
                if($notif_row['activity'] == "like")
                {
                    echo " liked ";
                }elseif($notif_row['activity'] == "follow")
                {
                    echo " followed ";
                }
                if($owner['userid'] != $id)
                {
                    echo $owner['first_name'] . " " . $owner['last_name'] . "'s ";
                }else
                {
                    echo " your ";
                }
                if($notif_row['content_type'] == "post")
                {
                    $content_row = $Post->get_single_posts($notif_row['contentid']);
                    if(!empty($content_row['has_image']))
                    {
                        echo " image";
                        if(file_exists($content_row['image']) && $content_row['parent'] == 0)
                        {
                            $post_image = $image_class->get_thumb_post($content_row['image']);
                            echo "<img src='$post_image' style='width: 40px; float: right;'>";
                        }
                    }elseif(empty($content_row['image']) && $content_row['parent'] == 0)
                    {
                        echo $notif_row['content_type'];
                        echo "
                            <span style='float:right; font-size:11px;color:#888; display: inline-block; margin-left:10px;'>'".htmlspecialchars(substr($content_row['content'], 0, 50))."'</span>
                        ";
                    }else
                    {
                        echo " comment";
                        echo "
                            <span style='float:right; font-size:11px;color:#888; display: inline-block; margin-left:10px;'>'".htmlspecialchars(substr($content_row['content'], 0, 50))."'</span>
                        ";
                    }
                }else
                {
                    echo $notif_row['content_type'];
                }
                $date = date("jS M Y H:i:s", strtotime($notif_row['date']));
                echo "<br> 
                    <span style='float:left; font-size:11px;color:#888; display: inline-block; margin-left:10px;'>$date</span>
                ";
            }
        ?>
    </div>
</a>