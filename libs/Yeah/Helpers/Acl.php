<?php

class Yeah_Helpers_Acl
{
    public function acl ($module, $privilege) {
        return Yeah_Acl::hasPermission($module, $privilege);
    }
}
