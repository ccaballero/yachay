<?php

class Yeah_Helpers_Timestamp
{
    public function timestamp($timestamp, $format = "Y-m-d G:i") {
        if ($timestamp == 0) {
            return 'Solo ese dia';
        }
        return date($format, $timestamp);
    }
}
