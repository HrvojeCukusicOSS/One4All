<div style="display: flex;">
    <div id="friends_area" style="text-align: center; min-height: 500px; flex:0.50; flex-direction: column;">
        <div id="friends_bar">
            Mutuals<br>
            <?php 
                if($friends)
                {
                    foreach ($friends as $friend)
                    { 
                        $FRIEND_ROW = $user->get_user($friend['userid']);
                        include("firend.php");
                    }
                }
            ?>
        </div>      
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
                if($posts)
                {
                    foreach ($posts as $ROW) 
                    {    
                        $user = new User();
                        $ROW_USER = $user->get_user($ROW["userid"]); 
                        include("post.php");
                    }
                }
                $pg=pagination_link();
            ?>
            <a href="<?php echo $pg['prev_page']?>">
                <input id="post_button" type="button" value="Previous page" style="float: left; width: 100px;">
            </a>
            <a href="<?php echo $pg['next_page']?>">
                <input id="post_button" type="button" value="Next page" style="float: right; width: 100px;">
            </a>
        </div>
    </div>
</div>