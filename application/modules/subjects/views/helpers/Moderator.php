<?php

class Subjects_View_Helper_Moderator
{
    public function moderator($id, $name, $value = 0) {
        $model_users = new Users();
        $users = $model_users->selectByStatus('active');

        if (empty($id)) {
            $id = $name;
        }

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

        return '<select id="' . $id . '" name="'. $name . '">' . implode('', $options) . '</select>';
    }
}
