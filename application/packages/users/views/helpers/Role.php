<?php

class Users_View_Helper_Role
{
    public function role($id, $name, $value = 0) {
        $user = Zend_Registry::get('user');

        $model_roles = new Roles();
        $roles = $model_roles->selectByIncludes($user->role);

        if (empty($id)) {
            $id = $name;
        }

        $options = array();
        $options[] = '<option value="' . $value . '">-------------------</option>';
        foreach ($roles as $role) {
            $selected = '';
            if ($role->ident == $value) {
                $selected = 'selected="selected" ';
            }
            $options[] = '<option ' . $selected . 'value="' . $role->ident . '">' . $role->label . '</option>';
        }

        return '<select id="' . $id . '" name="'. $name . '">' . implode('', $options) . '</select>';
    }
}
