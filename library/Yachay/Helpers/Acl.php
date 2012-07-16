<?php

class Yachay_Helpers_Acl
{
    public function acl($package, $label) {
        return Yachay_Acl::hasPermission($package, $label);
    }
}
