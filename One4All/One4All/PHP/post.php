<div id="post">
    <div >
        <?php 
            $image = "../Icons/default.jpg";
            if(file_exists($ROW_USER['profile_image']))
            {
                $image = $image_class->get_thumb_profile($ROW_USER['profile_image']);
            }
        ?>
        <img src="<?php echo $image?>" style=" border-radius: 50%; width: 75px; margin: 4px;">                 
    </div>
    <div style="width: 100%;">
        <div style="font-weight: bold; color: #91c0ab; width:100%">
            <?php 
                echo "<a href='profile.php?id=$ROW[userid]' style='text-decoration: none; color:#91c0ab;'>";
                echo htmlspecialchars($ROW_USER['first_name']) . " " . htmlspecialchars($ROW_USER['last_name']);
                echo "</a>";
                if($ROW['is_profile'])
                {
                    $pronpun = "his";
                    if($ROW_USER['gender'] == "Female")
                    {
                        $pronpun = "her";
                    }
                    echo "<span style='font-weight:normal;color:#aaa;'> updated $pronpun profile image</span>";
                }
                if($ROW['is_cover'])
                {
                    $pronpun = "his";
                    if($ROW_USER['gender'] == "Female")
                    {
                        $pronpun = "her";
                    }
                    echo "<span style='font-weight:normal;color:#aaa;'> updated $pronpun cover image</span>";
                }
            ?>
        </div>
        <?php echo htmlspecialchars($ROW["content"])?>
        <br><br>
        <?php
            if(file_exists($ROW['image']))
            {
                $post_image = $image_class->get_thumb_post($ROW['image']);
                echo "<img src='$post_image' style='width: 80%;'>";
            }
        ?>
        <?php
            $likes = "";
            $likes = ($ROW['likes'] > 0) ? " (" . $ROW['likes'] . ")": "";
        ?>
        <?php
            $comments = "";
            $comments = ($ROW['comments'] > 0) ? " (" . $ROW['comments'] . ")": "";
        ?>
        <br><br>
        <a href="like.php?type=post&id=<?php echo $ROW['postid']?>">Like<?php echo $likes?></a> . <a href="single_post.php?id=<?php echo $ROW['postid']?>">Comment<?php echo $comments?></a> . 
        <span style="color: #999;">
            <?php
                $time = new Time();
                echo $time->get_time($ROW['date']);
            ?>
        </span>
        <?php
            if($ROW['has_image'])
            {
                echo ".";
                echo "<a href='image_view.php?id=$ROW[postid]' style='text-decoration: none;'> View full image </a>";
                echo ".";
            }
        ?>
        <span style="color: #999; float: right;">
            <?php
                $post = new Post();
                if($post->i_own_post($ROW['postid'], $_SESSION['one4all_userid']))
                {
                    echo "
                    <a href='edit.php?id=$ROW[postid]'>
                        Edit
                    </a>
                    . 
                    <a href='delete.php?id=$ROW[postid]'>
                        Delete
                    </a>";
                }
                
            ?>
        </span>
        <?php
            $i_liked = false;
            if(isset($_SESSION['one4all_userid']))
            {
                
                $DB= new Database();
                
                $sql = "select likes from likes where type='post' && contentid = '$ROW[postid]' limit 1";
                $result = $DB->read($sql);
                
                if(is_array($result))
                {
                    $likes = json_decode($result[0]['likes'], true);

                    $user_ids[] = array();
                    foreach($likes as $like)
                    {
                        $user_ids[] = $like["userid"];
                    }

                    if(in_array($_SESSION['one4all_userid'], $user_ids))
                    {
                        $i_liked = true;
                    }
                }
            }
            if($ROW['likes'] > 0)
            {
                echo "<br>";
                echo "<a href='likes.php?type=post&id=$ROW[postid]'>";
                if($ROW['likes'] == 1)
                {
                    if($i_liked)
                    {
                        echo "<div style='text-align: left;'> You liked this post</div>";
                    }else
                    {
                        echo "<div style='text-align: left;'>" . $ROW['likes'] . " person likes this post</div>";
                    }
                }else
                {
                    $text = "others";
                    if($i_liked)
                    {
                        if(($ROW['likes']-1) == 1)
                        {
                            $text = "other";
                        }
                        echo "<div style='text-align: left;'> You and " . ($ROW['likes']-1) . " $text liked this post</div>";
                    }else
                    {
                        echo "<div style='text-align: left;'>" . $ROW['likes'] . " $text liked this post</div>";
                    }
                }
                echo "</a>";    
            }
        ?>
    </div>
</div>