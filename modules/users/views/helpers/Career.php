<?php

class Users_View_Helper_Career
{
    public function career($id, $name, $value = 0) {
        $model_careers = new Careers();
        $careers = $model_careers->selectAll();

        if (empty($id)) {
            $id = $name;
        }

        $options = '';
        foreach ($careers as $career) {
            $selected = '';
            if ($career->ident == $value) {
                $selected = 'selected="selected" ';
            }
            $options .= '<option ' . $selected . ' value="' . $career->ident . '">' . $career->label . '</option>';
        }

        $select = '<select id="' . $id . '" name="' . $name . '">' .
            '<option value="0">--------------------</option>' . $options . '</select>';
        return $select;
    }
}
