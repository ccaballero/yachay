<?php

class Pages_View_Helper_Menutype
{
    public function menutype($name, $value = '') {
    	$menutypes = array ('menubar' => 'Barra superior', 'footer' => 'Barra inferior');

    	$options = '';
    	foreach ($menutypes as $key => $menutype) {
    		$selected = '';
            if ($key == $value) {
                $selected = 'selected="selected" ';
            }
            $options .= '<option value="' . $key . '" ' . $selected . '>' . $menutype . '</option>'; 
    	}

    	$select = '<select name="' . $name . '" id="' . $name . '">' .
            '<option value="">--------------------</option>' . $options . '</select>';
    	return $select;
    }
}

