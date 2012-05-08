<?php

class Yachay_Controller_Require extends Zend_Controller_Action
{
    protected $config = null;
    protected $user = null;

    public function init() {
        $this->config = Zend_Registry::get('config');
        $this->user = Zend_Registry::get('user');

        $this->_redirector = $this->_helper->getHelper('Redirector');
        $this->_redirector->setPrependBase(false);

        $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
        $this->_flashMessenger->setNamespace('yachay');
    }

    public function requirePermission($module, $privilege) {
        if (!is_array($privilege)) {
            if (!$this->user->hasPermission($module, $privilege)) {
                $this->_helper->flashMessenger->addMessage('Usted no tiene permisos suficientes');
                $this->_redirect($this->view->url(array(), 'frontpage'));
            }
        } else {
            $flag = false;
            foreach ($privilege as $priv) {
                $flag |= $this->user->hasPermission($module, $priv);
            }
            if (!$flag) {
                $this->_helper->flashMessenger->addMessage('Usted no tiene permisos suficientes');
                $this->_redirect($this->view->url(array(), 'frontpage'));
            }
        }
    }

    public function requireMorePrivileges($user) {
        if (!$this->user->hasFewerPrivileges($user)) {
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
}
