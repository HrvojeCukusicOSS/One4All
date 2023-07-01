<?php

class Post
{
    private $error = "";
    public function create_post($userid, $data, $files)
    {

        if(!empty($data['post']) || !empty($files['file']['name']) || isset($data['is_profile']) || isset($data['is_cover']))
        {
            $myimage = "";
            $has_image = 0;
            $is_cover = 0;
            $is_profile = 0;

            if(isset($data['is_profile']) || isset($data['is_cover']))
            {
                $myimage = $files;
                $has_image = 1;
                if(isset($data['is_cover']))
                {
                    $is_cover = 1;
                }
                
                if(isset($data['is_profile']) )
                {
                    $is_profile = 1;
                }
                
            }else
            {
                if(!empty($files['file']['name']))
                {
                    $folder = "../Uploads/" . $userid . "/";

                    if(!file_exists($folder))
                    {
                        mkdir($folder, 0777, true);
                        file_put_contents($folder . "index.php", "access denied");
                    }
                    $image_class = new Image();
                    $myimage = $folder . $image_class->generate_filename(15) . ".jpg";
                    move_uploaded_file($_FILES['file']['tmp_name'], $myimage);

                    $image_class->resize_image($myimage, $myimage, 1500, 1500);

                    $has_image = 1;
                }
            }
            $post = "";
            if(isset($data['post']))
            {
                $post = addslashes($data['post']);
            }
            $postid= $this->create_postid();

            $query = "insert into posts (userid, postid, content, image, has_image, is_profile, is_cover) values ('$userid', '$postid', '$post', '$myimage', '$has_image', '$is_profile', '$is_cover')";
            $DB= new Database();
            $DB->save($query);
        }else
        {
            $this->error = "Please type in something to post!<br>";
        }
        return $this->error;
    }

    private function create_postid()
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

    public function get_posts($userid){
        $query = "select * from posts where userid = '$userid' order by id desc limit 10";
        $DB= new Database();
        $result = $DB->read($query);

        if($result)
        {
            return $result;
        }else
        {
            return false;
        }
    }

    public function get_single_posts($postid){
        if(!is_numeric($postid))
        {
            return false;
        }
        $query = "select * from posts where postid = '$postid' limit 1";
        $DB= new Database();
        $result = $DB->read($query);

        if($result)
        {
            return $result[0];
        }else
        {
            return false;
        }
    }

    public function delete_post($postid)
    {
        
        if(!is_numeric($postid))
        {
            return false;
        }
        $query = "delete from posts where postid = '$postid' limit 1";
        $DB= new Database();
        $DB->save($query);
    }

    public function i_own_post($postid, $userid)
    {
        if(!is_numeric($postid))
        {
            return false;
        }

        $query = "select * from posts where postid = '$postid' limit 1";
        $DB= new Database();
        $result = $DB->read($query);
        if(is_array($result))
        {
            if($result[0]['userid'] == $userid)
            {
                return true;
            }
        }
        return false;
    }

    public function like_post($id, $type, $userid)
    {
        $DB= new Database();
        if($type == "post")
        {
            $sql = "update posts set likes = likes + 1 where postid = '$id' limit 1";
            $DB->save($sql);

            $sql = "select likes from likes where type='post' && contentid = '$id' limit 1";
            $result = $DB->read($sql);
            
            if(is_array($result))
            {
                $likes = json_decode($result[0]['likes'], true);

                foreach($likes as $like)
                {
                    $user_ids[] = $like["userid"];
                }
            
                
                if(!in_array($userid, $user_ids))
                {
                    $arr["userid"] = $userid;
                    $arr["date"] = date("Y-m-d H:i:s");
                        
                    $likes[] = $arr;
                    $likes_string = json_encode($likes);
                    $sql = "update likes set likes = '$likes_string' where type='post' && contentid = '$id' limit 1";
                    $DB->save($sql);
                }
            }else
            {
                $arr["userid"] = $userid;
                $arr["date"] = date("Y-m-d H:i:s");
                
                $arr2[] = $arr;

                $likes = json_encode($arr2);
                $sql = "insert into likes (type, contentid, likes) values ('$type', '$id', '$likes')";
                $DB->save($sql);
            }
        }
        
    }
}