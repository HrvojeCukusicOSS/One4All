<?php

class Signup
{
    private $error = "";

    public function evaluate($data)
    {
        foreach($data as $key => $value)
        {
            if(empty($value))
            {
                $this->error .= $key . " is empty!<br>";
            }
            if($key == "email")
            {
                if(!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$value))
                {  
                    $this->error .= "Invalid email format!<br>";
                }
            }

            if($key == "first_name")
            {
                if(preg_match('/[0-9\s]/', $value))
                {  
                    $this->error .= "Invalid first name!<br>";
                }
            }

            if($key == "last_name")
            {
                if(preg_match('/[0-9\s]/', $value))
                {  
                    $this->error .= "Invalid last name!<br>";
                }
            }
        }
        if($this->error == "")
        {
            $this->crate_user($data);
        }else
        {
            return $this->error;
        }
    }

    public function crate_user($data)
    {
        $first_name = ucfirst($data["first_name"]);
        $last_name = ucfirst($data["last_name"]);
        $gender = $data["gender"];
        $email = $data["email"];
        $password = hash("sha1", $data["password"]);
        $url_address = strtolower($first_name) . "." . strtolower($last_name);
        $userid = $this->create_userid();
        $query = "insert into users 
        (userid, first_name, last_name, gender, email, password, url_address)
        values
        ('$userid', '$first_name', '$last_name', '$gender', '$email', '$password', '$url_address')";
        
        $DB = new Database();
        $DB->save($query);
    }

    private function create_userid()
    {
        $lenght = rand(4, 19);
        $num = "";
        for ($i=1; $i < $lenght; $i++)
        { 
            $new_rand = rand(0,9);
            $num = $num . $new_rand;
        }
        return $num;
    }
}