<?php

abstract class Yeah_Action extends Zend_Controller_Action
{
    public function requirePermission($module, $privilege) {
        global $CONFIG;
        global $USER;
        if (!is_array($privilege)) {
            if (!$USER->hasPermission($module, $privilege)) {
                $this->_redirect($CONFIG->wwwroot);
            }
        } else {
            $flag = false;
            foreach ($privilege as $priv) {
                $flag |= $USER->hasPermission($module, $priv);
            }
            if (!$flag) {
                $this->_redirect($CONFIG->wwwroot);
            }
        }
    }

    public function requireExistence($element, $label, $route1, $route2) {
        if (empty($element)) {
            $session = new Zend_session_Namespace();
            if (isset($session->url)) {
                $url = $this->view->url(array($label => $session->url), $route1);
                unset($session->url);
            } else {
                $url = $this->view->url(array(), $route2);
            }
            $this->_redirect($url);
        }
    }

    public function requireExistenceGroup($group, $subject) {
        if (empty($group)) {
            $session = new Zend_session_Namespace();
            if (isset($session->url)) {
                $url = $this->view->url(array('subject' => $subject->url, 'group' => $session->url), 'groups_group_view');
                unset($session->url);
            } else {
                $url = $this->view->url(array('subject' => $subject->url), 'subjects_view');
            }
            $this->_redirect($url);
        }
    }

    public function requireExistenceTeam($team, $group, $subject) {
        if (empty($team)) {
            $session = new Zend_session_Namespace();
            if (isset($session->url)) {
                $url = $this->view->url(array('subject' => $subject->url, 'group' => $group->url, 'team' => $session->url), 'teams_team_view');
                unset($session->url);
            } else {
                $url = $this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'teams_view');
            }
            $this->_redirect($url);
        }
    }

    public function requireModerator($subject) {
        global $USER;
        if (!$subject->amModerator()) {
            $this->_redirect($this->view->url(array('subject' => $subject->url), 'subjects_subject_view'));
        }
    }

    public function requireTeacher($group) {
        global $USER;
        if (!$group->amTeacher()) {
            $subject = $group->getSubject();
            $this->_redirect($this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view'));
        }
    }
    
    public function requireMemberTeam($team) {
        global $USER;
        if (!$team->amMemberTeam()) {
            $group = $team->getGroup();
            $subject = $group->getSubject();
            $this->_redirect($this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view'));
        }
    }

    public function preDispatch() {
        global $CONFIG;
        $this->getRequest()->setBaseUrl($CONFIG->wwwroot);

        // settings for the page
        $route = $this->getFrontController()->getRouter()->getCurrentRouteName();

        if ($route == 'default') {
            return;
        }

        $pages = Yeah_Adapter::getModel('pages');
        global $PAGE;
        $PAGE = $pages->findByRoute($route);

        // add the views in path
        $this->view->addHelperPath($CONFIG->dirroot . 'libs/Yeah/Helpers', 'Yeah_Helpers');

        if (empty($PAGE)) {
            return;
        }

        // add the media directory for module
        $CONFIG->media_base = $CONFIG->wwwroot . 'media/' . $PAGE->module . '/';
        $this->view->media  = $CONFIG->media_base;

        // set context by default
        if (!isset($this->_ignoreContextDefault)) {
            context('global');
        }

        // Add the helpers of application
        $model_modules = Yeah_Adapter::getModel('modules');
        $modules = $model_modules->selectByType('application');
        foreach ($modules as $module) {
            //FIXME Considerar las posibles alternativas en tipos de modulos
            if ($PAGE->controller != 'manager') {
                $this->view->addScriptPath($CONFIG->dirroot . 'modules/' . $module->url . '/views/scripts/');
            }
        }

        // register in log
        global $LOG;
        $LOG->info('----------------------------------------------------------------------------------------');
        $LOG->info("REQUEST_URI: {$_SERVER['REQUEST_URI']}");
        $LOG->info("Route: $route");
        if ($PAGE != null) {
            $LOG->info("Module: {$PAGE->module}");
            $LOG->info("Controller: {$PAGE->controller}");
            $LOG->info("Action: {$PAGE->action}");
        }

        // Regions settings
        global $TITLE;
        $TITLE->title = "Sistema de administraci&oacute;n de Cursos y Notas";

        global $ICON;
        $ICON->icon = $CONFIG->media_base . "favicon.ico";

        // Log for params in request
        $request = $this->getRequest();
        $LOG->info(print_params($request->getParams()));
    }

    public function postDispatch() {
        global $CONFIG;
        global $PAGE;

        if (isset($this->_ignorePostDispatch)) {
            return;
        }
        
        if (empty($PAGE)) {
            return;
        }
        
        $regions = $PAGE->findManyToManyRowset('modules_regions_models_Regions', 'modules_regions_models_Regions_Pages');
        if (!empty($regions)) {
            foreach ($regions as $region) {
                $view = new Zend_View();
                $view->addHelperPath($CONFIG->dirroot . 'libs/Yeah/Helpers', 'Yeah_Helpers');
                $view->setScriptPath($CONFIG->dirroot . 'modules/' . $region->module . '/views/scripts/' . $region->region . '/');
                $view->render($region->script);
            }
        }

        // FIXME Control de privilegios
        $widgets = $PAGE->findManyToManyRowset('modules_widgets_models_Widgets', 'modules_widgets_models_Widgets_Pages');

        global $WIDGETS;
        $widgets_pages = Yeah_Adapter::getModel('widgets', 'Widgets_Pages');
        foreach ($widgets as $widget) {
            $view = new Zend_View();
            $view->addHelperPath($CONFIG->dirroot . 'libs/Yeah/Helpers', 'Yeah_Helpers');
            $view->setScriptPath($CONFIG->dirroot . 'modules/' . $widget->module . '/views/scripts/widgets/');

            $widget_page = $widgets_pages->getPosition($PAGE->ident, $widget->ident);
            $position = $widget_page->position;
            $WIDGETS[$position] = array (
                'title'   => $widget->title,
                'content' => $view->render($widget->script),
            );
        }

        // Register last login
        global $USER;
        $user = Yeah_Adapter::getModel('users')->findByIdent($USER->ident);
        if (!empty($user)) {
            $user->lastLogin();
        }

        // Log register
        global $LOG;

        $session = new Zend_Session_Namespace();
        $history = $session->history;
        $LOG->info($history->toString());

        global $BREADCRUMB;
        $LOG->info($BREADCRUMB->toString());

        /*
        // rendering customized layout
        $script = $this->view->getScriptPath($PAGE->controller) 
                . '/' . $PAGE->action . '-' . $PAGE->template_name . '.php';
        if (file_exists($script)) {
            $this->render('index.' . $PAGE->template_name);
        }*/
    }
}
