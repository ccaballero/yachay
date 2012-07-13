<?php

class Yachay_Helpers_Paginator
{
    public function paginator($objects, $route) {
        $view = new Zend_View();
        $view->addHelperPath(APPLICATION_PATH . '/library/Yachay/Helpers', 'Yachay_Helpers');
        $view->addScriptPath(APPLICATION_PATH . '/packages/paginator/views/scripts');

        $template = new Yachay_Helpers_Template;
        return $view->paginationControl($objects, 'Sliding', $template->template('paginator', 'pagination_control', ''), array('route' => $route));
    }
}
