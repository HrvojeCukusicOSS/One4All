<div id="post" style="background-color: #e6f5f5;">
    <div >
        <?php 
            $image = "../Icons/default.jpg";
            $comment_user = new User();
            $comment_owner = $comment_user->get_user($COMMENT['userid']);
            if(file_exists($comment_owner['profile_image']))
            {
                $image = $image_class->get_thumb_profile($comment_owner['profile_image']);
            }
        ?>
        <img src="<?php echo $image?>" style=" border-radius: 50%; width: 75px; margin: 4px;">                 
    </div>
    <div>
        <div style="font-weight: bold; color: #91c0ab; width:100%">
            <?php 
                echo "<a href='profile.php?id=$comment_owner[userid]' style='text-decoration: none; color:#91c0ab;'>";
                echo $comment_owner['first_name'] . " " . $comment_owner['last_name'];
                echo "</a>";
            ?>
        </div>
    </div>
    <div style="width: 100%;">
        <?php echo htmlspecialchars($COMMENT["content"])?>
        <br><br>
        <?php
            if(file_exists($COMMENT['image']))
            {
                $post_image = $image_class->get_thumb_post($COMMENT['image']);
                echo "<img src='$post_image' style='width: 80%;'>";
            }
        ?>
        <?php
            $likes = "";
            $likes = ($COMMENT['likes'] > 0) ? " (" . $COMMENT['likes'] . ")": "";
        ?>
        <br><br>
        <a href="like.php?type=post&id=<?php echo $COMMENT['postid']?>">Like<?php echo $likes?></a> . 
        <span style="color: #999;">
            <?php echo htmlspecialchars($COMMENT['date'])?>
        </span>
        <?php
            if($COMMENT['has_image'])
            {
                echo ".";
                echo "<a href='image_view.php?id=$COMMENT[postid]' style='text-decoration: none;'> View full image </a>";
                echo ".";
            }
        ?>
        <span style="color: #999; float: right;">
            <?php
                $post = new Post();
                if($post->i_own_post($COMMENT['postid'], $_SESSION['one4all_userid']))
                {
                    echo "
                    <a href='edit.php?id=$COMMENT[postid]'>
                        Edit
                    </a>
                    . 
                    <a href='delete.php?id=$COMMENT[postid]'>
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
                
                $sql = "select likes from likes where type='post' && contentid = '$COMMENT[postid]' limit 1";
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
            if($COMMENT['likes'] > 0)
            {
                echo "<br>";
                echo "<a href='likes.php?type=post&id=$COMMENT[postid]'>";
                if($COMMENT['likes'] == 1)
                {
                    if($i_liked)
                    {
                        echo "<div style='text-align: left;'> You liked this post</div>";
                    }else
                    {
                        echo "<div style='text-align: left;'>" . $COMMENT['likes'] . " person likes this post</div>";
                    }
                }else
                {
                    $text = "others";
                    if($i_liked)
                    {
                        if(($COMMENT['likes']-1) == 1)
                        {
                            $text = "other";
                        }
                        echo "<div style='text-align: left;'> You and " . ($COMMENT['likes']-1) . " $text liked this post</div>";
                    }else
                    {
                        echo "<div style='text-align: left;'>" . $COMMENT['likes'] . " $text liked this post</div>";
                    }
                }
                echo "</a>";    
            }
        ?>
    </div>
</div>