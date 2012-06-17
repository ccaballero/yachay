<?php

class Groups_View_Helper_Assignement
{
    public function assignement($user, $subject, $group, $name, $value = NULL) {
        $types = array(
            'auxiliar' => array('helper', 'Auxiliar'),
            'student'  => array('study', 'Estudiante'),
            'guest'    => array('participate', 'Invitado'),
        );

        if (empty($user) && empty($subject) && empty($group)) {
            if (empty($name)) {
                if (!empty($value)) {
                    return $types[$value][1];
                } else {
                    return 'Ninguno';
                }
            } else {
                $options = '';
                $options .= '<option value="auxiliar">Auxiliar</option>';
                $options .= '<option value="student">Estudiante</option>';
                $options .= '<option value="guest">Invitado</option>';

                $select = '<select name="' . $name . '">' .
                    '<option value="">--------------------</option>' . $options . '</select>';
                return $select;
            }
        }

        $assignement1 = new Subjects_Users();
        $assignement2 = new Groups_Users();

        $options = '';
        if (isset($user)) {
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
                        $groups = $user->findGroupsViaGroups_Users();
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
        }

        $select = '<select name="' . $name . '[' . $user->ident . ']">' .
            '<option value="">--------------------</option>' . $options . '</select>';
        return $select;
    }
}
