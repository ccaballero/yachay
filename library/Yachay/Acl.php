<?php

class Yachay_Acl
{
    public static function hasPermission($module, $privilege) {
        global $USER;
        if (!is_array($privilege)) {
            if (!$USER->hasPermission($module, $privilege)) {
                return false;
            }
        } else {
            $flag = false;
            foreach ($privilege as $priv) {
                $flag |= $USER->hasPermission($module, $priv);
            }
            if (!$flag) {
                return false;
            }
        }
        return true;
    }
}
