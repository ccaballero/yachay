<?php

class Invitations_ManagerController extends Yachay_Controller_Action
{
    public function indexAction() {
        $this->requirePermission('invitations', 'invite');

        $model_invitations = new Invitations();

        $this->view->model_invitations = $model_invitations;
        $this->view->invitations = $model_invitations->selectAll();

        $this->history('invitations/manager');
        $this->breadcrumb(array('Administrador de invitaciones' => $this->view->url(array(), 'invitations_manager')));
    }

    public function newAction() {
        $this->requirePermission('invitations', 'invite');

        $this->view->invitation = new Invitations_Empty();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $model_invitations = new Invitations();
            $invitation = $model_invitations->createRow();

            $code_valid = false;
            while (!$code_valid) {
                $generateCode = new Yachay_Helpers_GenerateCode();
                $code = $generateCode->generateCode('alphanum', NULL, 64);
                $existent_invitation = $model_invitations->findByCode(md5($this->config->system->key . $code));
                if (empty($existent_invitation)) {
                    $code_valid = true;
                }
            }

            $invitation->author = $this->user->ident;
            $invitation->email = $request->getParam('email');
            $invitation->message = $request->getParam('message');

            if ($invitation->isValid()) {
                $invitation->code = md5($this->config->system->key . $code);
                $invitation->tsregister = time();
                $invitation->save();

                // Sending to mail
                $view = new Zend_View();
                $view->addHelperPath(APPLICATION_PATH . '/library/Yachay/Helpers', 'Yachay_Helpers');
                $view->setScriptPath($this->config->resources->frontController->moduleDirectory . '/invitations/views/scripts/invitation/');

                $view->url = $this->view->url(array('code' => $code), 'invitations_invitation_proceed');
                $view->message = $invitation->message;
                $view->user = $this->user;
                $view->site = $this->config->system->url;

                $content = $view->render('mail.php');

                $mail = new Zend_Mail('UTF-8');
                $mail->setBodyHtml($content)
                     ->setFrom($this->config->system->email_direction, $this->config->system->email_name)
                     ->addTo($invitation->email)
                     ->setSubject($this->user->label . ' te ha invitado a ' . $this->config->system->url)
                     ->send();

                $this->_helper->flashMessenger->addMessage('La invitación ha sido enviada al correo electronico');
                $this->_redirect($request->getParam('return'));
            } else {
                foreach ($invitation->getMessages() as $message) {
                    $this->_helper->flashMessenger->addMessage($message);
                }
            }

            $this->view->invitation = $invitation;
        } else {
            $this->history('invitations/manager');
        }

        $this->breadcrumb(array(
            'Administrador de invitaciones' => $this->view->url(array(), 'invitations_manager'),
            'Nueva invitación' => $this->view->url(array(), 'invitations_new'),
        ));
    }
}
