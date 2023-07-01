<?php

class Image
{
    public function generate_filename($lenght)
    {
        $array = array(0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        $text = "";

        for ($x=0; $x < $lenght; $x++)
        { 
            $random = rand(0,61);
            $text .= $array[$random];
        }
        return $text;
    }

    public function crop_image($original_file_name, $cropped_file_name, $max_width, $max_height)
    {
        if(file_exists($original_file_name))
        {
            $original_image = imagecreatefromjpeg($original_file_name);
            $original_width = imagesx($original_image);
            $original_height = imagesy($original_image);
            if($original_height > $original_width)
            {
                 $ratio = $max_width/$original_width;
                 $new_width = $max_width;
                 $new_height = $original_height * $ratio;
            }else
            {
                $ratio = $max_height/$original_height;
                 $new_height = $max_height;
                 $new_width = $original_width * $ratio;
            }
        }

        if($max_height != $new_width)
        {
            if($max_height > $max_width)
            {
                if($max_height > $new_height)
                {
                    $adjust = ($max_height/$new_height);
                }else
                {
                    $adjust = ($new_height/$max_height);
                }

                $new_width = $new_width * $adjust;
                $new_height = $new_height * $adjust;
            }else
            {
                if($max_width > $new_width)
                {
                    $adjust = ($max_width/$new_width);
                }else
                {
                    $adjust = ($new_width/$max_width);
                }

                $new_height = $new_height * $adjust;
                $new_width = $new_width * $adjust;
            }
        }

        $new_image = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($new_image, $original_image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);
        imagedestroy($original_image);
        
        if($max_height != $new_width)
        {
            if($max_width > $max_height)
            {
                $diff = ($new_height - $max_width);
                if($diff < 0)
                {
                    $diff = $diff * -1;
                }
                
                $y= round($diff / 2);
                $x=0;
            }else
            {
                $diff = ($new_width - $max_height);
                if($diff < 0)
                {
                    $diff = $diff * -1;
                }
                
                $x = round($diff / 2);
                $y = 0;
            }
        }else
        {
            if($new_height > $new_width)
            {
                $diff = ($new_height - $new_width);
                $y= round($diff / 2);
                $x=0;
            }else
            {
                $diff = ($new_width - $new_height);
                $x = round($diff / 2);
                $y = 0;
            }
        }

        $new_cropped_image = imagecreatetruecolor($max_width, $max_height);
        imagecopyresampled($new_cropped_image, $new_image, 0, 0, $x, $y, $max_width, $max_height, $max_width, $max_height);
        imagedestroy($new_image);
        imagejpeg($new_cropped_image, $cropped_file_name, 90);
        imagedestroy($new_cropped_image);
    }

    public function resize_image($original_file_name, $resised_file_name, $max_width, $max_height)
    {
        if(file_exists($original_file_name))
        {
            $original_image = imagecreatefromjpeg($original_file_name);
            $original_width = imagesx($original_image);
            $original_height = imagesy($original_image);
            if($original_height > $original_width)
            {
                 $ratio = $max_width/$original_width;
                 $new_width = $max_width;
                 $new_height = $original_height * $ratio;
            }else
            {
                $ratio = $max_height/$original_height;
                 $new_height = $max_height;
                 $new_width = $original_width * $ratio;
            }
        }

        if($max_height != $new_width)
        {
            if($max_height > $max_width)
            {
                if($max_height > $new_height)
                {
                    $adjust = ($max_height/$new_height);
                }else
                {
                    $adjust = ($new_height/$max_height);
                }

                $new_width = $new_width * $adjust;
                $new_height = $new_height * $adjust;
            }else
            {
                if($max_width > $new_width)
                {
                    $adjust = ($max_width/$new_width);
                }else
                {
                    $adjust = ($new_width/$max_width);
                }

                $new_height = $new_height * $adjust;
                $new_width = $new_width * $adjust;
            }
        }

        $new_image = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($new_image, $original_image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);
        imagejpeg($new_image, $resised_file_name, 90);
        imagedestroy($new_image);
    }

    public function get_thumb_cover($filename)
    {
        $thumbnail = $filename . "_cover_thumb.jpg";

        if(file_exists($thumbnail))
        {
            return $thumbnail;
        }

        $this->crop_image($filename, $thumbnail, 1400, 500);
        if(file_exists($thumbnail))
        {
            return $thumbnail;
        }else
        {
            return $filename;
        }
    }

    public function get_thumb_profile($filename)
    {
        $thumbnail = $filename . "_profile_thumb.jpg";

        if(file_exists($thumbnail))
        {
            return $thumbnail;
        }

        $this->crop_image($filename, $thumbnail, 800, 800);
        if(file_exists($thumbnail))
        {
            return $thumbnail;
        }else
        {
            return $filename;
        }
    }
    
    public function get_thumb_post($filename)
    {
        $thumbnail = $filename . "_post_thumb.jpg";

        if(file_exists($thumbnail))
        {
            return $thumbnail;
        }

        $this->crop_image($filename, $thumbnail, 600, 600);
        if(file_exists($thumbnail))
        {
            return $thumbnail;
        }else
        {
            return $filename;
        }
    }
}