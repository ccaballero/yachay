<?php

class Groups_View_Helper_Assignement
{
    public function assignement($user, $subject, $group, $name) {
        $types = array(
            'auxiliar' => array('helper', 'Auxiliar'),
            'student'  => array('study', 'Estudiante'),
            'guest'    => array('participate', 'Invitado'),
        );

        $assignement1 = Yeah_Adapter::getModel('subjects', 'Subjects_Users');
        $assignement2 = Yeah_Adapter::getModel('groups', 'Groups_Users');

        $options = '';
        if ($user->hasPermission('subjects', 'helper')) {
            $assign1 = $assignement1->findBySubjectAndUser($subject->ident, $user->ident);
            if (!empty($assign1)) {
                $options .= '<option value="auxiliar">Auxiliar</option>';
            }
        }
        if ($user->hasPermission('subjects', 'study')) {
            $assign1 = $assignement1->findBySubjectAndUser($subject->ident, $user->ident);
            if (!empty($assign1)) {
                $assign2 = $assignement2->findByGroupAndUser($group->ident, $user->ident);
                if (empty($assign2)) {
                    $groups = $user->findmodules_groups_models_GroupsViamodules_groups_models_Groups_Users();
                    if (count($groups) == 0) {
                        $options .= '<option value="student">Estudiante</option>';
                    }
                }
            }
        }
        if ($user->hasPermission('subjects', 'participate')) {
            $assign1 = $assignement1->findBySubjectAndUser($subject->ident, $user->ident);
            if (!empty($assign1)) {
                $options .= '<option value="guest">Invitado</option>';
            }
        }

        $select = '<select name="' . $name . '[' . $user->ident . ']">' .
            '<option value="">--------------------</option>' . $options . '</select>';
        return $select;
    }
}
