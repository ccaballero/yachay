<?php

class Yeah_Helpers_SpecialEscape
{
    public function specialEscape($message) {
        $return = '';

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
