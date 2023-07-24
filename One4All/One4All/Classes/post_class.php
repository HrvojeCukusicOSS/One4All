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
            $postid = $this->create_postid();
            $parent = 0;
            $DB= new Database();
            if(isset($data['parent']) && is_numeric($data['parent']))
            {
                $parent = $data['parent'];
                $sql = "update posts set comments = comments + 1 where postid = '$parent' limit 1";
                $DB->save($sql);
            }

            $query = "insert into posts (userid, postid, content, image, has_image, is_profile, is_cover, parent) values ('$userid', '$postid', '$post', '$myimage', '$has_image', '$is_profile', '$is_cover', '$parent')";
            
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

    public function get_posts_pagination($userid, $page_number){
        $page_number = ($page_number < 1) ? 1 : $page_number;              
        $limit = 10;
        $offset = ($page_number - 1) * $limit;
        $query = "select * from posts where parent = 0 and userid = '$userid' order by id desc limit $limit offset $offset";
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

    public function get_comments($postid, $page_number){
        $page_number = ($page_number < 1) ? 1 : $page_number;              
        $limit = 10;
        $offset = ($page_number - 1) * $limit;
        $query = "select * from posts where parent = '$postid' order by id asc limit $limit offset $offset";
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

        $Post = new Post();
        $one_post = $Post->get_single_posts($postid);

        $DB= new Database();
        $sql = "select parent from posts where postid = '$postid' limit 1";
        $result = $DB->read($sql);

        if(is_array($result))
        {
            if($result[0]['parent'] > 0)
            {
                $parent = $result[0]['parent'];
                $sql = "update posts set comments = comments - 1 where postid = '$parent' limit 1";
                $DB->save($sql);
            }
        }

        $query = "delete from posts where postid = '$postid' limit 1";
        $DB->save($query);

        if($one_post['image'] !== "" && file_exists($one_post['image']))
        {
            unlink($one_post['image']."_post_thumb.jpg");
            unlink($one_post['image']);
        }
        if($one_post['image'] !== "" && file_exists($one_post['image']."_cover_thumb.jpg"))
        {
            unlink($one_post['image']."_post_thumb.jpg");
            unlink($one_post['image']."_cover_thumb.jpg");
            unlink($one_post['image']);
        }
        if($one_post['image'] !== "" && file_exists($one_post['image']."_profile_thumb.jpg"))
        {
            unlink($one_post['image']."_post_thumb.jpg");
            unlink($one_post['image']."_profile_thumb.jpg");
            unlink($one_post['image']);
        }

        $query = "delete from posts where parent = '$postid'";
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

        $sql = "select likes from likes where type='$type' && contentid = '$id' limit 1";
        $result = $DB->read($sql);
        
        if(is_array($result))
        {
            
            $likes = json_decode($result[0]['likes'], true);

            $user_ids[] = array();
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
                $sql = "update likes set likes = '$likes_string' where type='$type' && contentid = '$id' limit 1";
                $DB->save($sql);
                $sql = "update {$type}s set likes = likes + 1 where {$type}id = '$id' limit 1";
                $DB->save($sql);
                $single_post = $this->get_single_posts($id);
                add_notification($_SESSION['one4all_userid'],"like", $single_post);
            }else
            {
                $key = array_search($userid, $user_ids);
                $key = $key-1;
                unset($likes[$key]);
                $likes_string = json_encode($likes);
                $sql = "update likes set likes = '$likes_string' where type='$type' && contentid = '$id' limit 1";
                $DB->save($sql);
                $sql = "update {$type}s set likes = likes - 1 where {$type}id = '$id' limit 1";
                $DB->save($sql);
                $sql = "select likes from posts where postid = '$id' limit 1";
                $result = $DB->read($sql);
                if(is_array($result))
                {
                    if($result[0]['likes'] == 0)
                    {
                        $sql = "delete from likes where contentid = '$id' limit 1";
                        $DB->save($sql);
                    }
                }
            }
        }else
        {
            $arr["userid"] = $userid;
            $arr["date"] = date("Y-m-d H:i:s");
                    
            $arr2[] = $arr;

            $likes = json_encode($arr2);
            $sql = "insert into likes (type, contentid, likes) values ('$type', '$id', '$likes')";
            $DB->save($sql);
            $sql = "update {$type}s set likes = likes + 1 where {$type}id = '$id' limit 1";
            $DB->save($sql);
            $single_post = $this->get_single_posts($id);
            add_notification($_SESSION['one4all_userid'],"like", $single_post);
        }
    }

    public function get_likes($id, $type)
    {
        $DB= new Database();
        if(is_numeric($id))
        {
            $sql = "select likes from likes where type='$type' && contentid = '$id' limit 1";
            $result = $DB->read($sql);
            
            if(is_array($result))
            {
                $likes = json_decode($result[0]['likes'], true);
                return $likes;
            }
        }
        return false;
    }

    public function edit_post($userid, $data, $files)
    {

        if(!empty($data['post']) || !empty($files['file']['name']))
        {
            $myimage = "";
            $has_image = 0;
        
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
            
            $post = "";
            if(isset($data['post']))
            {
                $post = addslashes($data['post']);
            }
            $postid= addslashes($data['postid']);

            if($has_image)
            {
                $query = "update posts set content = '$post' , image = '$myimage' where postid = '$postid' limit 1";
            }else
            {$query = "update posts set content = '$post' where postid = '$postid' limit 1";
                
            }
            
            
            $DB= new Database();
            $DB->save($query);
        }else
        {
            $this->error = "Please type in something to post!<br>";
        }
        return $this->error;
    }
}