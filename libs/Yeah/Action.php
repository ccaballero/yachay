<?php

abstract class Yeah_Action extends Zend_Controller_Action
{
    protected function _redirect($url, array $options = array()) {
        global $CONFIG;
        global $USER;

        if ($USER->role == 1) {
            parent::_redirect($this->view->url(array(), 'frontpage_visitor'));
        }

        parent::_redirect($url);
    }

    public function requirePermission($module, $privilege) {
        global $CONFIG;
        global $USER;
        $session = new Zend_Session_Namespace();
        if (!is_array($privilege)) {
            if (!$USER->hasPermission($module, $privilege)) {
                $session->messages->addMessage('Usted no tiene permisos suficientes');
                $this->_redirect($CONFIG->wwwroot);
            }
        } else {
            $flag = false;
            foreach ($privilege as $priv) {
                $flag |= $USER->hasPermission($module, $priv);
            }
            if (!$flag) {
                $session->messages->addMessage('Usted no tiene permisos suficientes');
                $this->_redirect($CONFIG->wwwroot);
            }
        }
    }

    public function requireMorePrivileges($user) {
        global $USER;
        $session = new Zend_Session_Namespace();
        if (!$USER->hasFewerPrivileges($user)) {
            $session->messages->addMessage('Usted no puede otorgar tantos privilegios');
            $this->_redirect($this->view->url(array('user' => $user->url), 'users_user_view'));
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
            $session->messages->addMessage('El recurso solicitado no existe');
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
            $session->messages->addMessage('El grupo solicitado no existe');
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
            $session->messages->addMessage('El equipo solicitado no existe');
            $this->_redirect($url);
        }
    }

    public function requireModerator($subject) {
        global $USER;
        $session = new Zend_session_Namespace();
        if (!$subject->amModerator()) {
            $session->messages->addMessage('Usted debe ser el moderador asignado en la materia');
            $this->_redirect($this->view->url(array('subject' => $subject->url), 'subjects_subject_view'));
        }
    }

    public function requireTeacher($group) {
        global $USER;
        $session = new Zend_session_Namespace();
        if (!$group->amTeacher()) {
            $subject = $group->getSubject();
            $session->messages->addMessage('Usted debe ser el docente asignado al grupo');
            $this->_redirect($this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view'));
        }
    }
    
    public function requireMemberTeam($team) {
        global $USER;
        $session = new Zend_session_Namespace();
        if (!$team->amMemberTeam()) {
            $group = $team->getGroup();
            $subject = $group->getSubject();
            $session->messages->addMessage('Usted debe ser un miembro asignado del equipo');
            $this->_redirect($this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view'));
        }
    }

    public function requireCommunityModerator($community) {
        global $USER;
        $session = new Zend_session_Namespace();
        if (!$community->amModerator()) {
            $session->messages->addMessage('Usted debe ser un moderador de esa comunidad');
            $this->_redirect($this->view->url(array('community' => $community->url), 'communities_community_view'));
        }
    }

    public function requireResourceAuthor($resource) {
        global $USER;
        $session = new Zend_session_Namespace();
        if (!$resource->amAuthor()) {
            $session->messages->addMessage('Usted debe ser el autor de este recurso');
            $this->_redirect($this->view->url(array(), 'frontpage_user'));
        }
    }

    public function requireContext($resource) {
        $session = new Zend_session_Namespace();
        $context = new Yeah_Helpers_Context();
        $spaces_valids = $context->context(NULL, 'plain');
        if (!in_array($resource->recipient, $spaces_valids)) {
            $session->messages->addMessage('Usted debe ser parte de ese espacio para realizar esa accion');
            $this->_redirect($this->view->url(array(), 'frontpage_user'));
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

        global $THEME;
        $this->view->doctype($THEME->doctype);

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
                $this->view->addScriptPath($CONFIG->dirroot . 'modules/' . $module->url . '/views/scripts/application');
            }
        }

        // register in log
        global $LOG;
        $info = "                                     Route: $route
";
        if ($PAGE != null) {
            $info .= "                                     Module:{$PAGE->module} - Controller:{$PAGE->controller} - Action:{$PAGE->action}";
        }
        $LOG->info('----------------------------------------------------------------------------------------
' . $info);

        // Regions settings
        global $TITLE;
        $TITLE->title = "Sistema de administraci&oacute;n de Cursos y Notas";

        global $ICON;
        $ICON->icon = $CONFIG->media_base . "favicon.ico";

        $this->view->config = $CONFIG;
        $this->view->theme = $THEME;
    }

    public function postDispatch() {
        global $CONFIG;
        global $PAGE;
        global $THEME;
        global $USER;

        if (isset($this->_ignorePostDispatch)) {
            return;
        }

        if (empty($PAGE)) {
            return;
        }

        $session = new Zend_Session_Namespace();

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

            $view->config = $CONFIG;
            $view->user = $USER;
            $view->page = $PAGE;

            $widget_page = $widgets_pages->getPosition($PAGE->ident, $widget->ident);
            $position = $widget_page->position;

            $script = "{$CONFIG->dirroot}modules/{$widget->module}/views/scripts/widgets/{$widget->script}.{$THEME->name}.php";
            if (file_exists($script)) {
                $to_render = "{$widget->script}.{$THEME->name}.php";
            } else {
                $to_render = "{$widget->script}.php";
            }
            $widget_content = $view->render($to_render);
            if (!empty($widget_content)) {
                $WIDGETS[$position] = array (
                    'title'   => $widget->title,
                    'content' => $widget_content,
                );
            }
        }

        // Register last login
        global $USER;
        $user = Yeah_Adapter::getModel('users')->findByIdent($USER->ident);
        if (!empty($user)) {
            $user->lastLogin();
            if ($user->needFillProfile()) {
                $session->messages->addMessage("Se recomienda que ingrese su nombre, apellido y correo electrónico. [<a href=\"{$CONFIG->wwwroot}profile/edit/\">Editar</a>]");
            }
        }

        global $TITLE, $ICON, $TOOLBAR, $SEARCH, $MENUBAR, $BREADCRUMB, $WIDGETS, $FOOTER;

        $this->view->title = $TITLE;
        $this->view->icon = $ICON;
        $this->view->toolbar = $TOOLBAR;
        $this->view->search = $SEARCH;
        $this->view->menubar = $MENUBAR;
        $this->view->breadcrumb = $BREADCRUMB;
        $this->view->widgets = $WIDGETS;
        $this->view->footer = $FOOTER;

        // rendering customized theme
        $script = $this->view->getScriptPath($PAGE->controller) . '/' . $PAGE->action . '.' . $THEME->name . '.php';
        if (file_exists($script)) {
            $this->render('index.' . $THEME->name);
        }
    }
}
