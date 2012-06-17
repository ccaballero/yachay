<?php

class Yachay_Helpers_Acl
{
    public function acl($package, $privilege) {
        return Yachay_Acl::hasPermission($package, $privilege);
    }
}
