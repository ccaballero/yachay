<?php

class Widgets_View_Helper_Widget
{
    public function widget($name, $value) {
        $model = Yeah_Adapter::getModel('widgets');
        $widgets = $model->selectAll();

        $empty = new modules_widgets_models_Widgets_Empty;

        $options = array();
        $options[] = '<option value="0">' . $empty->label . '</option>';

        foreach ($widgets as $widget) {
        	$selected = '';
        	if ($value->ident == $widget->ident) {
        		$selected = 'selected="selected" ';
        	}
            $options[] = '<option ' . $selected . 'value="' . $widget->ident . '">' . $widget->label . '</option>';
        }

        return '<select name="'. $name . '">'. implode('', $options) . '</select>';
    }
}
