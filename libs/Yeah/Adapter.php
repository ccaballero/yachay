<?php

class Yeah_Adapter
{
    /*public static function getModel($module, $element = '') {
        global $DB;
        if (empty($element)) {
            $element = $module;
        } 
        if (!empty($module) || !empty($element)) {
            $element = 'modules_' . strtolower($module) . '_models_' . ucfirst($element);
            $model = new $element(array('db' => $DB));
            return $model;
        }
    }*/

    public static function check($array = array()) {
        global $DB;
        $DATABASE = new Yeah_Settings_Database;

        foreach ($array as $element) {
            $chk = $DB->fetchOne(
                'SELECT column_name FROM information_schema.columns WHERE table_name = ? AND
                    table_schema = \'' . $DATABASE->database . '\'',
                array(
                    $element,
                )
            );
            if (empty($chk)) {
                return false;
            }
        }
        return true;
    }

    public static function install($sql) {
        global $CONFIG;
        mysql_import($CONFIG->dirroot . 'sql/' . $sql . '.sql');
    }
}
