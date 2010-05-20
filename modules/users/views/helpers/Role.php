<?php

class Users_View_Helper_Role
{
    public function role($name, $value = 0) {
        global $USER;
        $model = Yeah_Adapter::getModel('roles');
        $roles = $model->selectByIncludes($USER->role);

        $options = array();
        $options[] = '<option value="' . $value . '">-------------------</option>';
        foreach ($roles as $role) {
            $selected = '';
            if ($role->ident == $value) {
                $selected = 'selected="selected" ';
            }
            $options[] = '<option ' . $selected . 'value="' . $role->ident . '">' . $role->label . '</option>';
        }

        return '<select name="'. $name . '">' . implode('', $options) . '</select>';
    }
}
