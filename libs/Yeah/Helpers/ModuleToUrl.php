<?php

class Yeah_Helpers_ModuleToUrl {

    public function moduleToUrl($module = 'frontpage', $controller = 'index', $action = 'index') {
        global $CONFIG;
        
        $link = $CONFIG->wwwroot;
            if ($module != 'frontpage') {
                $link .= $module . '/';
                if ($controller != 'index') {
                    $link .= $controller . '/';
                    if ($action != 'index') {
                        $link .= $action . '/';
                    }
                }
            }
        
        return $link;
    }
}
