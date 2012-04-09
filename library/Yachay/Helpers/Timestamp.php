<?php

class Yachay_Helpers_Timestamp
{
    public function timestamp($timestamp, $format = "Y-m-d H:i") {
        if ($timestamp == 0) {
            return 'Nunca';
        }
        return date($format, $timestamp);
    }
}
