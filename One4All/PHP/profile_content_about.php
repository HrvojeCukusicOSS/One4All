
<div id="posts_area" style="text-align:center; min-height: 500px; width:100%; flex:2.5; padding-right: 0px; background-color:azure;">
    <div style="padding: 20px; max-width:350px; display:inline-block;">
        <form method="post" enctype="multipart/form-data">
            <?php
                $settings_class = new Settings();
                $settings = $settings_class->get_settings($_SESSION['one4all_userid']);
                if(is_array($settings))
                {
                    echo "<br>About me: <br>
                        <div id='textbox' name='about' style='height:200px; border:none;'>".htmlspecialchars($settings['about'])."</div>
                    ";
                }
                
            ?>
        </form>
    </div>
</div>