<?php

class Califications extends Yachay_Db_Table
{
    protected $_name            = 'calification';
    protected $_dependentTables = array();
    protected $_referenceMap    = array(
        'User'                  => array(
            'columns'           => 'user',
            'refTableClass'     => 'Users',
            'refColumns'        => 'ident',
        ),
        'Group'                 => array(
            'columns'           => 'group',
            'refTableClass'     => 'Groups',
            'refColumns'        => 'ident',
        ),
        'Evaluation'            => array(
            'columns'           => 'evaluation',
            'refTableClass'     => 'Evaluations',
            'refColumns'        => 'ident',
        ),
        'Test'                  => array(
            'columns'           => 'evaluation_test',
            'refTableClass'     => 'Evaluation_Tests',
            'refColumns'        => 'ident',
        ),
    );

    public function getCalification($group, $user, $evaluation, $test) {
        if (empty($test->formula)) {
            $row = $this->fetchRow($this->select()
                                        ->where('`group` = ?', $group)
                                        ->where('`user` = ?', $user)
                                        ->where('`evaluation` = ?', $evaluation)
                                        ->where('`test` = ?', $test->ident));
            if (empty($row)) {
                return;
            } else {
                return $row->calification;
            }
        } else {
            $parser = new Evaluations_Parser($evaluation);
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
