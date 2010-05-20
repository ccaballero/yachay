<?php

class modules_califications_models_Califications extends Zend_Db_Table_Abstract
{
    protected $_name            = 'calification';
    // FIXME agregar las reference de zend ($reference, $table, $row y demases)

    public function getCalification($group, $user, $evaluation, $test) {
        if (empty($test->formula)) {
            $row = $this->fetchRow($this->select()
                                        ->where('`group` = ?', $group)
                                        ->where('`user` = ?', $user)
                                        ->where('`evaluation` = ?', $evaluation)
                                        ->where('`test` = ?', $test->ident));
            if (empty($row)) {
                return $test->defaultnote;
            } else {
                return $row->calification;
            }
        } else {
            $parser = new modules_evaluations_models_Parser($evaluation);
            $parser->setGroup($group);
            $parser->setUser($user);
            $value = $parser->parse($test->formula);
            $numeric = $value->extract();
            // prune action
            if ($numeric > $test->maximumnote) {
                $numeric = $test->maximumnote;
            } else if ($numeric < $test->minimumnote) {
                $numeric = $test->minimumnote;
            }
            return $numeric;
        }
    }

    public function findCalification($group, $user, $evaluation, $test) {
        return $this->fetchRow($this->select()
                                    ->where('`group` = ?', $group)
                                    ->where('`user` = ?', $user)
                                    ->where('`evaluation` = ?', $evaluation)
                                    ->where('`test` = ?', $test));
    }
}
