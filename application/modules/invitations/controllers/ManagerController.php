<?php

class Invitations_ManagerController extends Yachay_Action
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
        global $USER;

        $config = Zend_Registry::get('config');

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
                $existent_invitation = $model_invitations->findByCode(md5($config->yachay->properties->key . $code));
                if (empty($existent_invitation)) {
                    $code_valid = true;
                }
            }

            $invitation->author = $USER->ident;
            $invitation->email = $request->getParam('email');
            $invitation->message = $request->getParam('message');

            if ($invitation->isValid()) {
                $invitation->code = md5($config->yachay->properties->key . $code);
                $invitation->tsregister = time();
                $invitation->save();

                // Sending to mail
                $view = new Zend_View();
                $view->addHelperPath(APPLICATION_PATH . '/../library/Yachay/Helpers', 'Yachay_Helpers');
                $view->setScriptPath(APPLICATION_PATH . '/modules/invitations/views/scripts/invitation/');

                $view->url = $this->view->url(array('code' => $code), 'invitations_invitation_proceed');
                $view->message = $invitation->message;
                $view->user = $USER;
                $view->site = $config->yachay->properties->servername;

                $content = $view->render('mail.php');

                $mail = new Zend_Mail('UTF-8');
                $mail->setBodyHtml($content)
                     ->setFrom($config->yachay->properties->email_direction, $config->yachay->properties->email_name)
                     ->addTo($invitation->email)
                     ->setSubject($USER->label . ' te ha invitado a ' . $config->yachay->properties->servername)
                     ->send();

                $this->_helper->flashMessenger->addMessage('La invitación ha sido enviada al correo electronico');
                $this->_redirect($request->getParam('return'));
            } else {
                foreach ($invitation->getMessages() as $message) {
                    $this->_helper->flashMessenger->addMessage($message);
                }
            }

            $this->view->invitation = $invitation;
        }

        $this->history('invitations/manager');
        $this->breadcrumb(array(
            'Administrador de invitaciones' => $this->view->url(array(), 'invitations_manager'),
            'Nueva invitación' => $this->view->url(array(), 'invitations_new'),
        ));
    }
}
