<?php

class Subjects_View_Helper_Moderator
{
    public function moderator($name, $value = 0) {
        global $USER;

        $model = Yeah_Adapter::getModel('users');
        $users = $model->selectByStatus('active');

        $options = array();
        $options[] = '<option value="' . $value . '">-------------------</option>';
        foreach ($users as $user) {
            if ($user->hasPermission('subjects', 'moderate')) {
                $selected = '';
                if ($user->ident == $value) {
                    $selected = 'selected="selected" ';
                }
                $options[] = '<option ' . $selected . 'value="' . $user->ident . '">' . $user->label . '</option>';
            }
        }

        return '<select name="'. $name . '">' . implode('', $options) . '</select>';
    }
}
