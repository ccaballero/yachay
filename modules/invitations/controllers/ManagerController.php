<?php

class Invitations_ManagerController extends Yeah_Action
{
    public function indexAction() {
        $this->requirePermission('invitations', 'invite');

        $model_invitations = new Invitations();

        $this->view->model_invitations = $model_invitations;
        $this->view->invitations = $model_invitations->selectAll();

        history('invitations/manager');
        breadcrumb(array('Administrador de invitaciones' => $this->view->url(array(), 'invitations_manager')));
    }

    public function newAction() {
        global $USER;
        global $CONFIG;

        $this->requirePermission('invitations', 'invite');

        $this->view->invitation = new Invitations_Empty();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $model_invitations = new Invitations();
            $invitation = $model_invitations->createRow();

            $code_valid = false;
            while (!$code_valid) {
                $code = generatecode('alphanum', NULL, 64);
                $existent_invitation = $model_invitations->findByCode(md5($CONFIG->key . $code));
                if (empty($existent_invitation)) {
                    $code_valid = true;
                }
            }

            $invitation->author = $USER->ident;
            $invitation->email = $request->getParam('email');
            $invitation->message = $request->getParam('message');

            if ($invitation->isValid()) {
                $invitation->code = md5($CONFIG->key . $code);
                $invitation->tsregister = time();
                $invitation->save();

                // Sending to mail
                $view = new Zend_View();
                $view->addHelperPath($CONFIG->dirroot . 'libs/Yeah/Helpers', 'Yeah_Helpers');
                $view->setScriptPath($CONFIG->dirroot . 'modules/invitations/views/scripts/invitation/');

                $view->url = $this->view->url(array('code' => $code), 'invitations_invitation_proceed');
                $view->message = $invitation->message;
                $view->user = $USER;
                $view->site = $CONFIG->site;

                $content = $view->render('mail.php');

                $mail = new Zend_Mail('UTF-8');
                $mail->setBodyHtml($content)
                     ->setFrom($CONFIG->email_direction, $CONFIG->email_name)
                     ->addTo($invitation->email)
                     ->setSubject($USER->label . ' te ha invitado a ' . $CONFIG->site)
                     ->send();

                $session->messages->addMessage('La invitación ha sido enviada al correo electronico');
                $this->_redirect($request->getParam('return'));
            } else {
                foreach ($invitation->getMessages() as $message) {
                    $session->messages->addMessage($message);
                }
            }

            $this->view->invitation = $invitation;
        }

        history('invitations/manager');
        breadcrumb(array(
            'Administrador de invitaciones' => $this->view->url(array(), 'invitations_manager'),
            'Nueva invitación' => $this->view->url(array(), 'invitations_new'),
        ));
    }
}
