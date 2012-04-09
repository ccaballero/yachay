<?php

class Yachay_Helpers_Wrapper
{
    public function wrapper($text, $limit = 30) {
        $explode = explode(' ', $text);
        $string  = '';

        $dots = '...';
        if (count($explode) <= $limit) {
            $dots = '';
        }
        for ($i = 0; $i < $limit; $i++) {
            if (!empty($explode[$i])) {
                $string .= $explode[$i] . " ";
            }
        }
        if ($dots) {
            $string = substr($string, 0, strlen($string));
        }
        return $string . $dots;
    }
}
