<?php

class Yeah_Helpers_Paginator
{
    public function paginator($objects, $route) {
        global $CONFIG;

        $view = new Zend_View();
        $view->addHelperPath($CONFIG->dirroot . 'libs/Yeah/Helpers', 'Yeah_Helpers');
        $view->addScriptPath($CONFIG->dirroot . 'modules/paginator/views/scripts');
        return $view->paginationControl($objects, 'Sliding', 'pagination_control.php', array('route' => $route));
    }
}
