<?php

class Yachay_Acl
{
    public static function hasPermission($module, $privilege) {
        $user = Zend_Registry::get('user');

        if (!is_array($privilege)) {
            if (!$user->hasPermission($module, $privilege)) {
                return false;
            }
        } else {
            $flag = false;
            foreach ($privilege as $priv) {
                $flag |= $user->hasPermission($module, $priv);
            }
            if (!$flag) {
                return false;
            }
        }
        return true;
    }
}
