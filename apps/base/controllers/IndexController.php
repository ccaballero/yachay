<?php

class IndexController extends Yachay_Controller_Action
{
    public function indexAction() {
        if ($this->user->role == 1) {
            $this->_redirect($this->view->url(array(), 'base_visitor'));
        } else {
            $this->_redirect($this->view->url(array(), 'base_user'));
        }
    }

    public function visitorAction() {
        if ($this->user->role == 1) {
            $this->history();
            $model_resources = new Resources();
            $model_resources_globales = new Resources_Globales();

            $resources_globales = $model_resources_globales->selectAll();

            $resources = array();
            foreach($resources_globales as $resource_global) {
                $resource = $model_resources->findByIdent($resource_global->resource);
                $resources[$resource->tsregister] = $resource;
            }

            ksort($resources);
            $resources = array_reverse($resources);

            // PAGINATOR
            $request = $this->getRequest();
            $page = $request->getParam('page', 1);
            $paginator = Zend_Paginator::factory($resources);
            $paginator->setItemCountPerPage(10);
            $paginator->setCurrentPageNumber($page);
            $paginator->setPageRange(10);

            $this->view->resources = $paginator;
            $this->view->route = array (
            	'key' => 'base_visitor',
                'params' => array (),
            );
        } else {
            $this->_redirect($this->view->url(array(), 'base_user'));
        }
    }

    public function userAction() {
        if ($this->user->role != 1) {
            $this->history();

            $model_resources = new Resources();
            $model_resources_globales = new Resources_Globales();
            $resources_globales = $model_resources_globales->selectAll();

            // Fetch all posts in system!!
            $context = new Yachay_Helpers_Context;
            $list_spaces = $context->context(NULL, 'matrix');

            // Filtering based on configuration
            $filtered_spaces = explode(',', $this->user->spaces);
            if (empty($filtered_spaces)) {
                $filtered_spaces = array();
            }

            $resources = array();

            // global
            if (!in_array('global', $filtered_spaces)) {
                foreach($resources_globales as $resource_global) {
                    $resource = $model_resources->findByIdent($resource_global->resource);
                    $resources[$resource->tsregister] = $resource;
                }
            }

            // areas
            if (count($list_spaces['areas']) <> 0) {
                $model_areas = new Areas();
                foreach ($list_spaces['areas'] as $area) {
                    if (!in_array($area, $filtered_spaces)) {
                        @list($element, $ident) = @split('-', $area);
                        $area = $model_areas->findByIdent($ident);
                        $_resources = $area->findResourcesViaAreas_Resources();
                        foreach ($_resources as $resource) {
                            $resources[$resource->tsregister] = $resource;
                        }
                    }
                }
            }

            // careers
            if (count($list_spaces['careers']) <> 0) {
                $model_careers = new Careers();
                foreach ($list_spaces['careers'] as $career) {
                    if (!in_array($career, $filtered_spaces)) {
                        @list($element, $ident) = @split('-', $career);
                        $career = $model_careers->findByIdent($ident);
                        $_resources = $career->findResourcesViaCareers_Resources();
                        foreach ($_resources as $resource) {
                            $resources[$resource->tsregister] = $resource;
                        }
                    }
                }
            }

            // subjects
            if (count($list_spaces['subjects']) <> 0) {
                $model_subjects = new Subjects();
                foreach ($list_spaces['subjects'] as $subject) {
                    if (!in_array($subject, $filtered_spaces)) {
                        @list($element, $ident) = @split('-', $subject);
                        $subject = $model_subjects->findByIdent($ident);
                        $_resources = $subject->findResourcesViaSubjects_Resources();
                        foreach ($_resources as $resource) {
                            $resources[$resource->tsregister] = $resource;
                        }
                    }
                }
            }

            // groups
            if (count($list_spaces['groups']) <> 0) {
                $model_groups = new Groups();
                foreach ($list_spaces['groups'] as $group) {
                    if (!in_array($group, $filtered_spaces)) {
                        @list($element, $ident) = @split('-', $group);
                        $group = $model_groups->findByIdent($ident);
                        $_resources = $group->findResourcesViaGroups_Resources();
                        foreach ($_resources as $resource) {
                            $resources[$resource->tsregister] = $resource;
                        }
                    }
                }
            }

            // teams
            if (count($list_spaces['teams']) <> 0) {
                $model_teams = new Teams();
                foreach ($list_spaces['teams'] as $team) {
                    if (!in_array($team, $filtered_spaces)) {
                        @list($element, $ident) = @split('-', $team);
                        $team = $model_teams->findByIdent($ident);
                        $_resources = $team->findResourcesViaTeams_Resources();
                        foreach ($_resources as $resource) {
                            $resources[$resource->tsregister] = $resource;
                        }
                    }
                }
            }

            // community
            if (count($list_spaces['communities']) <> 0) {
                $model_communities = new Communities();
                foreach ($list_spaces['communities'] as $community) {
                    if (!in_array($community, $filtered_spaces)) {
                        @list($element, $ident) = @split('-', $community);
                        $community = $model_communities->findByIdent($ident);
                        $_resources = $community->findResourcesViaCommunities_Resources();
                        foreach ($_resources as $resource) {
                            $resources[$resource->tsregister] = $resource;
                        }
                    }
                }
            }

            // user
            if (count($list_spaces['users']) <> 0) {
                $model_users = new Users();
                foreach ($list_spaces['users'] as $user) {
                    if (!in_array($user, $filtered_spaces)) {
                        @list($element, $ident) = @split('-', $user);
                        $user = $model_users->findByIdent($ident);
                        $_resources = $user->findResourcesViaUsers_Resources();
                        foreach ($_resources as $resource) {
                            $resources[$resource->tsregister] = $resource;
                        }
                    }
                }
            }

            ksort($resources);
            $resources = array_reverse($resources);

            // PAGINATOR     
            $request = $this->getRequest();
            $page = $request->getParam('page', 1);
            $paginator = Zend_Paginator::factory($resources);
            $paginator->setItemCountPerPage(10);
            $paginator->setCurrentPageNumber($page);
            $paginator->setPageRange(10);

            $this->view->resources = $paginator;
            $this->view->route = array (
            	'key' => 'base_user',
                'params' => array(),         
            );
        } else {
            $this->_redirect($this->view->url(array(), 'base_visitor'));
        }
    }

    public function spacesAction() {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $spaces = $request->getParam('spaces');

            $session = new Zend_Session_Namespace('yachay');

            $context = new Yachay_Helpers_Context;
            $list_spaces = $context->context(NULL, 'plain');

            foreach ($list_spaces as $key => $space) {
                if (in_array($space, $spaces)) {
                    unset($list_spaces[$key]);
                }
            }

            $this->user->spaces = implode(',', $list_spaces);
            $this->user->save();
            $session->user = $this->user;
        }

        $this->_redirect($request->getParam('return'));
    }

    public function confirmAction() {
        $session = new Zend_Session_Namespace('yachay');
        $confirm = $session->confirm;

        $this->view->message = $confirm['message'];
        $this->view->return = $confirm['return'];
    }
}
