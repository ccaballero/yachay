<?php

class Friends_FriendController extends Yeah_Action
{
    public function addAction() {
        global $USER;

        $this->requirePermission('friends', 'contact');
        $request = $this->getRequest();

        $users = Yeah_Adapter::getModel('users');
        $friends = Yeah_Adapter::getModel('friends');

        $url = $request->getParam('user');
        $user = $users->findByUrl($url);

        $this->requireExistence($user, 'user', 'users_user_view', 'users_list');
        if ($USER->ident == $user->ident) {
            $this->_redirect($this->view->currentPage());
        }

        $session = new Zend_Session_Namespace();

        $follower = $friends->hasContact($USER->ident, $user->ident);
        $following = $friends->hasContact($user->ident, $USER->ident);

        if ($follower) {
            if ($following) {
                $session->messages->addMessage("El usuario {$user->label} ya esta agregado");
            } else {
                $session->messages->addMessage("Ya existe una solicitud registrada al usuario {$user->label}");
            }
        } else {
            if ($following) {
                $row = $friends->createRow();
                $row->user = $USER->ident;
                $row->friend = $user->ident;
                $row->mutual = TRUE;
                $row->tsregister = time();
                $row->save();
                $row = $friends->getContact($user->ident, $USER->ident);
                $row->mutual = TRUE;
                $row->save();
                $session->messages->addMessage("El usuario {$user->label} ha sido agregado a la lista de amigos");
            } else {
                $row = $friends->createRow();
                $row->user = $USER->ident;
                $row->friend = $user->ident;
                $row->mutual = FALSE;
                $row->tsregister = time();
                $row->save();
                $session->messages->addMessage("Se envio un petición al usuario {$user->label}");
            }
        }

        $this->_redirect($this->view->currentPage());
    }

    public function deleteAction() {
        global $USER;

        $this->requirePermission('friends', 'contact');
        $request = $this->getRequest();

        $users = Yeah_Adapter::getModel('users');
        $friends = Yeah_Adapter::getModel('friends');

        $url = $request->getParam('user');
        $user = $users->findByUrl($url);

        $this->requireExistence($user, 'user', 'users_user_view', 'users_list');
        if ($USER->ident == $user->ident) {
            $this->_redirect($this->view->currentPage());
        }

        $session = new Zend_Session_Namespace();

        $follower = $friends->hasContact($USER->ident, $user->ident);
        $following = $friends->hasContact($user->ident, $USER->ident);

        if ($follower) {
            if ($following) {
                $row = $friends->getContact($USER->ident, $user->ident);
                $row->delete();
                $row = $friends->getContact($user->ident, $USER->ident);
                $row->mutual = FALSE;
                $row->save();
                $session->messages->addMessage("El usuario {$user->label} ha sido retirado de la lista de amigos");
            } else {
                $row = $friends->getContact($USER->ident, $user->ident);
                $row->delete();
                $session->messages->addMessage("Has cancelado tu petición al usuario {$user->label}");
            }
        } else {
            if ($following) {
                $session->messages->addMessage("El usuario {$user->label} no esta en la lista de contactos");
            } else {
                $session->messages->addMessage("El usuario {$user->label} no esta en la lista de contactos");
            }
        }

        $this->_redirect($this->view->currentPage());
    }
}
