<?php

class Yachay_Acl
{
    public static function hasPermission($package, $privileges) {
        $user = Zend_Registry::get('user');

        if (!is_array($privileges)) {
            if (!$user->hasPermission($package, $privileges)) {
                return false;
            }
        } else {
            $flag = false;
            foreach ($privileges as $privilege) {
                $flag |= $user->hasPermission($package, $privilege);
            }
            if (!$flag) {
                return false;
            }
        }
        return true;
    }
}
