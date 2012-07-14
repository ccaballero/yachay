<?php

class Invitations_InvitationController extends Yachay_Controller_Action
{
    public function proceedAction() {
        if ($this->user->role != 1) {
            $this->_redirect($this->view->url(array(), 'frontpage'));
        }

        $request = $this->getRequest();
        $code = $request->getParam('code');

        $model_invitations = new Invitations();

        $invitation = $model_invitations->findByCode(md5($this->config->system->key . $code));
        $this->requireExistence($invitation, 'invitation', 'base_user', 'base_user');

        if ($invitation->accepted) {
            $this->_helper->flashMessenger->addMessage('El recurso solicitado no existe');
            $this->_redirect($this->view->url(array(), 'base_visitor'));
        }

        $this->view->user = new Users_Empty();

        if ($request->isPost()) {
            $convert = new Yachay_Helpers_Convert();

            $model_users = new Users();
            $user = $model_users->createRow();

            $user->label = $request->getParam('label');
            $user->url = $convert->convert($user->label);
            $user->password = 'alphanum';
            $user->email = $invitation->email;
            $user->surname = $request->getParam('surname');
            $user->name = $request->getParam('name');
            $user->birthdate = $request->getParam('birthdate-year') . '-' . $request->getParam('birthdate-month') . '-' . $request->getParam('birthdate-day');

            $user->role = 2;

            if ($user->isValid()) {
                // Password generation
                $generateCode = new Yachay_Helpers_GenerateCode();
                $password = $generateCode->generateCode($user->password, $user->code);
                $user->password = md5($this->config->system->key . $password);

                $user->sociability = 1;
                $user->tsregister = time();
                $user->save();

                // email notification
                $view = new Zend_View();
                $view->addHelperPath(APPLICATION_PATH . '/library/Yachay/Helpers', 'Yachay_Helpers');
                $view->setScriptPath($this->config->resources->frontController->moduleDirectory . '/users/views/scripts/user/');

                $view->user       = $user;
                $view->servername = $this->config->system->servername;
                $view->author     = NULL;
                $view->password   = $password;

                $content = $view->render('mail.php');
                $mail = new Zend_Mail('UTF-8');
                $mail->setBodyHtml($content)
                     ->setFrom($this->config->system->email_direction, $this->config->system->email_name)
                     ->addTo($user->email, $user->getFullName())
                     ->setSubject('Notificacion de registro de usuario')
                     ->send();

                // friend connection
                $model_friends = new Friends();

                $author = $invitation->getAuthor();
                $author->sociability = $author->sociability + 2;
                $author->save();

                $row = $model_friends->createRow();
                $row->user = $author->ident;
                $row->friend = $user->ident;
                $row->mutual = FALSE;
                $row->tsregister = time();
                $row->save();

                $invitation->accepted = true;
                $invitation->save();

                $this->_helper->flashMessenger->addMessage('Ha sido enviado un correo con tu contraseña a tu correo electronico');
                $this->_redirect($this->view->url(array(), 'login_in'));
            } else {
                foreach ($user->getMessages() as $message) {
                    $this->_helper->flashMessenger->addMessage($message);
                }
            }

            $this->view->user = $user; // Overwrite
        }

        $this->breadcrumb();
    }

    public function deleteAction() {
        $this->requirePermission('invitations', 'invite');

        $request = $this->getRequest();

        $ident_invitation = $request->getParam('invitation');

        $model_invitations = new Invitations();
        $invitation = $model_invitations->findByIdent($ident_invitation);

        $this->requireExistence($invitation, 'invitation', 'invitations_manager', 'base_user');
        $this->requireResourceAuthor($invitation);

        if (!$invitation->accepted) {
            $invitation->delete();
            $this->_helper->flashMessenger->addMessage('La invitación ha sido revocada');
        } else {
            $this->_helper->flashMessenger->addMessage('La invitación ya ha sido aceptada');
        }

        $this->_redirect($this->view->currentPage());
    }
}
