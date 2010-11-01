<?php

class Yeah_Helpers_Paginator
{
    public function paginator($objects, $route) {
        global $CONFIG;

        $view = new Zend_View();
        $view->addHelperPath($CONFIG->dirroot . 'libs/Yeah/Helpers', 'Yeah_Helpers');
        $view->addScriptPath($CONFIG->dirroot . 'modules/paginator/views/scripts');

        $template = new Yeah_Helpers_Template;
        return $view->paginationControl($objects, 'Sliding', $template->template('paginator', 'pagination_control', ''), array('route' => $route));
    }
}
