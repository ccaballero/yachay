<?php

abstract class Yachay_Action extends Zend_Controller_Action
{
    public function history($url_page = '') {
        $config = Zend_Registry::get('config');

        $session = new Zend_Session_Namespace('yachay');
        $session->lastPage = $session->currentPage;
        $session->currentPage = $config->resources->frontController->baseUrl . '/' . $url_page;
    }
    
    public function context($type, $value = null) {
        $session = new Zend_Session_Namespace('yachay');

        $session->context_type = $type;
        if ($type <> 'global') {
            $session->context_id = $value->ident;
            $session->context_label = $value->label;
        } else {
            $session->context_id = 0;
            $session->context_label = '';
        }
    }
    
    public function acl($module, $privilege) {
        return Yachay_Acl::hasPermission($module, $privilege);
    }

    public function requirePermission($module, $privilege) {
        global $USER;
        if (!is_array($privilege)) {
            if (!$USER->hasPermission($module, $privilege)) {
                $this->_helper->flashMessenger->addMessage('Usted no tiene permisos suficientes');
                $this->_redirect($this->view->url(array(), 'frontpage'));
            }
        } else {
            $flag = false;
            foreach ($privilege as $priv) {
                $flag |= $USER->hasPermission($module, $priv);
            }
            if (!$flag) {
                $this->_helper->flashMessenger->addMessage('Usted no tiene permisos suficientes');
                $this->_redirect($this->view->url(array(), 'frontpage'));
            }
        }
    }

    public function requireMorePrivileges($user) {
        global $USER;
        if (!$USER->hasFewerPrivileges($user)) {
            $this->_helper->flashMessenger->addMessage('Usted no puede otorgar tantos privilegios');
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
            $this->_helper->flashMessenger->addMessage('El recurso solicitado no existe');
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
            $this->_helper->flashMessenger->addMessage('El grupo solicitado no existe');
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
            $this->_helper->flashMessenger->addMessage('El equipo solicitado no existe');
            $this->_redirect($url);
        }
    }

    public function requireModerator($subject) {
        if (!$subject->amModerator()) {
            $this->_helper->flashMessenger->addMessage('Usted debe ser el moderador asignado en la materia');
            $this->_redirect($this->view->url(array('subject' => $subject->url), 'subjects_subject_view'));
        }
    }

    public function requireTeacher($group) {
        if (!$group->amTeacher()) {
            $subject = $group->getSubject();
            $this->_helper->flashMessenger->addMessage('Usted debe ser el docente asignado al grupo');
            $this->_redirect($this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view'));
        }
    }
    
    public function requireMemberTeam($team) {
        if (!$team->amMemberTeam()) {
            $group = $team->getGroup();
            $subject = $group->getSubject();
            $this->_helper->flashMessenger->addMessage('Usted debe ser un miembro asignado del equipo');
            $this->_redirect($this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view'));
        }
    }

    public function requireCommunityModerator($community) {
        if (!$community->amModerator()) {
            $this->_helper->flashMessenger->addMessage('Usted debe ser un moderador de esa comunidad');
            $this->_redirect($this->view->url(array('community' => $community->url), 'communities_community_view'));
        }
    }

    public function requireResourceAuthor($resource) {
        if (!$resource->amAuthor()) {
            $this->_helper->flashMessenger->addMessage('Usted debe ser el autor de este recurso');
            $this->_redirect($this->view->url(array(), 'frontpage_user'));
        }
    }

    public function requireContext($resource) {
        $context = new Yachay_Helpers_Context();
        $spaces_valids = $context->context(NULL, 'plain');
        if (!in_array($resource->recipient, $spaces_valids)) {
            $this->_helper->flashMessenger->addMessage('Usted debe ser parte de ese espacio para realizar esa acción');
            $this->_redirect($this->view->url(array(), 'frontpage_user'));
        }
    }

    public function init() {
        $this->_redirector = $this->_helper->getHelper('Redirector');
        $this->_redirector->setPrependBase(false);
        
        $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
        $this->_flashMessenger->setNamespace('yachay');
    }
    
    public function preDispatch() {
        $config = Zend_Registry::get('config');

        // settings for the page
        $route = $this->getFrontController()->getRouter()->getCurrentRouteName();
        if ($route == 'default') {
            return;
        }

        $model_pages = new Pages();
        global $PAGE;
        $PAGE = $model_pages->findByRoute($route);

        // add the views in path
        $this->view->addHelperPath(APPLICATION_PATH . '/../library/Yachay/Helpers', 'Yachay_Helpers');

        global $TEMPLATE;
        $this->view->doctype($TEMPLATE->doctype);

        if (empty($PAGE)) {
            return;
        }

        // set context by default
        if (!isset($this->_ignoreContextDefault)) {
            $this->context('global');
        }

        // Add the helpers of application
        $model_modules = new Modules();
        $modules = $model_modules->selectByType('application');
        foreach ($modules as $module) {
            //FIXME Considerar las posibles alternativas en tipos de modulos
            if ($PAGE->controller != 'manager') {
                $this->view->addScriptPath(APPLICATION_PATH . '/modules/' . $module->url . '/views/scripts/application');
            }
        }

        // Regions settings
        global $TITLE;
        $TITLE->title = $config->yachay->properties->title;

        global $ICON;
        $ICON->icon = $config->resources->frontController->baseUrl . '/media/favicon.ico';

        global $USER;

        $this->view->config = $config;

        $this->view->PAGE = $PAGE;
        $this->view->TEMPLATE = $TEMPLATE;
        $this->view->USER = $USER;

        // Register last login
        global $USER;
        $model_users = new Users();
        $user = $model_users->findByIdent($USER->ident);
        if (!empty($user)) {
            $user->lastLogin();
            if ($user->needFillProfile()) {
                $this->_helper->flashMessenger->addMessage('Se recomienda que ingrese su nombre, apellido y correo electrónico. <a href="' . $this->view->url(array(), 'profile_edit') . '">Editar</a>');
            }
        }
    }

    public function postDispatch() {
        global $PAGE;
        global $TEMPLATE;
        global $USER;

        if (isset($this->_ignorePostDispatch)) {
            return;
        }

        if (empty($PAGE)) {
            return;
        }

        $regions = $PAGE->findRegionsViaRegions_Pages();
        if (!empty($regions)) {
            foreach ($regions as $region) {
                $view = new Zend_View();
                $view->addHelperPath(APPLICATION_PATH . '/../library/Yachay/Helpers', 'Yachay_Helpers');
                $view->setScriptPath(APPLICATION_PATH . '/modules/' . $region->module . '/views/scripts/' . $region->region . '/');
                $view->render($region->script . '.php');
            }
        }

        // FIXME Control de privilegios
        $widgets = $PAGE->findWidgetsViaWidgets_Pages();

        global $WIDGETS;
        $model_widgets_pages = new Widgets_Pages();
        foreach ($widgets as $widget) {
            $view = new Zend_View();
            $view->addHelperPath(APPLICATION_PATH . '/../library/Yachay/Helpers', 'Yachay_Helpers');
            $view->setScriptPath(APPLICATION_PATH . '/modules/' . $widget->module . '/views/scripts/widgets/');
            
            $view->config = Zend_Registry::get('config');
            $view->PAGE = $PAGE;
            $view->TEMPLATE = $TEMPLATE;
            $view->USER = $USER;

            $widget_page = $model_widgets_pages->getPosition($PAGE->ident, $widget->ident);
            $position = $widget_page->position;

            $script = APPLICATION_PATH . "/modules/{$widget->module}/views/scripts/widgets/{$widget->script}-{$TEMPLATE->label}.php";
            if (file_exists($script)) {
                $to_render = "{$widget->script}-{$TEMPLATE->label}.php";
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

        global $TITLE, $ICON, $TOOLBAR, $SEARCH, $MENUBAR, $BREADCRUMB, $WIDGETS, $FOOTER;

        $this->view->TITLE = $TITLE;
        $this->view->ICON = $ICON;
        $this->view->TOOLBAR = $TOOLBAR;
        $this->view->SEARCH = $SEARCH;
        $this->view->MENUBAR = $MENUBAR;
        $this->view->BREADCRUMB = $BREADCRUMB;
        $this->view->WIDGETS = $WIDGETS;
        $this->view->FOOTER = $FOOTER;

        $this->view->messages = $this->_helper->getHelper('FlashMessenger')->getMessages();

        // rendering customized theme
        $script = $this->view->getScriptPath($PAGE->controller) . '/' . $PAGE->action . '-' . $TEMPLATE->label . '.php';
        if (file_exists($script)) {
            $this->render($PAGE->action . '-' . $TEMPLATE->label);
        }
    }
}
