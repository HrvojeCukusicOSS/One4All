<div id="friends">
    <?php 
        $image = "../Icons/default.jpg";
        if(file_exists($FRIEND_ROW['profile_image']))
        {
           $image = $image_class->get_thumb_profile($FRIEND_ROW['profile_image']);
        }
    ?>
    <a href="profile.php?id=<?php echo $FRIEND_ROW['userid'];?>" style="text-decoration: none; color:#91c0ab">
        <img id="friends_img" src="<?php echo $image?>">
        <br>
        <?php echo htmlspecialchars($FRIEND_ROW['first_name']) . " " . htmlspecialchars($FRIEND_ROW['last_name'])?>
    </a>
</div>