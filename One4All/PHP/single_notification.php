<?php
    $User = new User();
    $actor = $User->get_user($notif_row['userid']);
    $owner = $User->get_user($notif_row['content_owner']);
    $id=esc($_SESSION['one4all_userid']);
    $link = "";
    if($notif_row['content_type'] == "post")
    {
        $link = "single_post.php?id=$notif_row[contentid]";
    }else if($notif_row['content_type'] == "profile")
    {

    }else if($notif_row['content_type'] == "comment")
    {

    }
?>

<a href="<?php echo $link?>" style="text-decoration: none;">
    <div id="notification">
        
        <?php
            if(is_array($actor) && is_array($owner))
            {
                echo "<img src='../Icons/default.jpg' style='width:36px; margin:2px; float: left;'>";
                
                if($actor['userid'] != $id)
                {
                    echo $actor['first_name'] . " " . $actor['last_name'];
                }else
                {
                    echo $actor['first_name'];
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
                echo $notif_row['content_type'];
                $date = date("jS M Y H:i:s", strtotime($notif_row['date']));
                echo "<br> 
                    <span style='float:left; font-size:11px;color:#888; display: inline-block; margin-left:10px;'>$date</span>
                ";
            }
        ?>
    </div>
</a>