
<div id="posts_area" style="text-align:center; min-height: 500px; width:100%; flex:2.5; padding-right: 0px; background-color:azure;">
    <div style="padding: 20px; max-width:350px; display:inline-block;">
        <form method="post" enctype="multipart/form-data">
            <?php
                $settings_class = new Settings();
                $settings = $settings_class->get_settings($_SESSION['one4all_userid']);
                if(is_array($settings))
                {
                    echo "<input type='text' id='textbox' name='first_name' value=".htmlspecialchars($settings['first_name'])." placeholder='First name' />";
                    echo "<input type='text' id='textbox' name='last_name' value=".htmlspecialchars($settings['last_name'])." placeholder='Last name' />";
                    echo "<select id='textbox' value=".htmlspecialchars($settings['gender'])." style='height:30px'>
                        <option>$settings[gender]</option>    
                        <option>Male</option>
                        <option>Female</option>
                        <option>Other</option>
                        <option>Prefer not to say</option>
                    </select>";
                    echo "<input type='text' id='textbox' name='email' value=".htmlspecialchars($settings['email'])." placeholder='Email' />";
                    echo "<input type='password' id='textbox' name='password' value=".htmlspecialchars($settings['password'])." placeholder='Password' />";
                    echo "<input type='password' id='textbox' name='password2' value=".htmlspecialchars($settings['password'])." placeholder='Password' />";
                    echo "<br>About me: <br>
                        <textarea id='textbox' name='about' style='height:200px'>".htmlspecialchars($settings['about'])."</textarea>
                    ";
                    echo '<input id="post_button" type="submit" value="Save" >';
                }
                
            ?>
        </form>
    </div>
</div>