<?php

class Yachay_Helpers_ModuleToUrl {

    public function moduleToUrl($module = 'frontpage', $controller = 'index', $action = 'index') {
        $config = Zend_Registry::get('config');
        $link = $config->resources->frontController->baseUrl;

        if ($module != 'frontpage') {
            $link .= "/$module";
            if ($controller != 'index') {
                $link .= "/$controller";
                if ($action != 'index') {
                    $link .= "/$action";
                }
            }
        }

        return $link;
    }
}
