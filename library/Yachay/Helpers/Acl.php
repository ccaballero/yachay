<?php

class Yachay_Helpers_Acl
{
    public function acl ($module, $privilege) {
        return Yachay_Acl::hasPermission($module, $privilege);
    }
}
