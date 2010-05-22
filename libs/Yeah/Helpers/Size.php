<?php

class Yeah_Helpers_Size
{
    public function size($size, $round = 0) {
        $sizes = array('B', 'kiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB');
        for ($i=0; $size > 1024 && isset($sizes[$i+1]); $i++) $size /= 1024;
        return round($size,$round).$sizes[$i];
    }
}
