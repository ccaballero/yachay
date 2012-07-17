<?php

class Db_Privileges extends Yachay_Db_Table
{
    protected $_name    = 'privilege';
    protected $_primary = 'ident';

    public function selectByEnabledPackages() {
        $result = $this->fetchAll($this
                  ->select()
                  ->setIntegrityCheck(false)
                  ->from($this, array('ident', 'label', 'package', 'privilege'))
                  ->joinLeft('package', 'package.label = privilege.package', array())
                  ->where('package.status = ?', 'active')
                  ->order('privilege.ident ASC'));

        $privileges = array();
        foreach ($result as $row) {
            $privilege = new Privileges_Privilege();
            $privilege->setIdent($row->ident)
                      ->setLabel($row->label)
                      ->setPackage($row->package)
                      ->setPrivilege($row->privilege);
            $privileges[] = $privilege;
        }

        return $privileges;
    }
}
