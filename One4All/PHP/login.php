<?php
    include("../Classes/autoload.php");
    $email = '';
    $password = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $login = new Login();
        $result = $login->evaluate($_POST);
        if($result != "")
        {
            echo "<div style='text-align:center; font-size:12px; color:white; background-color:grey;'>";
            echo "<br>The following errors occured <br><br>";
            echo $result;
            echo "</div>";
        }else
        {
            header("Location: profile.php");
            die;
        }
        $email = $_POST['email'];
        $pasword = $_POST['password'];
    }  
?>

<html>
    <head>
        <title>One4All | Log In</title>
    </head>
    <style>
        #head_bar{
            height: 100px;
            background-color: #91c0ab;
            color: azure;
            padding: 4px;
        }
        #signup_button{
            background-color: #C091A6;
            width: 70px;
            text-align: center;
            padding: 4px;
            border-radius: 4px;
            float: right;
        }
        #login_bar{
            background-color: #FCF5FB;
            width: 50%;
            height: 200px;
            margin: auto;
            margin-top: 50px;
            padding: 75;
            text-align: center;
            font-weight: bold;
        }
        #text{
            height: 40px;
            width: 300px;
            border-radius: 4px;
            border: solid 1px #ccc;
            padding: 4px;
            font-size: 14px;
        }
        #button{
            height: 40px;
            width: 300px;
            border-radius: 4px;
            font-weight: bold;
            border: none;
            background-color: #91c0ab;
            color: azure;
        }   
</style>
    <body style="font-family: tahoma; background-color: #F5FCF6;">
        
        <div id="head_bar">
            <div style="font-size: 40px;">One4All</div> 
            <div id="signup_button">
                <a href="signup.php" style="text-decoration: none; color:azure;">Sign Up</a>
            </div>
        </div>
        <div id="login_bar">
            Login to One4All <br><br>
            <form method="post">
                <input name="email" value="<?php echo $email?>" type="text" id="text" placeholder="Email"><br><br>
                <input name="password" value="<?php echo $password?>" type="password" id="text" placeholder="Password"><br><br>
                <input type="submit" id="button" value="Login">
            </form>
        </div>
    </body>
</html>