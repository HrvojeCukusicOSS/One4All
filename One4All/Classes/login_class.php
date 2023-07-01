<?php

class Login
{
    private $error = "";

    public function evaluate($data)
    {
        $email = addslashes($data["email"]);
        $password = addslashes($data["password"]);
        
        $query = "select * from users where email = '$email' limit 1";
        
        $DB = new Database();
        $result = $DB->read($query);
        if($result)
        {
            $row = $result[0];
            if($this->hashed_text($password) == $row['password'])
            {
                $_SESSION['one4all_userid'] = $row['userid'];
            }else
            {
                $this->error .= "Worng email or password!<br>";
            }
        }else
        {
            $this->error .= "Worng email or password!<br>";
        }

        return $this->error;
    }

    public function check_login($user_id)
    {
        if(is_numeric($user_id))
        {
            $query = "select * from users where userid = '$user_id' limit 1";
            
            $DB = new Database();
            $result = $DB->read($query);

            if($result)
            {
                $user_data = $result[0];
                return $user_data;
            }else
            {
                header("Location: login.php");
                die;
            }
            
        }else
        {
            header("Location: login.php");
            die;
        }
            
    }

    private function hashed_text($text)
    {
        $text = hash("sha1", $text);
        return $text;
    }
}