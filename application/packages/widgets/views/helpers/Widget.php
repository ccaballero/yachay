<?php

class Widgets_View_Helper_Widget
{
    public function widget($name, $value) {
        $model_widgets = new Widgets();
        $widgets = $model_widgets->selectAll();

        $empty = new Widgets_Empty();

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
