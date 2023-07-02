<div id="posts_area" style="text-align:center; min-height: 500px; width:100%; flex:2.5; padding-right: 0px; background-color:azure;">
    <div style="padding: 20px;">
        <?php

            $DB = new Database();
            $sql = "select image,postid from posts where has_image = 1 && userid = $user_data[userid] order by id desc limit 30";
            $images = $DB->read($sql);

            $image_class = new Image();
            if(is_array($images))
            {
                foreach ($images as $image_row) {
                    echo "<img src='" . $image_class->get_thumb_post($image_row['image']) . "' style='width:150px; margin:10px;'/>";
                }
            }else
            {
                echo "No images were found!";
            }
        ?>
    </div>
</div>