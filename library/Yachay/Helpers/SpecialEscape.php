<?php

class Yachay_Helpers_SpecialEscape
{
    public function specialEscape($message) {
        $return = '';

        // URL detection
        $message = preg_replace('/https?:\/\/[^\s<]+/i', '<a target="_BLANK" href="\0">\0</a>', $message);

        // Indent respect!
        $lines = explode("\n", $message);
        foreach ($lines as $line) {
            $length = strlen($line);
            $index = 0;
            while ($index < $length && $line{$index} == ' ') {
                $index++;
            }
            $return .= str_repeat('&nbsp;', $index) . trim($line) . '<br />';
        }

        return $return;
    }
}
