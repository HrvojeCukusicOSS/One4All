<div id="post">
    <div >
        <?php
            $image = "../Icons/default.jpg";
            $image_class = new Image();
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
                echo htmlspecialchars($ROW_USER['first_name']) . " " . htmlspecialchars($ROW_USER['last_name']);
                
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
    </div>
</div>