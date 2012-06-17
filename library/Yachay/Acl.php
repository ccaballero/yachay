<?php

class Yachay_Acl
{
    public static function hasPermission($package, $privilege) {
        $user = Zend_Registry::get('user');

        if (!is_array($privilege)) {
            if (!$user->hasPermission($package, $privilege)) {
                return false;
            }
        } else {
            $flag = false;
            foreach ($privilege as $priv) {
                $flag |= $user->hasPermission($package, $priv);
            }
            if (!$flag) {
                return false;
            }
        }
        return true;
    }
}
