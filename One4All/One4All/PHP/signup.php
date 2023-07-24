<?php
    include("../Classes/autoload.php");
    

    $first_name = '';
    $last_name = '';
    $gender = '';
    $email = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $signup = new Signup();
        $result = $signup->evaluate($_POST);
        if($result != "")
        {
            echo "<div style='text-align:center; font-size:12px; color:white; background-color:grey;'>";
            echo "<br>The following errors occured <br><br>";
            echo $result;
            echo "</div>";
        }else
        {
            header("Location: login.php");
            die;
        }
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
    }  
?>

<html>
    <head>
        <title>One4All | Sign Up</title>
    </head>
    <style>
        #head_bar{
            height: 100px;
            background-color: #91c0ab;
            color: azure;
            padding: 4px;
        }
        #login_button{
            background-color: #C091A6;
            width: 70px;
            text-align: center;
            padding: 4px;
            border-radius: 4px;
            float: right;
        }
        #signup_bar{
            background-color: #FCF5FB;
            width: 50%;
            height: 400px;
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
            <div id="login_button">
            <a href="login.php" style="text-decoration: none; color:azure;">Login</a>
            </div>
        </div>
        <div id="signup_bar">
            Sign up to One4All <br><br>
            <form method="post" action="">
                <input value="<?php echo $first_name ?>" name="first_name" type="text" id="text" placeholder="First name"><br><br>
                <input value="<?php echo $last_name ?>" name="last_name" type="text" id="text" placeholder="Last name"><br><br>
                <span style="font-weight: normal;">Gender:</span><br>
                <select name="gender" id="text">
                    <option><?php echo $gender ?></option>
                    <option>Male</option>
                    <option>Female</option>
                    <option>Other</option>
                    <option>Prefer not to say</option>
                </select><br><br>
                <input value="<?php echo $email ?>" name="email" type="text" id="text" placeholder="Email"><br><br>
                <input name="password" type="password" id="text" placeholder="Password"><br><br>
                <input name="password2" type="password" id="text" placeholder="Retype Password"><br><br>
                <input type="submit" id="button" value="Sign up">
            </form>
        </div>
    </body>
</html>