<?php

class IndexController extends Yeah_Action
{
    public function indexAction() {
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

            $model_modules = new Modules();
            $icons = array();

            if ($model_modules->findByLabel('areas')->status == 'active') {
                if ($this->acl('areas', array('new', 'delete'))) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'areas_manager'),
                        'alt' => 'Gestión de areas',
                        'icon' => 'areas.png',
                    );
                } else if ($this->acl('areas', 'list')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'areas_list'),
                        'alt' => 'Lista de areas',
                        'icon' => 'areas.png',
                    );
                }
            }

            if ($model_modules->findByLabel('careers')->status == 'active') {
                if ($this->acl('careers', array('new', 'delete'))) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'careers_manager'),
                        'alt' => 'Gestión de carreras',
                        'icon' => 'careers.png',
                    );
                } else if ($this->acl('careers', 'list')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'careers_list'),
                        'alt' => 'Lista de carreras',
                        'icon' => 'careers.png',
                    );
                }
            }

            if ($model_modules->findByLabel('communities')->status == 'active') {
                if ($this->acl('communities', 'list')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'communities_list'),
                        'alt' => 'Lista de comunidades',
                        'icon' => 'communities.png',
                    );
                }
            }

            if ($model_modules->findByLabel('groupsets')->status == 'active') {
                if ($this->acl('subjects', 'teach')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'groupsets_manager'),
                        'alt' => 'Administrador de conjuntos',
                        'icon' => 'groupsets.png',
                    );
                }
            }

            if ($model_modules->findByLabel('friends')->status == 'active') {
                if ($this->acl('friends', 'contact')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'friends_friends'),
                        'alt' => 'Lista de contactos',
                        'icon' => 'friends.png',
                    );
                }
            }

            if ($model_modules->findByLabel('gestions')->status == 'active') {
                if ($this->acl('gestions', array('new', 'active', 'delete'))) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'gestions_manager'),
                        'alt' => 'Gestión de gestiones',
                        'icon' => 'gestions.png',
                    );
                } else if ($this->acl('gestions', 'list')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'gestions_list'),
                        'alt' => 'Lista de gestiones',
                        'icon' => 'gestions.png',
                    );
                }
            }

            if ($model_modules->findByLabel('groups')->status == 'active') {
                if ($this->acl('subjects', array('teach', 'helper', 'study', 'participate'))) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'groups_list'),
                        'alt' => 'Lista de grupos',
                        'icon' => 'groups.png',
                    );
                }
            }

            if ($model_modules->findByLabel('subjects')->status == 'active') {
                if ($this->acl('subjects', array('new', 'lock', 'delete'))) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'subjects_manager'),
                        'alt' => 'Gestión de materias',
                        'icon' => 'subjects.png',
                    );
                } else if ($this->acl('subjects', 'list')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'subjects_list'),
                        'alt' => 'Lista de materias',
                        'icon' => 'subjects.png',
                    );
                }
            }

            if ($model_modules->findByLabel('modules')->status == 'active') {
                if ($this->acl('modules', array('new', 'lock'))) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'modules_manager'),
                        'alt' => 'Gestión de modulos',
                        'icon' => 'modules.png',
                    );
                } else if ($this->acl('modules', 'list')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'modules_list'),
                        'alt' => 'Lista de modulos',
                        'icon' => 'modules.png',
                    );
                }
            }

            if ($model_modules->findByLabel('pages')->status == 'active') {
                if ($this->acl('pages', 'manage')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'pages_manager'),
                        'alt' => 'Gestión de paginas',
                        'icon' => 'pages.png',
                    );
                } else if ($this->acl('pages', 'list')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'pages_list'),
                        'alt' => 'Lista de paginas',
                        'icon' => 'pages.png',
                    );
                }
            }

            if ($model_modules->findByLabel('resources')->status == 'active') {
                if ($this->acl('resources', 'new')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'resources_list'),
                        'alt' => 'Recursos publicados',
                        'icon' => 'resources.png',
                    );
                }
            }

            if ($model_modules->findByLabel('regions')->status == 'active') {
                if ($this->acl('regions', 'manage')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'regions_manager'),
                        'alt' => 'Gestión de regiones',
                        'icon' => 'regions.png',
                    );
                } else if ($this->acl('regions', 'list')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'regions_list'),
                        'alt' => 'Lista de regions',
                        'icon' => 'regions.png',
                    );
                }
            }

            if ($model_modules->findByLabel('roles')->status == 'active') {
                if ($this->acl('roles', array('new', 'assign', 'delete'))) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'roles_manager'),
                        'alt' => 'Gestión de roles',
                        'icon' => 'roles.png',
                    );
                } else if ($this->acl('roles', 'list')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'roles_list'),
                        'alt' => 'Lista de roles',
                        'icon' => 'roles.png',
                    );
                }
            }

            if ($model_modules->findByLabel('users')->status == 'active') {
                if ($this->acl('users', array('new', 'import', 'export', 'lock', 'delete'))) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'users_manager'),
                        'alt' => 'Gestión de usuarios',
                        'icon' => 'users.png',
                    );
                } else if ($this->acl('users', 'list')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'users_list'),
                        'alt' => 'Lista de usuarios',
                        'icon' => 'users.png',
                    );
                }
            }

            if ($model_modules->findByLabel('widgets')->status == 'active') {
                if ($this->acl('widgets', 'manage')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'widgets_manager'),
                        'alt' => 'Gestión de widgets',
                        'icon' => 'widgets.png',
                    );
                } else if ($this->acl('widgets', 'list')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'widgets_list'),
                        'alt' => 'Lista de widgets',
                        'icon' => 'widgets.png',
                    );
                }
            }

            $model_resources = new Resources();
            $model_resources_globales = new Resources_Globales();
            $resources_globales = $model_resources_globales->selectAll();

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
                $model_areas = new Areas();
                foreach ($list_spaces['areas'] as $area) {
                    @list($element, $ident) = @split('-', $area);
                    $area = $model_areas->findByIdent($ident);
                    $_resources = $area->findResourcesViaAreas_Resources();
                    foreach ($_resources as $resource) {
                        $resources[$resource->tsregister] = $resource;
                    }
                }
            }

            // careers
            if (count($list_spaces['careers']) <> 0) {
                $model_careers = new Careers();
                foreach ($list_spaces['careers'] as $career) {
                    @list($element, $ident) = @split('-', $career);
                    $career = $model_careers->findByIdent($ident);
                    $_resources = $career->findResourcesViaCareers_Resources();
                    foreach ($_resources as $resource) {
                        $resources[$resource->tsregister] = $resource;
                    }
                }
            }

            // subjects
            if (count($list_spaces['subjects']) <> 0) {
                $model_subjects = new Subjects();
                foreach ($list_spaces['subjects'] as $subject) {
                    @list($element, $ident) = @split('-', $subject);
                    $subject = $model_subjects->findByIdent($ident);
                    $_resources = $subject->findResourcesViaSubjects_Resources();
                    foreach ($_resources as $resource) {
                        $resources[$resource->tsregister] = $resource;
                    }
                }
            }

            // groups
            if (count($list_spaces['groups']) <> 0) {
                $model_groups = new Groups();
                foreach ($list_spaces['groups'] as $group) {
                    @list($element, $ident) = @split('-', $group);
                    $group = $model_groups->findByIdent($ident);
                    $_resources = $group->findResourcesViaGroups_Resources();
                    foreach ($_resources as $resource) {
                        $resources[$resource->tsregister] = $resource;
                    }
                }
            }

            // teams
            if (count($list_spaces['teams']) <> 0) {
                $model_teams = new Teams();
                foreach ($list_spaces['teams'] as $team) {
                    @list($element, $ident) = @split('-', $team);
                    $team = $model_teams->findByIdent($ident);
                    $_resources = $team->findResourcesViaTeams_Resources();
                    foreach ($_resources as $resource) {
                        $resources[$resource->tsregister] = $resource;
                    }
                }
            }

            // community
            if (count($list_spaces['communities']) <> 0) {
                $model_communities = new Communities();
                foreach ($list_spaces['communities'] as $community) {
                    @list($element, $ident) = @split('-', $community);
                    $community = $model_communities->findByIdent($ident);
                    $_resources = $community->findResourcesViaCommunities_Resources();
                    foreach ($_resources as $resource) {
                        $resources[$resource->tsregister] = $resource;
                    }
                }
            }

            // user
            if (count($list_spaces['users']) <> 0) {
                $model_users = new Users();
                foreach ($list_spaces['users'] as $user) {
                    @list($element, $ident) = @split('-', $user);
                    $user = $model_users->findByIdent($ident);
                    $_resources = $user->findResourcesViaUsers_Resources();
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
                'params' => array(),         
            );
        } else {
            $this->_redirect($this->view->url(array(), 'frontpage_visitor'));
        }
    }
}
