<?php

class Yeah_Helpers_Evaluation
{
    public function evaluation($name, $value = 0) {
        global $USER;

        $model_evaluations = new Evaluations();
        $owner = $model_evaluations->selectByAuthor($USER->ident);
        $public = $model_evaluations->selectByAccess('public');

        $options = array();
        $options[] = '<option value="' . $value . '">-------------------</option>';
        foreach ($owner as $me) {
            if ($me->useful) {
                $selected = '';
                if ($me->ident == $value) {
                    $selected = 'selected="selected" ';
                }
                $options[] = '<option ' . $selected . 'value="' . $me->ident . '">' . $me->label . '</option>';
            }
        }
        foreach ($public as $item) {
            if ($item->useful && $item->author != $USER->ident) {
                $selected = '';
                if ($item->ident == $value) {
                    $selected = 'selected="selected" ';
                }
                $options[] = '<option ' . $selected . 'value="' . $item->ident . '">' . $item->label . '</option>';
            }
        }
        return '<select name="'. $name . '">' . implode('', $options) . '</select>';
    }
}
