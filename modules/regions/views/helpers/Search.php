<?php

class Regions_View_Helper_Search
{
    public function search($name, $value) {
        $model = Yeah_Adapter::getModel('regions');
        $regions = $model->selectByRegion('search');

        $empty = new modules_regions_models_Regions_Empty;

        $options = array();
        $options[] = '<option value="0">' . $empty->label . '</option>';

        foreach ($regions as $region) {
        	$selected = '';
        	if ($value->ident == $region->ident) {
        		$selected = 'selected="selected" ';
        	}
            $options[] = '<option ' . $selected . 'value="' . $region->ident . '">' . $region->label . '</option>';
        }

        return '<select name="'. $name . '">'. implode('', $options) . '</select>';
    }
}
