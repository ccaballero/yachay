<?php

class Teams_View_Helper_Teams
{
    public function teams($name, $value, $group, $member) {
        $model_teams = new Teams();
        $teams = $model_teams->selectByStatus($group->ident, 'active');

        $options = array();
        $options[] = '<option value="' . $value . '">-------------------</option>';
        foreach ($teams as $team) {
            $selected = '';
            if ($team->ident == $value) {
                $selected = 'selected="selected" ';
            }
            $options[] = '<option ' . $selected . 'value="' . $team->ident . '">' . $team->label . '</option>';
        }

        return '<select name="'. $name . '[' . $member . ']">' . implode('', $options) . '</select>';
    }
}
