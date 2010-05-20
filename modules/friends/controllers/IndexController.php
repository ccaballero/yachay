<?php

class Friends_IndexController extends Yeah_Action
{
    public function indexAction() {
        global $USER;

        $this->requirePermission('friends', 'contact');

        $friends_model = Yeah_Adapter::getModel('friends');
        $friends = $friends_model->selectByUser($USER->ident);

        $users_model = Yeah_Adapter::getModel('users');
        $request = $this->getRequest();

        $this->view->model = $friends_model;
        $this->view->friends = $friends;
        $this->view->users = $users_model;

        history('friends');
        $breadcrumb = array();
        breadcrumb($breadcrumb);
    }

    public function addAction() {
        global $USER;

        $this->requirePermission('friends', 'contact');
        $request = $this->getRequest();

        $url = $request->getParam('user');
        $users = Yeah_Adapter::getModel('users');
        $user = $users->findByUrl($url);

        $this->requireExistence($user, 'user', 'users_user_view', 'users_list');
        if ($USER->ident == $user->ident) {
            $this->_redirect($this->view->currentPage());
        }

        $model = Yeah_Adapter::getModel('friends');
        $session = new Zend_Session_Namespace();
        if (!$model->hasContact($USER->ident, $user->ident)) {
            $row = $model->createRow();
            $row->user = $USER->ident;
            $row->friend = $user->ident;
            $row->tsregister = time();
            $row->save();
            $session->messages->addMessage("El usuario {$user->label} ha sido agregado a la lista de contactos");
        } else {
            $session->messages->addMessage("El usuario {$user->label} ya esta agregado");
        }

        $this->_redirect($this->view->currentPage());
    }

    public function deleteAction() {
        global $USER;

        $this->requirePermission('friends', 'contact');
        $request = $this->getRequest();

        $url = $request->getParam('user');
        $users = Yeah_Adapter::getModel('users');
        $user = $users->findByUrl($url);

        $this->requireExistence($user, 'user', 'users_user_view', 'users_list');
        if ($USER->ident == $user->ident) {
            $this->_redirect($this->view->currentPage());
        }

        $model = Yeah_Adapter::getModel('friends');
        $session = new Zend_Session_Namespace();
        if ($model->hasContact($USER->ident, $user->ident)) {
            $contact = $model->getContact($USER->ident, $user->ident);
            $contact->delete();
            $session->messages->addMessage("El usuario {$user->label} ha sido eliminado de la lista de contactos");
        } else {
            $session->messages->addMessage("El usuario {$user->label} no esta en la lista de contactos");
        }

        $this->_redirect($this->view->currentPage());
    }
}
