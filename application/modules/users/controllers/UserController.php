<?php

class Users_UserController extends Yachay_Action
{
    public function viewAction() {
        $this->requirePermission('users', 'view');

        $model_friends = new Friends();
        $model_users = new Users();

        $request = $this->getRequest();
        $user = $model_users->findByUrl($request->getParam('user'));

        $this->requireExistence($user, 'user', 'users_user_view', 'users_list');

        $this->context('user', $user);

        $resources = $user->findResourcesViaUsers_Resources($user->select()->order('tsregister DESC'));

        // PAGINATOR
        $page = $request->getParam('page', 1);
        $paginator = Zend_Paginator::factory($resources);
        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);
        $paginator->setPageRange(10);

        $this->view->model_users = $model_users;
        $this->view->user = $user;
        $this->view->model_friends = $model_friends;
        $this->view->resources = $paginator;
        $this->view->route = array (
            'key' => 'users_user_view',
            'params' => array (
                'user' => $user->url,
            ),
        );

        $this->history('users/' . $user->url);
        $breadcrumb = array();
        if ($this->acl('users', 'list')) {
            $breadcrumb['Usuarios'] = $this->view->url(array(), 'users_list');
        }
        if ($this->acl('users', array('new', 'import', 'export', 'lock', 'delete'))) {
            $breadcrumb['Administrador de usuarios'] = $this->view->url(array(), 'users_manager');
        }
        breadcrumb($breadcrumb);
    }

    public function editAction() {
        $this->requirePermission('users', 'edit');

        $request = $this->getRequest();
        $model_users = new Users();
        $user = $model_users->findByUrl($request->getParam('user'));

        $this->requireExistence($user, 'user', 'users_user_view', 'users_list');
        $this->requireMorePrivileges($user, 'user', 'users_user_view', 'users_list');

        $this->context('user', $user);

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace('yachay');

            $user->label = $request->getParam('label');
            $user->url = convert($user->label);
            $user->code = $request->getParam('code');
            $user->formalname= $request->getParam('formal');
            $user->email = $request->getParam('email');
            $user->surname = $request->getParam('surname');
            $user->name = $request->getParam('name');
            $user->birthdate = $request->getParam('birthdate-year') . '-' . $request->getParam('birthdate-month') . '-' . $request->getParam('birthdate-day');
            $user->career = $request->getParam('career');
            $user->phone = $request->getParam('phone');
            $user->cellphone = $request->getParam('cellphone');

            global $USER;
            if ($USER->ident <> $user->ident) {
                $user->role = $request->getParam('role');
            }

            if ($user->isValid()) {
                // role validation,, critical point
                $valid_role = false;
                if ($USER->ident == $user->ident) {
                    $valid_role = true;
                } else {
                    $model_roles = new Roles();
                    $roles = $model_roles->selectByIncludes($USER->role);
                    foreach ($roles as $role) {
                        if ($role->ident == $user->role) {
                            $valid_role |= true;
                        }
                    }
                }

                if ($valid_role) {
                    $user->save();

                    $this->_helper->flashMessenger->addMessage("El usuario {$user->label} se ha actualizado correctamente");
                    $session->url = $user->url;
                    $this->_redirect($request->getParam('return'));
                } else {
                    $this->_helper->flashMessenger->addMessage("No tiene permisos para establecer ese rol en ese usuario");
                }
            } else {
                foreach ($user->getMessages() as $message) {
                    $this->_helper->flashMessenger->addMessage($message);
                }
            }
        }

        $this->view->model_users = $model_users;
        $this->view->user = $user;

        $this->history('users/' . $user->url . '/edit');
        $breadcrumb = array();
        if ($this->acl('users', 'list')) {
            $breadcrumb['Usuarios'] = $this->view->url(array(), 'users_list');
        }
        if ($this->acl('users', array('new', 'import', 'export', 'lock', 'delete'))) {
            $breadcrumb['Administrador de usuarios'] = $this->view->url(array(), 'users_manager');
        }
        if ($this->acl('users', 'view')) {
            $breadcrumb[$user->label] = $this->view->url(array('user' => $user->url), 'users_user_view');
        }
        breadcrumb($breadcrumb);
    }

    public function lockAction() {
        $this->requirePermission('users', 'lock');
        $request = $this->getRequest();

        $url = $request->getParam('user');
        $model_users = new Users();
        $user = $model_users->findByUrl($url);

        $this->requireExistence($user, 'user', 'users_user_view', 'users_list');
        $this->requireMorePrivileges($user, 'user', 'users_user_view', 'users_list');

        $user->status = 'inactive';
        $user->save();

        $this->_helper->flashMessenger->addMessage("El usuario {$user->label} ha sido bloqueado");
        $this->_redirect($this->view->currentPage());
    }

    public function unlockAction() {
        $this->requirePermission('users', 'lock');
        $request = $this->getRequest();

        $url = $request->getParam('user');
        $model_users = new Users();
        $user = $model_users->findByUrl($url);

        $this->requireExistence($user, 'user', 'users_user_view', 'users_list');
        $this->requireMorePrivileges($user, 'user', 'users_user_view', 'users_list');

        $user->status = 'active';
        $user->save();
        
        $this->_helper->flashMessenger->addMessage("El usuario {$user->label} ha sido desbloqueado");
        $this->_redirect($this->view->currentPage());
    }

    public function deleteAction() {
        $this->requirePermission('users', 'delete');
        $request = $this->getRequest();

        $url = $request->getParam('user');
        $model_users = new Users();
        $user = $model_users->findByUrl($url);

        $this->requireExistence($user, 'user', 'users_user_view', 'users_list');
        $this->requireMorePrivileges($user, 'user', 'users_user_view', 'users_list');

        // FIXME Agregar prohibiciones para usuarios con asignaciones criticas.
        $label = $user->label;
        $user->delete();

        $this->_helper->flashMessenger->addMessage("El usuario $label ha sido eliminado");
        $this->_redirect($this->view->currentPage());
    }
}
