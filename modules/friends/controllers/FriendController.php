<?php

class Friends_FriendController extends Yeah_Action
{
    public function addAction() {
        global $USER;

        $this->requirePermission('friends', 'contact');
        $request = $this->getRequest();

        $model_users = new Users();
        $model_friends = new Friends();
        $model_valorations = new Valorations();

        $url = $request->getParam('user');
        $user = $model_users->findByUrl($url);

        $this->requireExistence($user, 'user', 'users_user_view', 'users_list');
        if ($USER->ident == $user->ident) {
            $this->_redirect($this->view->currentPage());
        }

        $session = new Zend_Session_Namespace();

        $follower = $model_friends->hasContact($USER->ident, $user->ident);
        $following = $model_friends->hasContact($user->ident, $USER->ident);

        if ($follower) {
            if ($following) {
                $session->messages->addMessage("El usuario {$user->label} ya esta agregado");
            } else {
                $session->messages->addMessage("Ya existe una solicitud registrada al usuario {$user->label}");
            }
        } else {
            if ($following) {
                $row = $model_friends->createRow();
                $row->user = $USER->ident;
                $row->friend = $user->ident;
                $row->mutual = TRUE;
                $row->tsregister = time();
                $row->save();
                $row = $model_friends->getContact($user->ident, $USER->ident);
                $row->mutual = TRUE;
                $row->save();

                $model_valorations->addSociability($user, 3, 2);

                $session->messages->addMessage("El usuario {$user->label} ha sido agregado a la lista de amigos");
            } else {
                $row = $model_friends->createRow();
                $row->user = $USER->ident;
                $row->friend = $user->ident;
                $row->mutual = FALSE;
                $row->tsregister = time();
                $row->save();

                $model_valorations->addSociability($user, 2, 1);

                $session->messages->addMessage("Se envio un petición al usuario {$user->label}");
            }
        }

        $this->_redirect($this->view->currentPage());
    }

    public function deleteAction() {
        global $USER;

        $this->requirePermission('friends', 'contact');
        $request = $this->getRequest();

        $model_users = new Users();
        $model_friends = new Friends();
        $model_valorations = new Valorations();

        $url = $request->getParam('user');
        $user = $model_users->findByUrl($url);

        $this->requireExistence($user, 'user', 'users_user_view', 'users_list');
        if ($USER->ident == $user->ident) {
            $this->_redirect($this->view->currentPage());
        }

        $session = new Zend_Session_Namespace();

        $follower = $model_friends->hasContact($USER->ident, $user->ident);
        $following = $model_friends->hasContact($user->ident, $USER->ident);

        if ($follower) {
            if ($following) {
                $row = $model_friends->getContact($USER->ident, $user->ident);
                $row->delete();
                $row = $model_friends->getContact($user->ident, $USER->ident);
                $row->mutual = FALSE;
                $row->save();

                $model_valorations->decreaseSociability($user, 3, 2);

                $session->messages->addMessage("El usuario {$user->label} ha sido retirado de la lista de amigos");
            } else {
                $row = $model_friends->getContact($USER->ident, $user->ident);
                $row->delete();

                $model_valorations->decreaseSociability($user, 2, 1);

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
