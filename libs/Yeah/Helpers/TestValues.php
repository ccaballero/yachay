<?php

class Yeah_Helpers_TestValues
{
    public function testValues($name, $value, $test, $hasformula) {
        $test_values = $test->findEvaluations_Tests_Values();

        $options = array();
        $options[] = '<option value="">-------------------</option>';
        foreach ($test_values as $test_value) {
            $selected = '';
            if ($test_value->value === $value) {
                $selected = 'selected="selected" ';
            }
            $options[] = '<option ' . $selected . 'value="' . $test_value->value . '">' . $test_value->label . '</option>';
        }
        $enabled = '';
        if ($hasformula) {
            $enabled = 'disabled="disabled" ';
        }
        return '<select ' . $enabled . 'name="'. $name . '">' . implode('', $options) . '</select>';
    }
}
