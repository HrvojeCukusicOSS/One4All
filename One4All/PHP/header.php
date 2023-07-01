<?php

    $corner_image = "../Icons/default.jpg";
    if(file_exists($USER['profile_image']))
    {
        $image_class = new Image();
        $corner_image = $image_class->get_thumb_profile($USER['profile_image']);
    }
?>

<div id="head_bar">
    <div style=" width: 800px; margin:auto; font-size: 30px;">
        <a href="index.php" style="color: azure; text-decoration: none;">One4All</a> 
        &nbsp &nbsp <input type="search" id="search_box" placeholder="Search for people">
        <a href="profile.php">
            <img src="<?php echo $corner_image?>" style="width:50px; float:right;">
        </a>
        <a href="logout.php">
            <span style="font-size: 11px; float: right; margin: 10px; color: azure;">Logout</span>
        </a>
    </div> 
</div>