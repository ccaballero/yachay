<?php

class Yachay_Helpers_Thumbnail
{
    public function thumbnail ($copy_from, $copy_to, $maxwidth, $maxheight) {
        $position = strpos($copy_from, '.');
        $extension = strtolower(substr($copy_from, ++$position));

        switch ($extension) {
            case 'jpeg':
            case 'jpg':
                $uploaded = imagecreatefromjpeg($copy_from);
                break;
            case 'png':
                $uploaded = imagecreatefrompng($copy_from);
                break;
            case 'gif':
                $uploaded = imagecreatefromgif($copy_from);
                break;
        }

        $width = imagesx($uploaded);
        $height = imagesy($uploaded);

        $newwidth = $maxwidth;
        $newheight = $maxheight;

        $ratio = $width / $height;
        if ($ratio == 1) {
            $newwidth = $maxwidth;
            $newheigth = $maxwidth;
        } else if ($ratio > 1) {
            $newwidth = $maxwidth;
            $newheight = $maxwidth / $ratio;
        } else if ($ratio < 1) {
            $newwidth = $maxheight * $ratio;
            $newheight = $maxheight;
        }

        $thumbnail = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresized($thumbnail, $uploaded, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        imagejpeg($thumbnail, $copy_to, 100);
    }
}
