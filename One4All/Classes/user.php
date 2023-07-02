<?php

class User
{
    public function get_data($user_id)
    {
        $query = "select * from users where userid = '$user_id' limit 1";
        $DB = new Database();
        $result = $DB->read($query);

        if($result)
        {
            $row = $result[0];
            return $row;
        }else
        {
            return false;
        }
    }

    public function get_user($user_id)
    {
        $query = "select * from users where userid = '$user_id' limit 1";
        $DB = new Database();
        $result = $DB->read($query);
        if($result)
        {
            return $result[0];
        }else
        {
            return false;
        }
    }

    public function get_friends($user_id)
    {
        $query = "select * from users where userid != '$user_id'";
        $DB = new Database();
        $result = $DB->read($query);
        if($result)
        {
            return $result;
        }else
        {
            return false;
        }
    }

    public function follow_user($id, $type, $myid)
    {
        $DB= new Database();

        $sql = "select following from likes where type='$type' && contentid = '$myid' limit 1";
        $result = $DB->read($sql);
        
        if(is_array($result))
        {
            
            $likes = json_decode($result[0]['following'], true);

            $user_ids[] = array();
            foreach($likes as $like)
            {
                $user_ids[] = $like["userid"];
            }
                
            if(!in_array($id, $user_ids))
            {
                $arr["userid"] = $id;
                $arr["date"] = date("Y-m-d H:i:s");

                $likes[] = $arr;

                $likes_string = json_encode($likes);
                $sql = "update likes set following = '$likes_string' where type='$type' && contentid = '$myid' limit 1";
                $DB->save($sql);
            }else
            {
                $key = array_search($id, $user_ids);
                unset($likes[$key]);
                $likes_string = json_encode($likes);
                $sql = "update likes set following = '$likes_string' where type='$type' && contentid = '$myid' limit 1";
                $DB->save($sql);
            }
        }else
        {
            $arr["userid"] = $id;
            $arr["date"] = date("Y-m-d H:i:s");
                    
            $arr2[] = $arr;

            $following = json_encode($arr2);
            $sql = "insert into likes (type, contentid, following) values ('$type', '$myid', '$following')";
            $DB->save($sql);
        }
    }

    public function get_following($id, $type)
    {
        $DB= new Database();
        if(is_numeric($id))
        {
            $sql = "select following from likes where type='$type' && contentid = '$id' limit 1";
            $result = $DB->read($sql);
            
            if(is_array($result))
            {
                $following = json_decode($result[0]['following'], true);
                return $following;
            }
        }
        return false;
    }
}