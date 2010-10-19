<?php

class IndexController extends Yeah_Action
{
    public function indexAction() {
        global $CONFIG;
        global $USER;

        if ($USER->role == 1) {
            $this->_redirect($this->view->url(array(), 'frontpage_visitor'));
        } else {
            $this->_redirect($this->view->url(array(), 'frontpage_user'));
        }
    }

    public function visitorAction() {
        global $USER;

        if ($USER->role == 1) {
            history();
            $model_resources_globales = Yeah_Adapter::getModel('resources', 'Resources_Globales');
            $resources_globales = $model_resources_globales->selectAll();
            $model_resources = Yeah_Adapter::getModel('resources');

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
            	'key' => 'frontpage_visitor',
                'params' => array (),
            );
        } else {
            $this->_redirect($this->view->url(array(), 'frontpage_user'));
        }
    }

    public function userAction() {
        global $USER;

        if ($USER->role != 1) {
            history();

            $modules = Yeah_Adapter::getModel('modules');
            $icons = array();

            if ($modules->findByLabel('areas')->status == 'active') {
                if (Yeah_Acl::hasPermission('areas', array('new', 'delete'))) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'areas_manager'),
                        'alt' => 'Gestión de areas',
                        'icon' => 'areas.png',
                    );
                } else if (Yeah_Acl::hasPermission('areas', 'list')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'areas_list'),
                        'alt' => 'Lista de areas',
                        'icon' => 'areas.png',
                    );
                }
            }

            if ($modules->findByLabel('communities')->status == 'active') {
                if (Yeah_Acl::hasPermission('communities', 'list')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'communities_list'),
                        'alt' => 'Lista de comunidades',
                        'icon' => 'communities.png',
                    );
                }
            }

            if ($modules->findByLabel('groupsets')->status == 'active') {
                if (Yeah_Acl::hasPermission('subjects', 'teach')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'groupsets_manager'),
                        'alt' => 'Administrador de conjuntos',
                        'icon' => 'groupsets.png',
                    );
                }
            }

            if ($modules->findByLabel('friends')->status == 'active') {
                if (Yeah_Acl::hasPermission('friends', 'contact')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'friends_friends'),
                        'alt' => 'Lista de contactos',
                        'icon' => 'friends.png',
                    );
                }
            }

            if ($modules->findByLabel('gestions')->status == 'active') {
                if (Yeah_Acl::hasPermission('gestions', array('new', 'active', 'delete'))) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'gestions_manager'),
                        'alt' => 'Gestión de gestiones',
                        'icon' => 'gestions.png',
                    );
                } else if (Yeah_Acl::hasPermission('gestions', 'list')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'gestions_list'),
                        'alt' => 'Lista de gestiones',
                        'icon' => 'gestions.png',
                    );
                }
            }

            if ($modules->findByLabel('groups')->status == 'active') {
                if (Yeah_Acl::hasPermission('subjects', array('teach', 'helper', 'study', 'participate'))) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'groups_list'),
                        'alt' => 'Lista de grupos',
                        'icon' => 'groups.png',
                    );
                }
            }

            if ($modules->findByLabel('subjects')->status == 'active') {
                if (Yeah_Acl::hasPermission('subjects', array('new', 'lock', 'delete'))) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'subjects_manager'),
                        'alt' => 'Gestión de materias',
                        'icon' => 'subjects.png',
                    );
                } else if (Yeah_Acl::hasPermission('subjects', 'list')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'subjects_list'),
                        'alt' => 'Lista de materias',
                        'icon' => 'subjects.png',
                    );
                }
            }

            if ($modules->findByLabel('modules')->status == 'active') {
                if (Yeah_Acl::hasPermission('modules', array('new', 'lock'))) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'modules_manager'),
                        'alt' => 'Gestión de modulos',
                        'icon' => 'modules.png',
                    );
                } else if (Yeah_Acl::hasPermission('modules', 'list')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'modules_list'),
                        'alt' => 'Lista de modulos',
                        'icon' => 'modules.png',
                    );
                }
            }

            if ($modules->findByLabel('pages')->status == 'active') {
                if (Yeah_Acl::hasPermission('pages', 'manage')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'pages_manager'),
                        'alt' => 'Gestión de paginas',
                        'icon' => 'pages.png',
                    );
                } else if (Yeah_Acl::hasPermission('pages', 'list')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'pages_list'),
                        'alt' => 'Lista de paginas',
                        'icon' => 'pages.png',
                    );
                }
            }

            if ($modules->findByLabel('resources')->status == 'active') {
                if (Yeah_Acl::hasPermission('resources', 'new')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'resources_list'),
                        'alt' => 'Recursos publicados',
                        'icon' => 'resources.png',
                    );
                }
            }

            if ($modules->findByLabel('regions')->status == 'active') {
                if (Yeah_Acl::hasPermission('regions', 'manage')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'regions_manager'),
                        'alt' => 'Gestión de regiones',
                        'icon' => 'regions.png',
                    );
                } else if (Yeah_Acl::hasPermission('regions', 'list')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'regions_list'),
                        'alt' => 'Lista de regions',
                        'icon' => 'regions.png',
                    );
                }
            }

            if ($modules->findByLabel('roles')->status == 'active') {
                if (Yeah_Acl::hasPermission('roles', array('new', 'assign', 'delete'))) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'roles_manager'),
                        'alt' => 'Gestión de roles',
                        'icon' => 'roles.png',
                    );
                } else if (Yeah_Acl::hasPermission('roles', 'list')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'roles_list'),
                        'alt' => 'Lista de roles',
                        'icon' => 'roles.png',
                    );
                }
            }

            if ($modules->findByLabel('users')->status == 'active') {
                if (Yeah_Acl::hasPermission('users', array('new', 'import', 'export', 'lock', 'delete'))) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'users_manager'),
                        'alt' => 'Gestión de usuarios',
                        'icon' => 'users.png',
                    );
                } else if (Yeah_Acl::hasPermission('users', 'list')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'users_list'),
                        'alt' => 'Lista de usuarios',
                        'icon' => 'users.png',
                    );
                }
            }

            if ($modules->findByLabel('widgets')->status == 'active') {
                if (Yeah_Acl::hasPermission('widgets', 'manage')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'widgets_manager'),
                        'alt' => 'Gestión de widgets',
                        'icon' => 'widgets.png',
                    );
                } else if (Yeah_Acl::hasPermission('widgets', 'list')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'widgets_list'),
                        'alt' => 'Lista de widgets',
                        'icon' => 'widgets.png',
                    );
                }
            }

            $model_resources_globales = Yeah_Adapter::getModel('resources', 'Resources_Globales');
            $resources_globales = $model_resources_globales->selectAll();
            $model_resources = Yeah_Adapter::getModel('resources');

            // Fetch all posts in system!!
            $context = new Yeah_Helpers_Context;
            $list_spaces = $context->context(NULL, 'matrix');
            $resources = array();

            // global
            foreach($resources_globales as $resource_global) {
                $resource = $model_resources->findByIdent($resource_global->resource);
                $resources[$resource->tsregister] = $resource;
            }

            // areas
            if (count($list_spaces['areas']) <> 0) {
                $areas_model = Yeah_Adapter::getModel('areas');
                foreach ($list_spaces['areas'] as $area) {
                    @list($element, $ident) = @split('-', $area);
                    $area = $areas_model->findByIdent($ident);
                    $_resources = $area->findmodules_resources_models_ResourcesViamodules_areas_models_Areas_Resources();
                    foreach ($_resources as $resource) {
                        $resources[$resource->tsregister] = $resource;
                    }
                }
            }

            // subjects
            if (count($list_spaces['subjects']) <> 0) {
                $subjects_model = Yeah_Adapter::getModel('subjects');
                foreach ($list_spaces['subjects'] as $subject) {
                    @list($element, $ident) = @split('-', $subject);
                    $subject = $subjects_model->findByIdent($ident);
                    $_resources = $subject->findmodules_resources_models_ResourcesViamodules_subjects_models_Subjects_Resources();
                    foreach ($_resources as $resource) {
                        $resources[$resource->tsregister] = $resource;
                    }
                }
            }

            // groups
            if (count($list_spaces['groups']) <> 0) {
                $groups_model = Yeah_Adapter::getModel('groups');
                foreach ($list_spaces['groups'] as $group) {
                    @list($element, $ident) = @split('-', $group);
                    $group = $groups_model->findByIdent($ident);
                    $_resources = $group->findmodules_resources_models_ResourcesViamodules_groups_models_Groups_Resources();
                    foreach ($_resources as $resource) {
                        $resources[$resource->tsregister] = $resource;
                    }
                }
            }

            // teams
            if (count($list_spaces['teams']) <> 0) {
                $teams_model = Yeah_Adapter::getModel('teams');
                foreach ($list_spaces['teams'] as $team) {
                    @list($element, $ident) = @split('-', $team);
                    $team = $teams_model->findByIdent($ident);
                    $_resources = $team->findmodules_resources_models_ResourcesViamodules_teams_models_Teams_Resources();
                    foreach ($_resources as $resource) {
                        $resources[$resource->tsregister] = $resource;
                    }
                }
            }

            // community
            if (count($list_spaces['communities']) <> 0) {
                $communities_model = Yeah_Adapter::getModel('communities');
                foreach ($list_spaces['communities'] as $community) {
                    @list($element, $ident) = @split('-', $community);
                    $community = $communities_model->findByIdent($ident);
                    $_resources = $community->findmodules_resources_models_ResourcesViamodules_communities_models_Communities_Resources();
                    foreach ($_resources as $resource) {
                        $resources[$resource->tsregister] = $resource;
                    }
                }
            }

            // user
            if (count($list_spaces['users']) <> 0) {
                $users_model = Yeah_Adapter::getModel('users');
                foreach ($list_spaces['users'] as $user) {
                    @list($element, $ident) = @split('-', $user);
                    $user = $users_model->findByIdent($ident);
                    $_resources = $user->findmodules_resources_models_ResourcesViamodules_users_models_Users_Resources();
                    foreach ($_resources as $resource) {
                        $resources[$resource->tsregister] = $resource;
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

            $this->view->icons = $icons;
            $this->view->resources = $paginator;
            $this->view->route = array (
            	'key' => 'frontpage_user',
                'params' => array (),         
            );
        } else {
            $this->_redirect($this->view->url(array(), 'frontpage_visitor'));
        }
    }
}
