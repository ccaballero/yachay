<?php

class Groups_View_Helper_Teacher
{
    public function teacher($name, $value = 0, $subject) {
        global $USER;

        $model = Yeah_Adapter::getModel('users');
        $users = $model->selectByStatus('active');

        $teachers = $subject->findmodules_users_models_UsersViamodules_subjects_models_Subjects_Users($subject->select()->where('type = ?', 'teacher'));

        $options = array();
        $options[] = '<option value="' . $value . '">-------------------</option>';
        foreach ($teachers as $teacher) {
            if ($teacher->hasPermission('subjects', 'teach')) {
                $selected = '';
                if ($teacher->ident == $value) {
                    $selected = 'selected="selected" ';
                }
                $options[] = '<option ' . $selected . 'value="' . $teacher->ident . '">' . $teacher->label . '</option>';
            }
        }

        return '<select name="'. $name . '">' . implode('', $options) . '</select>';
    }
}
