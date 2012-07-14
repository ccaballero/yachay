<?php

class Yachay_Helpers_Paginator
{
    public function paginator($objects, $route) {
        $config = Zend_Registry::get('config');

        $view = new Zend_View();
        $view->addHelperPath(APPLICATION_PATH . '/library/Yachay/Helpers', 'Yachay_Helpers');
        $view->addScriptPath($config->resources->frontController->moduleDirectory . '/paginator/views/scripts');

        $template = new Yachay_Helpers_Template;
        return $view->paginationControl($objects, 'Sliding', $template->template('paginator', 'pagination_control', ''), array('route' => $route));
    }
}
