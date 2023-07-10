<?php
function pagination_link()
{
    $arr['next_page'] = "";
    $arr['prev_page'] = "";
    $found = false;
    $page_number = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $page_number = ($page_number < 1) ? 1 : $page_number;
    $url = "http://". $_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'];
    $url .= "?";
    $next_page_link=$url;
    $prev_page_link=$url;
    $num=0;
    foreach ($_GET as $key => $value) {
        $num++;
        if($num == 1)
        {
            if($key=="page")
            {
                $next_page_link .= $key . "=" . $page_number + 1;
                $prev_page_link .= $key . "=" . $page_number - 1;
                $found = true;
            }else
            {
                $next_page_link .= $key . "=" . $value;
                $prev_page_link .= $key . "=" . $value;
            }
            
        }else
        {
            if($key=="page")
            {
                $next_page_link .= "&" . $key . "=" . $page_number + 1;
                $prev_page_link .= "&" . $key . "=" . $page_number - 1;
                $found = true;
            }else
            {
                $next_page_link .= "&" . $key . "=" . $value;
                $prev_page_link .= "&" . $key . "=" . $value;
            }
        }
    }

    $arr['next_page'] = $next_page_link;
    $arr['prev_page'] = $prev_page_link;

    if(!$found)
    {
        $arr['next_page'] = $next_page_link . "&page=2";
        $arr['prev_page'] = $prev_page_link . "&page=1";
    }
    
    return $arr;
}

function i_own_content($row)
{
    
    $myid = $_SESSION['one4all_userid'];
    if(isset($row['gender']) && $myid == $row['userid'])
    {
        return true;
    }

    if(isset($row['postid']))
    {
        if($myid == $row['userid'])
        {
            return true;
        }else
        {
            $Post = new Post();
            $one_post = $Post->get_single_posts($row['parent']);

            if($myid == $one_post['userid'])
            {
                return true;
            }
        }
    }

    return false;
}

function add_notification($userid, $activity, $row)
{
    $userid = esc($userid);
    $activity = addslashes($activity);
    $content_owner = $row['userid'];
    $date = date("Y-m-d H:i:s");
    $contentid = 0;
    $content_type = ""; 
    if(isset($row['postid']))
    {
        $contentid = $row['postid'];
        $content_type = "post";
        if($row->parent > 0)
        {
            $content_type = "comment";
        }  
    }
    if(isset($row['gender']))
    {
        $content_type = "profile";        
    }
    $query = "insert into notifications (userid, activity, content_owner, date, contentid, content_type) values ('$userid', '$activity', '$content_owner', '$date', '$contentid', '$content_type')";
    $DB = new Database();
    $DB->save($query);
}

function content_i_follow($userid, $row)
{
    $userid = esc($userid);
    $date = date("Y-m-d H:i:s");
    $contentid = 0;
    $content_type = ""; 
    if(isset($row->postid))
    {
        $contentid = $row->postid;
        $content_type = "post";
        if($row->parent > 0)
        {
            $content_type = "comment";
        }  
    }
    if(isset($row->gender))
    {
        $content_type = "profile";
        $contentid = $row->userid;
    }
    $query = "insert into content_i_follow (userid, date, contentid, content_type) values ('$userid', '$date', '$contentid', '$content_type')";
    $DB = new Database();
    $DB->save($query);
}

function esc($value)
{
    return addslashes($value);
}