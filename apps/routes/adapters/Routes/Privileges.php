<?php

class Db_Routes_Privileges extends Yachay_Db_Table
{
    protected $_name = 'route_privilege';

    public function findByRoute($route) {
        $list = $this->fetchAll($this->select()->where('route = ?', $route));
        return $list;
    }
}
