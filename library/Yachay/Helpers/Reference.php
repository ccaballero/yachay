<?php

class Yachay_Helpers_Reference
{
    public function reference($label, $url, $permissions) {
        $grant = true;
        foreach ($permissions as $permission) {
            $grant &= Yachay_Acl::hasPermission($permission[0], $permission[1]);
        }
        
        if ($grant) {
            return '<a href="' . $url . '">' . $label . '</a>';
        } else {
            return $label;
        }
    }
}
