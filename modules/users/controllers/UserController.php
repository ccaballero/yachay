<?php

class Users_UserController extends Yeah_Action
{
    public function viewAction() {
        global $USER;

        $this->requirePermission('users', 'view');

        $request = $this->getRequest();
        $model_friends = Yeah_Adapter::getModel('friends');
        $users = Yeah_Adapter::getModel('users');
        $user = $users->findByUrl($request->getParam('user'));

        $this->requireExistence($user, 'user', 'users_user_view', 'users_list');

        context('user', $user);

        $resources = $user->findmodules_resources_models_ResourcesViamodules_users_models_Users_Resources($user->select()->order('tsregister DESC'));

        // PAGINATOR
        $page = $request->getParam('page', 1);
        $paginator = Zend_Paginator::factory($resources);
        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);
        $paginator->setPageRange(10);

        $this->view->model = $users;
        $this->view->friends = $model_friends;
        $this->view->user = $user;
        $this->view->resources = $paginator;
        $this->view->route = array (
            'key' => 'users_user_view',
            'params' => array (
                'user' => $user->url,
            ),
        );

        history('users/' . $user->url);
        $breadcrumb = array();
        if (Yeah_Acl::hasPermission('users', array('new', 'import', 'export', 'lock', 'delete'))) {
            $breadcrumb['Usuarios'] = $this->view->url(array(), 'users_manager');
        } else if (Yeah_Acl::hasPermission('users', 'list')) {
            $breadcrumb['Usuarios'] = $this->view->url(array(), 'users_list');
        }
        breadcrumb($breadcrumb);
    }

    public function editAction() {
        $this->requirePermission('users', 'edit');

        $request = $this->getRequest();
        $users = Yeah_Adapter::getModel('users');
        $user = $users->findByUrl($request->getParam('user'));

        $this->requireExistence($user, 'user', 'users_user_view', 'users_list');

        context('user', $user);

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $user->label = $request->getParam('label');
            $user->email = $request->getParam('email');
            $user->role = $request->getParam('role');
            $user->code = $request->getParam('code');
            $user->surname = $request->getParam('surname');
            $user->name = $request->getParam('name');
            $user->birthdate = $request->getParam('birthdate-year') . '-' . $request->getParam('birthdate-month') . '-' . $request->getParam('birthdate-day');
            $user->career = $request->getParam('career');
            $user->phone = $request->getParam('phone');
            $user->cellphone = $request->getParam('cellphone');

            if ($user->isValid()) {
                global $CONFIG;
                // role validation,, critical point
                global $USER;
                $model = Yeah_Adapter::getModel('roles');
                $roles = $model->selectByIncludes($USER->role);
                $valid_role = false;
                foreach ($roles as $role) {
                    if ($role->ident == $user->role) {
                        $valid_role |= true;
                    }
                }

                if ($valid_role) {
                    $user->save();

                    $session->messages->addMessage("El usuario {$user->label} se ha actualizado correctamente");
                    $session->url = $user->url;
                    $this->_redirect($request->getParam('return'));
                } else {
                    $session->messages->addMessage("No tiene permisos para establecer ese rol en ese usuario");
                }
            } else {
                foreach ($user->getMessages() as $message) {
                    $session->messages->addMessage($message);
                }
            }
        }

        $this->view->model = $users;
        $this->view->user = $user;

        history('users/' . $user->url . '/edit');
        $breadcrumb = array();
        if (Yeah_Acl::hasPermission('users', array('new', 'import', 'export', 'lock', 'delete'))) {
            $breadcrumb['Usuarios'] = $this->view->url(array(), 'users_manager');
        } else if (Yeah_Acl::hasPermission('users', 'list')) {
            $breadcrumb['Usuarios'] = $this->view->url(array(), 'users_list');
        }
        if (Yeah_Acl::hasPermission('users', 'view')) {
            $breadcrumb[$user->label] = $this->view->url(array('user' => $user->url), 'users_user_view');
        }
        breadcrumb($breadcrumb);
    }

    public function lockAction() {
        global $USER;

        $this->requirePermission('users', 'lock');
        $request = $this->getRequest();

        $url = $request->getParam('user');
        $users = Yeah_Adapter::getModel('users');
        $user = $users->findByUrl($url);

        $this->requireExistence($user, 'user', 'users_user_view', 'users_list');

        $model = Yeah_Adapter::getModel('roles');
        $roles = $model->selectByIncludes($USER->role);
        $valid_role = false;
        foreach ($roles as $role) {
            if ($role->ident == $user->role) {
                $valid_role |= true;
            }
        }

        $session = new Zend_Session_Namespace();
        if ($valid_role) {
            $user->status = 'inactive';
            $user->save();
            $session->messages->addMessage("El usuario {$user->label} ha sido bloqueado");
        } else {
            $session->messages->addMessage("El usuario {$user->label} no puede ser bloqueado");
        }

        $this->_redirect($this->view->currentPage());
    }

    public function unlockAction() {
        global $USER;

        $this->requirePermission('users', 'lock');
        $request = $this->getRequest();

        $url = $request->getParam('user');
        $users = Yeah_Adapter::getModel('users');
        $user = $users->findByUrl($url);

        $this->requireExistence($user, 'user', 'users_user_view', 'users_list');

        $model = Yeah_Adapter::getModel('roles');
        $roles = $model->selectByIncludes($USER->role);
        $valid_role = false;
        foreach ($roles as $role) {
            if ($role->ident == $user->role) {
                $valid_role |= true;
            }
        }

        $session = new Zend_Session_Namespace();
        if ($valid_role) {
            $user->status = 'active';
            $user->save();
            $session->messages->addMessage("El usuario {$user->label} ha sido desbloqueado");
        } else {
            $session->messages->addMessage("El usuario {$user->label} no puede ser desbloqueado");
        }

        $this->_redirect($this->view->currentPage());
    }

    public function deleteAction() {
        global $USER;

        $this->requirePermission('users', 'delete');
        $request = $this->getRequest();

        $url = $request->getParam('user');
        $users = Yeah_Adapter::getModel('users');
        $user = $users->findByUrl($url);

        $this->requireExistence($user, 'user', 'users_user_view', 'users_list');

        $model = Yeah_Adapter::getModel('roles');
        $roles = $model->selectByIncludes($USER->role);
        $valid_role = false;
        foreach ($roles as $role) {
            if ($role->ident == $user->role) {
                $valid_role |= true;
            }
        }

        $session = new Zend_Session_Namespace();
        if ($valid_role) {
            // FIXME Agregar prohibiciones para usuarios con asignaciones criticas.
            $label = $user->label;
            $user->delete();
            $session->messages->addMessage("El usuario $label ha sido eliminado");
        } else {
            $session->messages->addMessage("El usuario no puede ser eliminado");
        }

        $this->_redirect($this->view->currentPage());
    }
}
