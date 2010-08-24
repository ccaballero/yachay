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
                $resources[] = $model_resources->findByIdent($resource_global->resource);
            }

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
            $this->_forward('user');
        }
    }

    public function userAction() {
        global $USER;

        if ($USER->role != 1) {
            history();

            $modules = Yeah_Adapter::getModel('modules');
            $icons = array();

            if ($modules->findByLabel('modules')->status == 'active') {
                if (Yeah_Acl::hasPermission('modules', array('new', 'lock'))) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'modules_manager'),
                        'icon' => '<img src="' . $this->view->media . 'modules.png" alt="[Gestion de modulos]" />',
                    );
                } else if (Yeah_Acl::hasPermission('modules', 'list')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'modules_list'),
                        'icon' => '<img src="' . $this->view->media . 'modules.png" alt="[Lista de modulos]" />',
                    );
                }
            }

            if ($modules->findByLabel('pages')->status == 'active') {
                if (Yeah_Acl::hasPermission('pages', 'manage')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'pages_manager'),
                        'icon' => '<img src="' . $this->view->media . 'pages.png" alt="[Gestion de paginas]" />',
                    );
                } else if (Yeah_Acl::hasPermission('pages', 'list')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'pages_list'),
                        'icon' => '<img src="' . $this->view->media . 'pages.png" alt="[Lista de paginas]" />',
                    );
                }
            }

            if ($modules->findByLabel('regions')->status == 'active') {
                if (Yeah_Acl::hasPermission('regions', 'manage')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'regions_manager'),
                        'icon' => '<img src="' . $this->view->media . 'regions.png" alt="[Gestion de regions]" />',
                    );
                } else if (Yeah_Acl::hasPermission('regions', 'list')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'regions_list'),
                        'icon' => '<img src="' . $this->view->media . 'regions.png" alt="[Lista de regiones]" />',
                    );
                }
            }

            if ($modules->findByLabel('widgets')->status == 'active') {
                if (Yeah_Acl::hasPermission('widgets', 'manage')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'widgets_manager'),
                        'icon' => '<img src="' . $this->view->media . 'widgets.png" alt="[Gestion de widgets]" />',
                    );
                } else if (Yeah_Acl::hasPermission('widgets', 'list')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'widgets_list'),
                        'icon' => '<img src="' . $this->view->media . 'widgets.png" alt="[Lista de widgets]" />',
                    );
                }
            }

            if ($modules->findByLabel('roles')->status == 'active') {
                if (Yeah_Acl::hasPermission('roles', array('new', 'assign', 'delete'))) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'roles_manager'),
                        'icon' => '<img src="' . $this->view->media . 'roles.png" alt="[Gestion de roles]" />',
                    );
                } else if (Yeah_Acl::hasPermission('roles', 'list')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'roles_list'),
                        'icon' => '<img src="' . $this->view->media . 'roles.png" alt="[Lista de roles]" />',
                    );
                }
            }

            if ($modules->findByLabel('users')->status == 'active') {
                if (Yeah_Acl::hasPermission('users', array('new', 'import', 'export', 'lock', 'delete'))) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'users_manager'),
                        'icon' => '<img src="' . $this->view->media . 'users.png" alt="[Gestion de usuarios]" />',
                    );
                } else if (Yeah_Acl::hasPermission('users', 'list')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'users_list'),
                        'icon' => '<img src="' . $this->view->media . 'users.png" alt="[Lista de usuarios]" />',
                    );
                }
            }

            if ($modules->findByLabel('friends')->status == 'active') {
                if (Yeah_Acl::hasPermission('friends', 'contact')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'friends_list'),
                        'icon' => '<img src="' . $this->view->media . 'friends.png" alt="[Lista de contactos]" />',
                    );
                }
            }

            if ($modules->findByLabel('gestions')->status == 'active') {
                if (Yeah_Acl::hasPermission('gestions', array('new', 'active', 'delete'))) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'gestions_manager'),
                        'icon' => '<img src="' . $this->view->media . 'gestions.png" alt="[Gestion de gestiones]" />',
                    );
                } else if (Yeah_Acl::hasPermission('gestions', 'list')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'gestions_list'),
                        'icon' => '<img src="' . $this->view->media . 'gestions.png" alt="[Lista de gestiones]" />',
                    );
                }
            }

            if ($modules->findByLabel('areas')->status == 'active') {
                if (Yeah_Acl::hasPermission('areas', array('new', 'delete'))) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'areas_manager'),
                        'icon' => '<img src="' . $this->view->media . 'areas.png" alt="[Gestion de areas]" />',
                    );
                } else if (Yeah_Acl::hasPermission('areas', 'list')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'areas_list'),
                        'icon' => '<img src="' . $this->view->media . 'areas.png" alt="[Lista de areas]" />',
                    );
                }
            }

            if ($modules->findByLabel('subjects')->status == 'active') {
                if (Yeah_Acl::hasPermission('subjects', array('new', 'lock', 'delete'))) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'subjects_manager'),
                        'icon' => '<img src="' . $this->view->media . 'subjects.png" alt="[Gestion de materias]" />',
                    );
                } else if (Yeah_Acl::hasPermission('subjects', 'list')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'subjects_list'),
                        'icon' => '<img src="' . $this->view->media . 'subjects.png" alt="[Lista de materias]" />',
                    );
                }
            }

            if ($modules->findByLabel('groups')->status == 'active') {
                if (Yeah_Acl::hasPermission('subjects', array('teach', 'helper', 'study', 'participate'))) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'groups_list'),
                        'icon' => '<img src="' . $this->view->media . 'groups.png" alt="[Lista de grupos]" />',
                    );
                }
            }

            /*if ($modules->findByLabel('communities')->status == 'active') {
                if (Yeah_Acl::hasPermission('communities', 'list')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'communities_list'),
                        'icon' => '<img src="' . $this->view->media . 'communities.png" alt="[Lista de comunidades]" />',
                    );
                }
            }*/

            if ($modules->findByLabel('groupsets')->status == 'active') {
                if (Yeah_Acl::hasPermission('subjects', 'teach')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'groupsets_manager'),
                        'icon' => '<img src="' . $this->view->media . 'groupsets.png" alt="[Administrador de conjuntos]" />',
                    );
                }
            }

            if ($modules->findByLabel('resources')->status == 'active') {
                if (Yeah_Acl::hasPermission('resources', 'new')) {
                    $icons[] = array(
                        'url' => $this->view->url(array(), 'resources_list'),
                        'icon' => '<img src="' . $this->view->media . 'resources.png" alt="[Recursos publicados]" />',
                    );
                }
            }

/*
            if ($this->modules->findByLabel('invitations')->status == 'active') {
                if (Yeah_Acl::hasPermission('invitations', 'new') || Yeah_Acl::hasPermission('invitations', 'delete')) { ?>
            <a href="<?= $this->url(array(), 'invitations_manager') ?>"><img src="<?= $this->media . 'invitations.png' ?>" alt="[Gestion de invitaciones]" /></a>
        <?php } else { ?>
            <?php if (Yeah_Acl::hasPermission('invitations', 'list')) { ?>
                <a href="<?= $this->url(array(), 'invitations_list') ?>"><img src="<?= $this->media . 'invitations.png' ?>" alt="[Lista de invitaciones]" /></a>
            <?php } ?>
        <?php } ?>
    <?php } ?>

    <?php if ($this->modules->findByLabel('search')->status == 'active') { ?>
        <?php if (Yeah_Acl::hasPermission('search', 'list')) { ?>
            <a href="<?= $this->url(array(), 'search_list') ?>"><img src="<?= $this->media . 'search.png' ?>" alt="[Busqueda]" /></a>
        <?php } ?>
    <?php } ?>*/

            $model_resources_globales = Yeah_Adapter::getModel('resources', 'Resources_Globales');
            $resources_globales = $model_resources_globales->selectAll();
            $model_resources = Yeah_Adapter::getModel('resources');

            $resources = array();
            foreach($resources_globales as $resource_global) {
                $resources[] = $model_resources->findByIdent($resource_global->resource);
            }

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
            $this->_forward('visitor');
        }
    }
}
