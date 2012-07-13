<?php

class Subjects_View_Helper_Assignement
{
    public function assignement($user, $name, $value = NULL) {
        $types = array(
            'teacher'  => array('teach', 'Docente'),
            'auxiliar' => array('helper', 'Auxiliar'),
            'student'  => array('study', 'Estudiante'),
            'guest'    => array('participate', 'Invitado'),
        );

        if (empty($user) && empty($name)) {
            if (!empty($value)) {
                return $types[$value][1];
            } else {
                return 'Ninguno';
            }
        }

        $options = '';
        foreach ($types as $key => $label) {
            if (isset($user)) {
                if ($user->hasPermission('subjects', $label[0])) {
                    $options .= '<option value="' . $key . '">' . $label[1] . '</option>';
                }
            } else {
                $options .= '<option value="' . $key . '">' . $label[1] . '</option>';
            }
        }

        if (isset($user)) {
            $temp = "[{$user->ident}]";
        } else {
            $temp = "";
        }

        $select = '<select name="' . $name . $temp . '">' .
            '<option value="">--------------------</option>' . $options . '</select>';
        return $select;
    }
}
