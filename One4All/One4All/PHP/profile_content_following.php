<div id="posts_area" style="text-align:center; min-height: 500px; width:100%; flex:2.5; padding-right: 0px; background-color:azure;">
    <div style="padding: 20px;">
        <?php
            $image_class = new Image();
            $post_class = new Post();
            $user_class = new User();
            $following = $user_class->get_following($user_data['userid'], "user");
            if(is_array($following))
            {
                foreach ($following as $follower) {
                    $FRIEND_ROW = $user_class->get_user($follower['userid']);
                   include("firend.php");
                }
            }else
            {
                echo "This user isn't following anyone!";
            }
        ?>
    </div>
</div>