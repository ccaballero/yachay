<?php

class Subjects_View_Helper_Assignement
{
    public function assignement($user, $name) {
        $types = array(
            'teacher'  => array('teach', 'Docente'),
            'auxiliar' => array('helper', 'Auxiliar'),
            'student'  => array('study', 'Estudiante'),
            'guest'    => array('participate', 'Invitado'),
        );

        $options = '';
        foreach ($types as $key => $label) {
            if ($user->hasPermission('subjects', $label[0])) {
                $options .= '<option value="' . $key . '">' . $label[1] . '</option>';
            } 
        }

        $select = '<select name="' . $name . '[' . $user->ident . ']">' .
            '<option value="">--------------------</option>' . $options . '</select>';
        return $select;
    }
}
